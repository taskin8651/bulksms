<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyWhatsAppSetupRequest;
use App\Http\Requests\StoreWhatsAppSetupRequest;
use App\Http\Requests\UpdateWhatsAppSetupRequest;
use App\Models\WhatsAppSetup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WhatsAppSetupController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
{
    abort_if(Gate::denies('whats_app_setup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    // Normal pagination (no datatable)
    $setups = WhatsAppSetup::orderBy('id', 'desc')->paginate(25);

    return view('admin.whatsAppSetups.index', compact('setups'));
}


   public function create()
{
    abort_if(Gate::denies('whats_app_setup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $provider_names = WhatsAppSetup::PROVIDER_NAME_SELECT;

    return view('admin.whatsAppSetups.create', compact('provider_names'));
}

public function store(StoreWhatsAppSetupRequest $request)
{
    $data = $request->all();
    $data['created_by_id'] = auth()->id();

    WhatsAppSetup::create($data);

    return redirect()->route('admin.whats-app-setups.index')
        ->with('success', 'WhatsApp Setup Created Successfully');
}


   public function edit(WhatsAppSetup $whatsAppSetup)
{
    abort_if(Gate::denies('whats_app_setup_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    return view('admin.whatsAppSetups.edit', compact('whatsAppSetup'));
}

public function update(UpdateWhatsAppSetupRequest $request, WhatsAppSetup $whatsAppSetup)
{
    // Only fillable fields update होंगे
    $whatsAppSetup->update($request->validated());

    return redirect()
        ->route('admin.whats-app-setups.index')
        ->with('success', 'WhatsApp setup updated successfully');
}

    public function show(WhatsAppSetup $whatsAppSetup)
    {
        abort_if(Gate::denies('whats_app_setup_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.whatsAppSetups.show', compact('whatsAppSetup'));
    }

    public function destroy(WhatsAppSetup $whatsAppSetup)
    {
        abort_if(Gate::denies('whats_app_setup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsAppSetup->delete();

        return back();
    }

    public function massDestroy(MassDestroyWhatsAppSetupRequest $request)
    {
        $whatsAppSetups = WhatsAppSetup::find(request('ids'));

        foreach ($whatsAppSetups as $whatsAppSetup) {
            $whatsAppSetup->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
