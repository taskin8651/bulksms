<?php

namespace App\Http\Requests;

use App\Models\Email;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('email_create');
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
