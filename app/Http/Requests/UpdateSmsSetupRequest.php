<?php

namespace App\Http\Requests;

use App\Models\SmsSetup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateSmsSetupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('sms_setup_edit');
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
