<?php

namespace App\Http\Requests\Backend\Auth\Group;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ManageGroupRequest.
 */
class ManageGroupRequest extends FormRequest {
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
		return [
			//
		];
	}
}
