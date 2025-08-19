<?php

namespace App\Http\Requests;

use App\Models\Organizer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOrganizerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('organizer_create');
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
