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
use App\Models\WhatsAppMessageLog;
use App\Models\WhatsAppSetup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Jobs\SendWhatsAppBulkMessage;
use Illuminate\Support\Facades\Auth;




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
    // 🔥 Logged-in user ka ACTIVE WhatsApp setup
    $setup = WhatsAppSetup::where('created_by_id', Auth::id())
        ->where('status', 1)
        ->first();

    if (!$setup) {
        return back()->withErrors([
            'whatsapp_setup' => 'Active WhatsApp setup not found for this user.'
        ]);
    }

    // 🔹 Create WhatsApp campaign
    $whatsApp = WhatsApp::create(array_merge(
        $request->validated(),
        [
            'created_by_id'     => Auth::id(),
            'status'            => 'running',
            'whatsapp_setup_id' => $setup->id, // 🔥 AUTO ASSIGNED
        ]
    ));

    // 🔹 Attach contacts
    $whatsApp->contacts()->sync($request->input('contacts', []));

    // 🔥 Create message logs
    foreach ($whatsApp->contacts as $contact) {
        WhatsAppMessageLog::create([
            'whatsapp_id'   => $whatsApp->id,
            'contact_id'    => $contact->id,
            'message'       => $whatsApp->template->body,
            'status'        => 'pending',
            'created_by_id' => Auth::id(),
        ]);
    }

    // 🔹 Dispatch job (ID pass karo)
    SendWhatsAppBulkMessage::dispatch($whatsApp->id);

    return redirect()->route('admin.whats-apps.index')
        ->with('success', 'WhatsApp campaign created and queued.');
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

   public function logs($whatsappId)
{
    $whatsApp = WhatsApp::where('id', $whatsappId)
        ->where('created_by_id', auth()->id())
        ->firstOrFail();

    $logs = WhatsAppMessageLog::with('contact')
        ->where('whatsapp_id', $whatsappId)
        ->where('created_by_id', auth()->id())
        ->orderBy('id', 'desc')
        ->get();

        $summary = WhatsAppMessageLog::where('whatsapp_id', $whatsApp->id)
    ->selectRaw("
        COUNT(*) as total,
        SUM(status='sent') as sent,
        SUM(status='failed') as failed,
        SUM(status='pending') as pending
    ")
    ->first();

    return view('admin.whatsApps.logs', compact('logs', 'whatsApp', 'summary'));
}

}
