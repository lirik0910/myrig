<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPageRequest extends FormRequest
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
			'title' => 'required|max:255|min:1',
			'description' => 'required|max:255|min:1',
			'link' => 'required|max:90|min:1',
			'parent_id' => 'required|digits_between:1,10|numeric',
			'context_id' => 'required|digits_between:1,10|numeric',
			'view_id' => 'required|digits_between:1,10|numeric'
		];
	}
}
