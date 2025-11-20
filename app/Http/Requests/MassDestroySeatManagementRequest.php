<?php

namespace App\Http\Requests;

use App\Models\SeatManagement;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroySeatManagementRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('seat_management_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:seat_managements,id',
        ];
    }
}
