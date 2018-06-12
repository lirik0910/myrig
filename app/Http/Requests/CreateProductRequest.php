<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
			'articul' => 'required|max:255|min:1',
			'page_id' => 'digits_between:1,10|numeric',
			'context_id' => 'required|digits_between:1,10|numeric',
			'product_status_id' => 'required|digits_between:1,10|numeric',
			'images' => 'json',
			'options' => 'json',
		];
	}
}
