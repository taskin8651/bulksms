<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Http\Resources\Admin\ContactResource;
use App\Models\Contact;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactsApiController extends Controller
{
    public function index(Request $request)
{
    $user = $request->user(); // logged-in user

    $contacts = Contact::where('created_by_id', $user->id)->get();

    return response()->json([
        'data' => $contacts
    ]);
}

   public function store(StoreContactRequest $request)
{
    $data = $request->all();

    // Agar user login hai, created_by_id set karo
    if (auth()->check()) {
        $data['created_by_id'] = auth()->id();
    }

    // Status default active
    $data['status'] = 'active';

    $contact = Contact::create($data);

    return response()->json([
        'message' => 'Contact created successfully',
        'data' => $contact
    ], 201);
}


    public function show(Contact $contact)
    {
        abort_if(Gate::denies('contact_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ContactResource($contact);
    }

    public function update(UpdateContactRequest $request, Contact $contact)
    {
        $contact->update($request->all());

        return (new ContactResource($contact))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Contact $contact)
    {
        abort_if(Gate::denies('contact_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contact->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
