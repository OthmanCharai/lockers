<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LockerStoreRequest extends FormRequest
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
            'level' => ['required', 'string'],
            'location' => ['required', 'string'],
            'locker_number' => ['required', 'string'],
            'status' => ['required', 'in:pending,successful,failed'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }
}
