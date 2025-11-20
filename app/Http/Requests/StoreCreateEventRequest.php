<?php

namespace App\Http\Requests;

use App\Models\CreateEvent;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCreateEventRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('create_event_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'nullable',
            ],
            'duration' => [
                'string',
                'nullable',
            ],
            'language' => [
                'string',
                'nullable',
            ],
            'age' => [
                'string',
                'nullable',
            ],
        ];
    }
}
