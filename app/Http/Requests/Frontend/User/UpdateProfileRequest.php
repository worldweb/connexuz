<?php

namespace App\Http\Requests\Frontend\User;

use Illuminate\Validation\Rule;
use App\Helpers\Frontend\Auth\Socialite;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

/**
 * Class UpdateProfileRequest.
 */
class UpdateProfileRequest extends FormRequest
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
    public function rules(Request $request)
    {
        if($request->only('basic_info')) {
            $rules = [
                'first_name'  => 'required|max:191',
                'last_name'  => 'required|max:191',
                'email' => 'sometimes|required|email|max:191',
                'date_of_birth' => 'required|max:20',
                'gender' => 'required|in:1,2',
                'city' => 'required',
                'country' => 'required',
                'about' => 'required',
            ];
        } elseif ($request->only('edu_info')) {
            $rules = [
                'university' => 'required',
                'education_from_date' => 'required|max:20',
                'education_to_date' => 'required|max:20',
                'education_about' => 'required',
            ];
        } elseif ($request->only('interest_info')) {
            $rules = [
                'graduted' => 'required',
            ];
        } elseif ($request->only('password_info')) {
            $rules = [
                'password' => 'nullable|min:8',
                'confirmed' => 'nullable|min:8|same:password',
            ];
        }
        /*
        $rules = [
            'first_name'  => 'required|max:191',
            'last_name'  => 'required|max:191',
            'email' => 'sometimes|required|email|max:191',
            'date_of_birth' => 'required|max:20',
            'gender' => 'required|in:1,2',
            'city' => 'required',
            'country' => 'required',
            'about' => 'required',
            'about' => 'required',
            'university' => 'required',
            'education_from_date' => 'required|max:20',
            'education_to_date' => 'required|max:20',
            'education_about' => 'required',
            'graduted' => 'required',
            'password' => 'nullable|min:8',
            'confirmed' => 'nullable|min:8|same:password',
//            'avatar_type' => ['required', 'max:191', Rule::in(array_merge(['gravatar', 'storage'], (new Socialite)->getAcceptedProviders()))],
//            'avatar_location' => 'sometimes|image|max:191',
        ];
*/
        return $rules;
    }
}
