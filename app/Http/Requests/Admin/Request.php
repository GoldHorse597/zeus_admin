<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Validator;

class Request extends FormRequest
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
            //
        ];
    }

    public function verify()
    {
        $routeName = $this->route()->getName();
        $routeRules = $this->rules[$routeName] ?? [];
        $rules = $names = $messages = [];
        foreach ($routeRules as $key => $validation)
        {
            $rules[$key] = $validation['rules'];
            $names[$key] = $validation['name'];
            if (isset($validation['message']) && !empty($validation['message']) && is_array($validation['message']))
            {
                foreach($validation['message'] as $index => $message)
                {
                    $messages[$key.'.'.$index] = $message;
                }
            }
        }

        $validator = Validator::make(
            $this->all(),
            $rules,
            $messages,
            $names
        );

        return $validator;
    }

    private $rules = [
        'admin.login.post' => [
            'identity' => [
                'name' => '아이디',
                'rules' => 'required',
                'message' => ['required' => ':attribute를 입력하세요.']
            ],
            'password' => [
                'name' => '비밀번호',
                'rules' => 'required',
                'message' => ['required' => ':attribute를 입력하세요.']
            ],
        ],
    ];
}
