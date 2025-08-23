<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmailRequest;
use App\Http\Requests\StoreEmailRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Models\Contact;
use App\Models\Email;
use App\Models\EmailTemplate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Mail\CampaignMail;
use Illuminate\Support\Facades\Config;
use App\Models\Organizer;
use Illuminate\Support\Facades\Mail;
use App\Models\Wallet;

use App\Models\Transaction;
use App\Models\EmailSetup;


class EmailController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Email::with(['template', 'contacts'])
            ->where('created_by_id', auth()->id())
            ->select(sprintf('%s.*', (new Email)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'email_show';
                $editGate      = 'email_edit';
                $deleteGate    = 'email_delete';
                $crudRoutePart = 'emails';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('campaign_name', function ($row) {
                return $row->campaign_name ? $row->campaign_name : '';
            });
            $table->addColumn('template_template_name', function ($row) {
                return $row->template ? $row->template->template_name : '';
            });

            $table->editColumn('contacts', function ($row) {
                $labels = [];
                foreach ($row->contacts as $contact) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $contact->email);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('coins_used', function ($row) {
                return $row->coins_used ? $row->coins_used : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Email::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'template', 'contacts']);

            return $table->make(true);
        }

        return view('admin.emails.index');
    }

   public function create()
{
    abort_if(Gate::denies('email_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $templates = EmailTemplate::pluck('template_name', 'id')
        ->prepend(trans('global.pleaseSelect'), '');

    // Sirf current user ke contacts fetch karo
    $contacts = Contact::with('organizer')
        ->where('created_by_id', auth()->id())
        ->get();

    // Organizers list
    $organizers = Organizer::pluck('title', 'id');

    return view('admin.emails.create', compact('contacts', 'templates', 'organizers'));
}



public function store(StoreEmailRequest $request)
{
    $userId = auth()->id();

    // Get user wallet
    $wallet = Wallet::where('created_by_id', $userId)->first();

    if (!$wallet) {
        return redirect()->back()->with('error', 'Wallet not found! Please add coins.');
    }

    // Count selected contacts
    $contactCount = count($request->contacts);

    // Email cost per contact (0.1 coin per email)
    $coinsNeeded = $contactCount * 0.1;

    // Check balance
    if ($wallet->balance < $coinsNeeded) {
        return redirect()->back()->with('error', 'Insufficient balance! Please add coins.');
    }

    // ✅ Find active email setup for this user
    $mailConfig = EmailSetup::where('created_by_id', $userId)->where('status', 1)->first();
    if (!$mailConfig) {
        return redirect()->back()->with('error', 'No active email setup found!');
    }

    // ✅ Apply dynamic mail configuration
    Config::set('mail.mailers.smtp', [
        'transport'  => 'smtp',
        'host'       => $mailConfig->host,
        'port'       => $mailConfig->port,
        'encryption' => $mailConfig->encryption,
        'username'   => $mailConfig->username,
        'password'   => $mailConfig->password,
        'timeout'    => null,
        'auth_mode'  => null,
    ]);

    Config::set('mail.from', [
        'address' => $mailConfig->from_email,
        'name'    => $mailConfig->from_name,
    ]);

    // ✅ Create email campaign record
    $email = Email::create($request->all() + [
        'created_by_id' => $userId,
        'coins_used'    => $coinsNeeded,
    ]);

    $email->contacts()->sync($request->input('contacts', []));

    // Deduct coins from wallet
    $wallet->balance -= $coinsNeeded;
    $wallet->save();

    // ✅ Add Transaction Record
    Transaction::create([
        'type'           => 'debit',
        'amount'         => $coinsNeeded,
        'balance_after'  => $wallet->balance,
        'description'    => "Coins deducted for Email Campaign: {$email->campaign_name}",
        'reference_id'   => $email->id,
        'reference_type' => Email::class,
        'created_by_id'  => $userId,
    ]);

    // Get template and contacts
    $template = EmailTemplate::find($request->template_id);
    $contacts = Contact::whereIn('id', $request->contacts)->get();

    if (!$template) {
        return redirect()->back()->with('error', 'Email template not found!');
    }

    if ($contacts->isEmpty()) {
        return redirect()->back()->with('error', 'No contacts selected!');
    }

    $successCount = 0;
    $errorCount   = 0;
    $errors       = [];

    foreach ($contacts as $contact) {
        try {
            Mail::to($contact->email)->send(new CampaignMail($template, $contact));
            $successCount++;
            usleep(100000); // 0.1 sec delay
        } catch (\Exception $e) {
            $errorCount++;
            $errors[] = "Failed to send to {$contact->email}: " . $e->getMessage();
            \Log::error('Mail error for ' . $contact->email . ': ' . $e->getMessage());
        }
    }

    // ✅ Update email campaign status
    $status = $errorCount > 0 
                ? ($successCount > 0 ? 'partially_failed' : 'failed') 
                : 'completed';

    $email->update(['status' => $status]);

    $message = "Emails sent successfully! {$successCount} sent, {$errorCount} failed.";

    if (!empty($errors)) {
        \Log::info('Email sending errors: ', $errors);
    }

    return redirect()->route('admin.emails.index')->with('success', $message);
}

    public function edit(Email $email)
    {
        abort_if(Gate::denies('email_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $templates = EmailTemplate::pluck('template_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $contacts = Contact::pluck('email', 'id');

        $email->load('template', 'contacts');

        return view('admin.emails.edit', compact('contacts', 'email', 'templates'));
    }

    public function update(UpdateEmailRequest $request, Email $email)
    {
        $email->update($request->all());
        $email->contacts()->sync($request->input('contacts', []));

        return redirect()->route('admin.emails.index');
    }

    public function show(Email $email)
    {
        abort_if(Gate::denies('email_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $email->load('template', 'contacts');

        return view('admin.emails.show', compact('email'));
    }

    public function destroy(Email $email)
    {
        abort_if(Gate::denies('email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $email->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmailRequest $request)
    {
        $emails = Email::find(request('ids'));

        foreach ($emails as $email) {
            $email->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function getContacts($id)
{
    $query = Contact::with('organizer')
        ->where('created_by_id', auth()->id());

    if ($id !== "all") {
        $query->where('organizer_id', $id);
    }

    $contacts = $query->get();

    return response()->json($contacts);
}

}


