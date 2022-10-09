<?php

namespace App\GraphQL\Validators\Mutation;

use Nuwave\Lighthouse\Validation\Validator;

final class TrainingEditValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
            ],
            'userId' => [
                'required',
            ],
            'teamId' => [
                'required',
            ],
            'dateStart' => [
                'required',
                'date',
                'date_format:Y-m-d H:i:s',
                'before:dateEnd',
            ],
            'dateEnd' => [
                'required',
                'date',
                'date_format:Y-m-d H:i:s',
                'after:dateStart',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => trans('TrainingEdit.name_required'),
            'name.min' => trans('TrainingEdit.name_min'),
            'teamId.required' => trans('TrainingEdit.team_id_required'),
            'userId.required' => trans('TrainingEdit.user_id_required'),
            'dateStart.required' => trans('TrainingEdit.date_start_required'),
            'dateStart.date' => trans('TrainingEdit.date_start_type_date'),
            'dateStart.date_format' => trans('TrainingEdit.date_start_format_date'),
            'dateStart.before' => trans('TrainingEdit.date_start_before'),
            'dateEnd.required' => trans('TrainingEdit.date_end_required'),
            'dateEnd.date' => trans('TrainingEdit.date_end_type_date'),
            'dateEnd.date_format' => trans('TrainingEdit.date_end_format_date'),
            'dateEnd.after' => trans('TrainingEdit.date_end_after'),
        ];
    }
}
