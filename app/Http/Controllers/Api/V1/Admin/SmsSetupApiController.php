<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSmsSetupRequest;
use App\Http\Requests\UpdateSmsSetupRequest;
use App\Http\Resources\Admin\SmsSetupResource;
use App\Models\SmsSetup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SmsSetupApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sms_setup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SmsSetupResource(SmsSetup::all());
    }

    public function store(StoreSmsSetupRequest $request)
    {
        $smsSetup = SmsSetup::create($request->all());

        return (new SmsSetupResource($smsSetup))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SmsSetup $smsSetup)
    {
        abort_if(Gate::denies('sms_setup_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SmsSetupResource($smsSetup);
    }

    public function update(UpdateSmsSetupRequest $request, SmsSetup $smsSetup)
    {
        $smsSetup->update($request->all());

        return (new SmsSetupResource($smsSetup))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SmsSetup $smsSetup)
    {
        abort_if(Gate::denies('sms_setup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $smsSetup->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
