<?php

namespace App\Http\Requests;

use App\Models\EmailTemplate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmailTemplateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('email_template_create');
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
