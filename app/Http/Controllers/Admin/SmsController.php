<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySmsRequest;
use App\Http\Requests\StoreSmsRequest;
use App\Http\Requests\UpdateSmsRequest;
use App\Models\Contact;
use App\Models\Sms;
use App\Models\SmsTemplate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Services\SmsGatewayService;

class SmsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('sms_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Sms::with(['template', 'contacts'])->select(sprintf('%s.*', (new Sms)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'sms_show';
                $editGate      = 'sms_edit';
                $deleteGate    = 'sms_delete';
                $crudRoutePart = 'smss';

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
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $contact->phone_number);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('coins_used', function ($row) {
                return $row->coins_used ? $row->coins_used : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Sms::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'template', 'contacts']);

            return $table->make(true);
        }

        return view('admin.smss.index');
    }

    public function create()
    {
        abort_if(Gate::denies('sms_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $templates = SmsTemplate::pluck('template_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $contacts = Contact::pluck('phone_number', 'id');

        return view('admin.smss.create', compact('contacts', 'templates'));
    }

   public function store(StoreSmsRequest $request)
{
    $sms = Sms::create($request->all());
    $sms->contacts()->sync($request->input('contacts', []));
    // सभी contacts पर message भेजो
    foreach ($sms->contacts as $contact) {
        $message = $sms->template->content ?? "Default message";
        SmsGatewayService::send($contact->phone_number, $message);
    }

    return redirect()->route('admin.smss.index');
}
    public function edit(Sms $sms)
    {
        abort_if(Gate::denies('sms_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $templates = SmsTemplate::pluck('template_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $contacts = Contact::pluck('phone_number', 'id');

        $sms->load('template', 'contacts');

        return view('admin.smss.edit', compact('contacts', 'sms', 'templates'));
    }

    public function update(UpdateSmsRequest $request, Sms $sms)
    {
        $sms->update($request->all());
        $sms->contacts()->sync($request->input('contacts', []));

        return redirect()->route('admin.smss.index');
    }

    public function show(Sms $sms)
    {
        abort_if(Gate::denies('sms_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sms->load('template', 'contacts');

        return view('admin.smss.show', compact('sms'));
    }

    public function destroy(Sms $sms)
    {
        abort_if(Gate::denies('sms_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sms->delete();

        return back();
    }

    public function massDestroy(MassDestroySmsRequest $request)
    {
        $smss = Sms::find(request('ids'));

        foreach ($smss as $sms) {
            $sms->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
