<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyWhatsAppRequest;
use App\Http\Requests\StoreWhatsAppRequest;
use App\Http\Requests\UpdateWhatsAppRequest;
use App\Models\Contact;
use App\Models\WhatsApp;
use App\Models\WhatsAppTemplate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Jobs\SendWhatsAppBulkMessage;

class WhatsAppController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('whats_app_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WhatsApp::with(['template', 'contacts'])->select(sprintf('%s.*', (new WhatsApp)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'whats_app_show';
                $editGate      = 'whats_app_edit';
                $deleteGate    = 'whats_app_delete';
                $crudRoutePart = 'whats-apps';

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
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $contact->whatsapp_number);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('coins_used', function ($row) {
                return $row->coins_used ? $row->coins_used : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? WhatsApp::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'template', 'contacts']);

            return $table->make(true);
        }

        return view('admin.whatsApps.index');
    }

   public function create()
    {
        abort_if(Gate::denies('whats_app_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $templates = WhatsAppTemplate::pluck('template_name', 'id')
            ->prepend('Please select', '');

        $contacts = Contact::pluck('whatsapp_number', 'id');

        return view('admin.whatsApps.create', compact('contacts', 'templates'));
    }

    public function store(StoreWhatsAppRequest $request)
    {
        // Create WhatsApp campaign
        $whatsApp = WhatsApp::create($request->validated());

        // Attach selected contacts
        $whatsApp->contacts()->sync($request->input('contacts', []));

        // Dispatch background job to send messages
        SendWhatsAppBulkMessage::dispatch($whatsApp);

        return redirect()->route('admin.whats-apps.index')
            ->with('success', 'WhatsApp campaign created and queued for sending.');
    }

   public function edit(WhatsApp $whatsApp)
{
    abort_if(Gate::denies('whats_app_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $templates = WhatsAppTemplate::pluck('template_name', 'id')
        ->prepend(trans('global.pleaseSelect'), '');

    $contacts = Contact::pluck('whatsapp_number', 'id');

    $whatsApp->load('contacts');

    return view('admin.whatsApps.edit', compact('whatsApp', 'contacts', 'templates'));
}

public function update(UpdateWhatsAppRequest $request, WhatsApp $whatsApp)
{
    $whatsApp->update($request->validated());

    $whatsApp->contacts()->sync($request->input('contacts', []));

    return redirect()->route('admin.whats-apps.index')
        ->with('success', 'WhatsApp campaign updated successfully.');
}


    public function show(WhatsApp $whatsApp)
    {
        abort_if(Gate::denies('whats_app_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsApp->load('template', 'contacts');

        return view('admin.whatsApps.show', compact('whatsApp'));
    }

    public function destroy(WhatsApp $whatsApp)
    {
        abort_if(Gate::denies('whats_app_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsApp->delete();

        return back();
    }

    public function massDestroy(MassDestroyWhatsAppRequest $request)
    {
        $whatsApps = WhatsApp::find(request('ids'));

        foreach ($whatsApps as $whatsApp) {
            $whatsApp->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
