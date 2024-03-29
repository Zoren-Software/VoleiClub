<?php

namespace Tests\Unit\App\GraphQL\Mutations;

use App\GraphQL\Mutations\ConfirmationTrainingMutation;
use App\Models\ConfirmationTraining;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Tests\TestCase;

class ConfirmationTrainingMutationTest extends TestCase
{
    /**
     * A basic unit test confirmTraining.
     *
     * @test
     *
     * @dataProvider confirmationTrainingProvider
     *
     * @return void
     */
    public function confirmTraining($data, $variable, $method)
    {
        $graphQLContext = $this->createMock(GraphQLContext::class);

        $confirmationTrainingMock = $this->mock(ConfirmationTraining::class, function ($mock) use ($data, $variable) {
            if (isset($data['id'])) {
                $mock->shouldReceive('find')
                    ->once()
                    ->with(1)
                    ->andReturn($mock);
            }

            if (isset($data['training_id']) && isset($data['player_id'])) {
                $mock->shouldReceive('where')
                    ->once()
                    ->with('training_id', 1)
                    ->andReturn($mock);

                $mock->shouldReceive('where')
                    ->once()
                    ->with('player_id', 1)
                    ->andReturn($mock);

                $mock->shouldReceive('first')
                    ->once()
                    ->andReturn($mock);
            }

            if ($variable === 'status') {
                $mock->shouldReceive('setAttribute')
                    ->once()
                    ->with('status', 'confirmed');
            } else {
                $mock->shouldReceive('setAttribute')
                    ->once()
                    ->with('presence', true);
            }

            $mock->shouldReceive('save')
                ->once()
                ->andReturn(true);
        });

        $confirmationTrainingMutation = new ConfirmationTrainingMutation($confirmationTrainingMock);
        $confirmationTrainingMockReturn = $confirmationTrainingMutation->$method(
            null,
            $data,
            $graphQLContext
        );

        $this->assertEquals($confirmationTrainingMock, $confirmationTrainingMockReturn);
    }

    public static function confirmationTrainingProvider()
    {
        return [
            'sending single id parameter as reference, confirm training, success' => [
                'data' => [
                    'id' => 1,
                    'status' => 'confirmed',
                ],
                'variable' => 'status',
                'method' => 'confirmTraining',
            ],
            'sending player and training parameters as a reference, confirm training, success' => [
                'data' => [
                    'training_id' => 1,
                    'player_id' => 1,
                    'status' => 'confirmed',
                ],
                'variable' => 'status',
                'method' => 'confirmTraining',
            ],
            'sending single id parameter as reference, confirm presence, success' => [
                'data' => [
                    'id' => 1,
                    'presence' => true,
                ],
                'variable' => 'presence',
                'method' => 'confirmPresence',
            ],
            'sending player and training parameters as a reference, confirm presence, success' => [
                'data' => [
                    'training_id' => 1,
                    'player_id' => 1,
                    'presence' => true,
                ],
                'variable' => 'presence',
                'method' => 'confirmPresence',
            ],
        ];
    }
}
