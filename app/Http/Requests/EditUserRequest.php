<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
			'name' => 'required|max:191|min:1',
			'email' => 'required|max:191|min:1',
			'policy_id' => 'required|digits_between:1,10|numeric',
			'new_password' => 'max:191|min:0',
			'confirm_password' => 'max:191|min:0',
		];
	}
}
