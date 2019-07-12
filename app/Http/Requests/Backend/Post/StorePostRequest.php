<?php

namespace App\Http\Requests\Backend\Post;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest {
	
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
		$rules['description'] = 'required';	
		$rules['user'] = 'required';

		return $rules;
	}
}
