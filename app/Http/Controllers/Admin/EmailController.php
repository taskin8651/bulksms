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

    // All templates
    $templates = EmailTemplate::pluck('template_name', 'id')
        ->prepend(trans('global.pleaseSelect'), '');

    // Fetch only user's contacts
    $contacts = Contact::with('organizer')
        ->where('created_by_id', auth()->id())
        ->get();

    return view('admin.emails.create', compact('contacts', 'templates'));
}


public function store(StoreEmailRequest $request)
{
    $userId = auth()->id();

    // Get Active Email Setup
    $mailConfig = EmailSetup::where('created_by_id', $userId)
        ->where('status', 1)
        ->first();

    if (!$mailConfig) {
        return back()->with('error', 'No active email setup found!');
    }

    // Apply Dynamic SMTP Settings
    Config::set('mail.mailers.dynamic_smtp', [
        'transport'  => 'smtp',
        'host'       => $mailConfig->host,
        'port'       => (int) $mailConfig->port,
        'encryption' => $mailConfig->encryption ?: null,
        'username'   => $mailConfig->username,
        'password'   => $mailConfig->password,
        'timeout'    => 10,
    ]);
// dd(['mailConfig' => $mailConfig]);
    // Set FROM email
    Config::set('mail.from.address', $mailConfig->from_email);
    Config::set('mail.from.name', $mailConfig->from_name);

    // Create Email Campaign
    $email = Email::create($request->all() + [
        'created_by_id' => $userId,
        'status'        => 'pending',
    ]);

    $email->contacts()->sync($request->input('contacts', []));

    // Template + Contacts
    $template = EmailTemplate::find($request->template_id);
    $contacts = Contact::whereIn('id', $request->contacts)->get();

    if (!$template) {
        return back()->with('error', 'Email template not found!');
    }

    if ($contacts->isEmpty()) {
        return back()->with('error', 'No contacts selected!');
    }
    

    // Sending
    $successCount = 0;
    $errorCount   = 0;
    $errors       = [];

    foreach ($contacts as $contact) {

        try {

            Mail::mailer('dynamic_smtp')            // 💥 IMPORTANT: custom mailer
                ->to($contact->email)
                ->send(new CampaignMail($template, $contact));

            $successCount++;

            usleep(100000); // 0.1 sec delay

        } catch (\Exception $e) {
            $errorCount++;
            $errors[] = "Failed to send to {$contact->email}: " . $e->getMessage();
        }
    }

    // Final Status
    $status = $errorCount > 0
                ? ($successCount > 0 ? 'partially_failed' : 'failed')
                : 'completed';

    $email->update(['status' => $status]);

    $msg = "Emails processed! Sent: {$successCount}, Failed: {$errorCount}";
// dd($msg);
    // Optional: Show errors if any
    if (!empty($errors)) {
        return redirect()->route('admin.emails.index')
            ->with('error', implode("<br>", $errors));
    }

    return redirect()->route('admin.emails.index')->with('success', $msg);
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


