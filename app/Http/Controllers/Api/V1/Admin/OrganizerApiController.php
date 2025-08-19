<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreOrganizerRequest;
use App\Http\Requests\UpdateOrganizerRequest;
use App\Http\Resources\Admin\OrganizerResource;
use App\Models\Organizer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganizerApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('organizer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OrganizerResource(Organizer::all());
    }

    public function store(StoreOrganizerRequest $request)
    {
        $organizer = Organizer::create($request->all());

        return (new OrganizerResource($organizer))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Organizer $organizer)
    {
        abort_if(Gate::denies('organizer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OrganizerResource($organizer);
    }

    public function update(UpdateOrganizerRequest $request, Organizer $organizer)
    {
        $organizer->update($request->all());

        return (new OrganizerResource($organizer))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Organizer $organizer)
    {
        abort_if(Gate::denies('organizer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $organizer->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
