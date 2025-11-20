<?php

namespace App\Http\Requests;

use App\Models\BookinSeat;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBookinSeatRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('bookin_seat_edit');
    }

    public function rules()
    {
        return [
            'seat_code' => [
                'string',
                'nullable',
            ],
            'row' => [
                'string',
                'nullable',
            ],
            'column' => [
                'string',
                'nullable',
            ],
            'price' => [
                'string',
                'nullable',
            ],
        ];
    }
}
