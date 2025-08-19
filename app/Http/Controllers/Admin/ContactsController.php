<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyContactRequest;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ContactsController extends Controller
{
    use CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Contact::query()->select(sprintf('%s.*', (new Contact)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'contact_show';
                $editGate      = 'contact_edit';
                $deleteGate    = 'contact_delete';
                $crudRoutePart = 'contacts';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('phone_number', function ($row) {
                return $row->phone_number ? $row->phone_number : '';
            });
            $table->editColumn('whatsapp_number', function ($row) {
                return $row->whatsapp_number ? $row->whatsapp_number : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Contact::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('organization', function ($row) {
                return $row->organization ? Contact::ORGANIZATION_SELECT[$row->organization] : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.contacts.index');
    }

    public function create()
    {
        abort_if(Gate::denies('contact_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contacts.create');
    }

    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create($request->all());

        return redirect()->route('admin.contacts.index');
    }

    public function edit(Contact $contact)
    {
        abort_if(Gate::denies('contact_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contacts.edit', compact('contact'));
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact->update($request->all());

        return redirect()->route('admin.contacts.index');
    }

    public function show(Contact $contact)
    {
        abort_if(Gate::denies('contact_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        abort_if(Gate::denies('contact_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contact->delete();

        return back();
    }

    public function massDestroy(MassDestroyContactRequest $request)
    {
        $contacts = Contact::find(request('ids'));

        foreach ($contacts as $contact) {
            $contact->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
