<?php

namespace App\Http\Requests;

use App\Models\SmsTemplate;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSmsTemplateRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sms_template_edit');
    }

    public function rules()
    {
        return [
            'template_name' => [
                'string',
                'required',
            ],
            'message' => [
                'required',
            ],
        ];
    }
}
