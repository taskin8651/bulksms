<?php

namespace App\Http\Requests;

use App\Models\WhatsApp;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateWhatsAppRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('whats_app_edit');
    }

    public function rules()
    {
        return [
            'campaign_name' => [
                'string',
                'required',
            ],
            'template_id' => [
                'required',
                'integer',
            ],
            'contacts.*' => [
                'integer',
            ],
            'contacts' => [
                'required',
                'array',
            ],
            'coins_used' => [
                'string',
                'nullable',
            ],
        ];
    }
}
