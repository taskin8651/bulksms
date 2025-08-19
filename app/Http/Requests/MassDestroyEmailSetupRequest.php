<?php

namespace App\Http\Requests;

use App\Models\EmailSetup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEmailSetupRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('email_setup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:email_setups,id',
        ];
    }
}
