<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWhatsAppSetupRequest;
use App\Http\Requests\UpdateWhatsAppSetupRequest;
use App\Http\Resources\Admin\WhatsAppSetupResource;
use App\Models\WhatsAppSetup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhatsAppSetupApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('whats_app_setup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WhatsAppSetupResource(WhatsAppSetup::all());
    }

    public function store(StoreWhatsAppSetupRequest $request)
    {
        $whatsAppSetup = WhatsAppSetup::create($request->all());

        return (new WhatsAppSetupResource($whatsAppSetup))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WhatsAppSetup $whatsAppSetup)
    {
        abort_if(Gate::denies('whats_app_setup_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WhatsAppSetupResource($whatsAppSetup);
    }

    public function update(UpdateWhatsAppSetupRequest $request, WhatsAppSetup $whatsAppSetup)
    {
        $whatsAppSetup->update($request->all());

        return (new WhatsAppSetupResource($whatsAppSetup))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WhatsAppSetup $whatsAppSetup)
    {
        abort_if(Gate::denies('whats_app_setup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsAppSetup->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
