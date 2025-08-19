<?php

namespace App\Http\Requests;

use App\Models\WhatsAppSetup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreWhatsAppSetupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('whats_app_setup_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
            ],
        ];
    }
}
