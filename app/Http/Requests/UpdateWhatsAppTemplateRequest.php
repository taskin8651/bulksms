<?php

namespace App\Http\Requests;

use App\Models\WhatsAppTemplate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWhatsAppTemplateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('whats_app_template_edit');
    }

    public function rules()
    {
        return [
            'template_name' => [
                'string',
                'required',
            ],
            'subject' => [
                'string',
                'required',
            ],
            'body' => [
                'required',
            ],
        ];
    }
}
