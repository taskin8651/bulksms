<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyEmailSetupRequest;
use App\Http\Requests\StoreEmailSetupRequest;
use App\Http\Requests\UpdateEmailSetupRequest;
use App\Models\EmailSetup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmailSetupController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('email_setup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmailSetup::query()->select(sprintf('%s.*', (new EmailSetup)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'email_setup_show';
                $editGate      = 'email_setup_edit';
                $deleteGate    = 'email_setup_delete';
                $crudRoutePart = 'email-setups';

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
            $table->editColumn('provider_name', function ($row) {
                return $row->provider_name ? EmailSetup::PROVIDER_NAME_SELECT[$row->provider_name] : '';
            });
            $table->editColumn('from_name', function ($row) {
                return $row->from_name ? $row->from_name : '';
            });
            $table->editColumn('from_email', function ($row) {
                return $row->from_email ? $row->from_email : '';
            });
            $table->editColumn('host', function ($row) {
                return $row->host ? $row->host : '';
            });
            $table->editColumn('port', function ($row) {
                return $row->port ? $row->port : '';
            });
            $table->editColumn('username', function ($row) {
                return $row->username ? $row->username : '';
            });
            $table->editColumn('password', function ($row) {
                return $row->password ? $row->password : '';
            });
            $table->editColumn('encryption', function ($row) {
                return $row->encryption ? $row->encryption : '';
            });
            $table->editColumn('ip_address', function ($row) {
                return $row->ip_address ? $row->ip_address : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.emailSetups.index');
    }

    public function create()
    {
        abort_if(Gate::denies('email_setup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.emailSetups.create');
    }

    public function store(StoreEmailSetupRequest $request)
    {
        $emailSetup = EmailSetup::create($request->all());

        return redirect()->route('admin.email-setups.index');
    }

    public function edit(EmailSetup $emailSetup)
    {
        abort_if(Gate::denies('email_setup_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.emailSetups.edit', compact('emailSetup'));
    }

    public function update(UpdateEmailSetupRequest $request, EmailSetup $emailSetup)
    {
        $emailSetup->update($request->all());

        return redirect()->route('admin.email-setups.index');
    }

    public function show(EmailSetup $emailSetup)
    {
        abort_if(Gate::denies('email_setup_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.emailSetups.show', compact('emailSetup'));
    }

    public function destroy(EmailSetup $emailSetup)
    {
        abort_if(Gate::denies('email_setup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $emailSetup->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmailSetupRequest $request)
    {
        $emailSetups = EmailSetup::find(request('ids'));

        foreach ($emailSetups as $emailSetup) {
            $emailSetup->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
