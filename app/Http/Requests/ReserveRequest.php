<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Reserve;

class ReserveRequest extends FormRequest
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
            'menu_id' => ['required', Rule::in(\Constant::MENU_STATUS_ARRAY)],
            // 'start_date' => ['required', Rule::in(\Constant::MENU_STATUS_ARRAY)],
            // 'end_date' => ['required', Rule::in(\Constant::MENU_STATUS_ARRAY)],
        ];
    }
}
