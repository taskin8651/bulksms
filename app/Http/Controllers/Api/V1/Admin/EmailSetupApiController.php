<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmailSetupRequest;
use App\Http\Requests\UpdateEmailSetupRequest;
use App\Http\Resources\Admin\EmailSetupResource;
use App\Models\EmailSetup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmailSetupApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('email_setup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmailSetupResource(EmailSetup::all());
    }

    public function store(StoreEmailSetupRequest $request)
    {
        $emailSetup = EmailSetup::create($request->all());

        return (new EmailSetupResource($emailSetup))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmailSetup $emailSetup)
    {
        abort_if(Gate::denies('email_setup_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmailSetupResource($emailSetup);
    }

    public function update(UpdateEmailSetupRequest $request, EmailSetup $emailSetup)
    {
        $emailSetup->update($request->all());

        return (new EmailSetupResource($emailSetup))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmailSetup $emailSetup)
    {
        abort_if(Gate::denies('email_setup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $emailSetup->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
