<?php

namespace App\Http\Requests;

use App\Models\EmailSetup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreEmailSetupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('email_setup_create');
    }

    public function rules()
    {
        return [
            'provider_name' => [
                'required',
            ],
            'from_name' => [
                'string',
                'nullable',
            ],
            'from_email' => [
                'string',
                'required',
            ],
            'host' => [
                'string',
                'nullable',
            ],
            'port' => [
                'string',
                'nullable',
            ],
            'username' => [
                'string',
                'nullable',
            ],
            'password' => [
                'string',
                'nullable',
            ],
            'encryption' => [
                'string',
                'nullable',
            ],
            'ip_address' => [
                'string',
                'nullable',
            ],
            'status' => [
                'string',
                'nullable',
            ],
        ];
    }
}
