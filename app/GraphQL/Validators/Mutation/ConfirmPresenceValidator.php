<?php

namespace App\GraphQL\Validators\Mutation;

use App\Rules\CheckPlayerIsInTraining;
use App\Rules\CheckTrainingCancelled;
use Nuwave\Lighthouse\Validation\Validator;

final class ConfirmPresenceValidator extends Validator
{
    /**
     * Return the validation rules.
     *
     * @return array<string, array<mixed>>
     */
    public function rules(): array
    {
        $playerId = $this->arg('playerId') ?? null;
        $trainingId = $this->arg('trainingId') ?? null;

        return [
            'id' => [
                'required',
            ],
            'playerId' => [
                'required',
                new CheckPlayerIsInTraining($playerId, $trainingId),
            ],
            'trainingId' => [
                'required',
                'exists:trainings,id',
                new CheckTrainingCancelled($trainingId),
            ],
            'presence' => [
                'required',
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'playerId.required' => trans('ConfirmTraining.playerId_required'),
            'trainingId.required' => trans('ConfirmTraining.trainingId_required'),
            'presence.required' => trans('ConfirmTraining.presence_required'),
        ];
    }
}
