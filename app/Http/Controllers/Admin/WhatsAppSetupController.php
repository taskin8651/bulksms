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

        if ($request->ajax()) {
            $query = WhatsAppSetup::query()->select(sprintf('%s.*', (new WhatsAppSetup)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'whats_app_setup_show';
                $editGate      = 'whats_app_setup_edit';
                $deleteGate    = 'whats_app_setup_delete';
                $crudRoutePart = 'whats-app-setups';

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
            $table->editColumn('title', function ($row) {
                return $row->title ? $row->title : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.whatsAppSetups.index');
    }

    public function create()
    {
        abort_if(Gate::denies('whats_app_setup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.whatsAppSetups.create');
    }

    public function store(StoreWhatsAppSetupRequest $request)
    {
        $whatsAppSetup = WhatsAppSetup::create($request->all());

        return redirect()->route('admin.whats-app-setups.index');
    }

    public function edit(WhatsAppSetup $whatsAppSetup)
    {
        abort_if(Gate::denies('whats_app_setup_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.whatsAppSetups.edit', compact('whatsAppSetup'));
    }

    public function update(UpdateWhatsAppSetupRequest $request, WhatsAppSetup $whatsAppSetup)
    {
        $whatsAppSetup->update($request->all());

        return redirect()->route('admin.whats-app-setups.index');
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
