<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWhatsAppRequest;
use App\Http\Requests\UpdateWhatsAppRequest;
use App\Http\Resources\Admin\WhatsAppResource;
use App\Models\WhatsApp;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhatsAppApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('whats_app_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WhatsAppResource(WhatsApp::with(['template', 'contacts'])->get());
    }

    public function store(StoreWhatsAppRequest $request)
    {
        $whatsApp = WhatsApp::create($request->all());
        $whatsApp->contacts()->sync($request->input('contacts', []));

        return (new WhatsAppResource($whatsApp))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WhatsApp $whatsApp)
    {
        abort_if(Gate::denies('whats_app_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WhatsAppResource($whatsApp->load(['template', 'contacts']));
    }

    public function update(UpdateWhatsAppRequest $request, WhatsApp $whatsApp)
    {
        $whatsApp->update($request->all());
        $whatsApp->contacts()->sync($request->input('contacts', []));

        return (new WhatsAppResource($whatsApp))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WhatsApp $whatsApp)
    {
        abort_if(Gate::denies('whats_app_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsApp->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
