<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySmsSetupRequest;
use App\Http\Requests\StoreSmsSetupRequest;
use App\Http\Requests\UpdateSmsSetupRequest;
use App\Models\SmsSetup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SmsSetupController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('sms_setup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = SmsSetup::query()->select(sprintf('%s.*', (new SmsSetup)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'sms_setup_show';
                $editGate      = 'sms_setup_edit';
                $deleteGate    = 'sms_setup_delete';
                $crudRoutePart = 'sms-setups';

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

        return view('admin.smsSetups.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sms_setup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.smsSetups.create');
    }

    public function store(StoreSmsSetupRequest $request)
    {
        $smsSetup = SmsSetup::create($request->all());

        return redirect()->route('admin.sms-setups.index');
    }

    public function edit(SmsSetup $smsSetup)
    {
        abort_if(Gate::denies('sms_setup_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.smsSetups.edit', compact('smsSetup'));
    }

    public function update(UpdateSmsSetupRequest $request, SmsSetup $smsSetup)
    {
        $smsSetup->update($request->all());

        return redirect()->route('admin.sms-setups.index');
    }

    public function show(SmsSetup $smsSetup)
    {
        abort_if(Gate::denies('sms_setup_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.smsSetups.show', compact('smsSetup'));
    }

    public function destroy(SmsSetup $smsSetup)
    {
        abort_if(Gate::denies('sms_setup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $smsSetup->delete();

        return back();
    }

    public function massDestroy(MassDestroySmsSetupRequest $request)
    {
        $smsSetups = SmsSetup::find(request('ids'));

        foreach ($smsSetups as $smsSetup) {
            $smsSetup->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
