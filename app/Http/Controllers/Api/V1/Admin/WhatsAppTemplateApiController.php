<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreWhatsAppTemplateRequest;
use App\Http\Requests\UpdateWhatsAppTemplateRequest;
use App\Http\Resources\Admin\WhatsAppTemplateResource;
use App\Models\WhatsAppTemplate;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhatsAppTemplateApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('whats_app_template_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WhatsAppTemplateResource(WhatsAppTemplate::all());
    }

    public function store(StoreWhatsAppTemplateRequest $request)
    {
        $whatsAppTemplate = WhatsAppTemplate::create($request->all());

        return (new WhatsAppTemplateResource($whatsAppTemplate))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WhatsAppTemplate $whatsAppTemplate)
    {
        abort_if(Gate::denies('whats_app_template_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WhatsAppTemplateResource($whatsAppTemplate);
    }

    public function update(UpdateWhatsAppTemplateRequest $request, WhatsAppTemplate $whatsAppTemplate)
    {
        $whatsAppTemplate->update($request->all());

        return (new WhatsAppTemplateResource($whatsAppTemplate))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WhatsAppTemplate $whatsAppTemplate)
    {
        abort_if(Gate::denies('whats_app_template_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $whatsAppTemplate->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
