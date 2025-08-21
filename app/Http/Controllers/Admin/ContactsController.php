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
        $query = Contact::with(['organizer'])
        ->where('created_by_id', auth()->id())
        ->select(sprintf('%s.*', (new Contact)->table));
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

        $table->editColumn('id', fn($row) => $row->id ?: '');
        $table->editColumn('name', fn($row) => $row->name ?: '');
        $table->editColumn('email', fn($row) => $row->email ?: '');
        $table->editColumn('phone_number', fn($row) => $row->phone_number ?: '');
        $table->editColumn('whatsapp_number', fn($row) => $row->whatsapp_number ?: '');
        $table->editColumn('status', fn($row) => $row->status ? Contact::STATUS_SELECT[$row->status] : '');

        // 👇 organizer relation
        $table->addColumn('organizer', fn($row) => $row->organizer ? $row->organizer->title : '');

        $table->rawColumns(['actions', 'placeholder']);

        return $table->make(true);
    }

    return view('admin.contacts.index');
}


   public function create()
{
    abort_if(Gate::denies('contact_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $organizers = \App\Models\Organizer::pluck('title', 'id'); // title field use ho rahi hai

    return view('admin.contacts.create', compact('organizers'));
}

    public function store(StoreContactRequest $request)
    {
        $data = $request->all();
    $data['created_by_id'] = auth()->id();

    Contact::create($data);

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
