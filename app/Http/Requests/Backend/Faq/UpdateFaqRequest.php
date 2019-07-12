<?php

namespace App\Http\Requests\Backend\Faq;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFaqRequest extends FormRequest {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return $this->user()->isAdmin();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {

		$rules = [];
		$rules['title'] = 'required';
		$rules['description'] = 'required';
		$rules['status'] = 'required';

		return $rules;
	}
}
