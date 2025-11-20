<?php

namespace App\Http\Requests;

use App\Models\SeatManagement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSeatManagementRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('seat_management_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'rows' => [
                'string',
                'nullable',
            ],
            'columns' => [
                'string',
                'nullable',
            ],
        ];
    }
}
