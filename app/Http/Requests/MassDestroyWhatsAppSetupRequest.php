<?php

namespace App\Http\Requests;

use App\Models\WhatsAppSetup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWhatsAppSetupRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('whats_app_setup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:whats_app_setups,id',
        ];
    }
}
