<?php

namespace App\GraphQL\Validators\Mutation;

use App\Rules\PermissionAssignment;
use Nuwave\Lighthouse\Validation\Validator;

final class UserEditValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'password' => [
                'required',
                'min:6',
            ],
            'email' => [
                'unique:users,email,' . $this->arg('id'),
                'required',
                'email',
            ],
            'roleId' => [
                'required',
                'exists:roles,id',
                new PermissionAssignment(),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.required' => trans('UserEdit.password_required'),
            'password.min' => trans('UserEdit.password_min_6'),
            'email.required' => trans('UserEdit.email_required'),
            'roleId.required' => trans('UserEdit.role_id_required'),
            'email.email' => trans('UserEdit.email_is_valid'),
            'email.unique' => trans('UserEdit.email_unique'),
        ];
    }
}
