<?php

namespace App\Http\Requests;

use App\Models\WhatsAppTemplate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyWhatsAppTemplateRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('whats_app_template_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:whats_app_templates,id',
        ];
    }
}
