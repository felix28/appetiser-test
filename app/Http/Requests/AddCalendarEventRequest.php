<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCalendarEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'       => 'required|string',
            'month'      => 'required|integer|between:1,12',
            'year'       => 'required|integer|between:2020,2022',
            'days'       => 'required|array|min:1',
            'days.*'     => 'required|string|distinct|min:1',
        ];
    }
}
