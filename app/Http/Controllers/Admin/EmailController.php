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
use App\Models\Organizer;
use Illuminate\Support\Facades\Mail;


class EmailController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Email::with(['template', 'contacts'])->select(sprintf('%s.*', (new Email)->table));
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

    // Get all contacts with their organizers
    $contacts = Contact::with('organizer')->get();

    // Get all organizers for the filter dropdown
    $organizers = Organizer::pluck('title', 'id');

    return view('admin.emails.create', compact('contacts', 'templates', 'organizers'));
}


public function store(StoreEmailRequest $request)
{
    $email = Email::create($request->all());
    $email->contacts()->sync($request->input('contacts', []));

    // Get template and contacts
    $template = EmailTemplate::find($request->template_id);
    $contacts = Contact::whereIn('id', $request->contacts)->get();

    // Check if template exists
    if (!$template) {
        return redirect()->back()->with('error', 'Email template not found!');
    }

    // Check if there are contacts
    if ($contacts->isEmpty()) {
        return redirect()->back()->with('error', 'No contacts selected!');
    }

    $successCount = 0;
    $errorCount = 0;
    $errors = [];
    // dd($template, $contacts);

    foreach ($contacts as $contact) {
        try {
            // Send email to each contact
            Mail::to($contact->email)->send(new CampaignMail($template, $contact));
            $successCount++;
            
            // Add a small delay to avoid overwhelming the SMTP server
            usleep(100000); // 0.1 second delay
            
        } catch (\Exception $e) {
            $errorCount++;
            $errors[] = "Failed to send to {$contact->email}: " . $e->getMessage();
            \Log::error('Mail error for ' . $contact->email . ': ' . $e->getMessage());
        }
    }

    // Update email status based on results
    $status = $errorCount > 0 ? ($successCount > 0 ? 'partially_failed' : 'failed') : 'completed';
    $email->update(['status' => $status]);
    // Prepare response message
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
    if ($id === "all") {
        $contacts = Contact::with('organizer')->get();
    } else {
        $contacts = Contact::with('organizer')
                    ->where('organizer_id', $id)
                    ->get();
    }

    return response()->json($contacts);
}

}


