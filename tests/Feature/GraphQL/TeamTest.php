<?php

namespace Tests\Feature\GraphQL;

use App\Models\Team;
use Faker\Factory as Faker;
use Tests\TestCase;

class TeamTest extends TestCase
{
    protected $graphql = true;

    protected $tenancy = true;

    protected $login = true;

    private $teamText = ' TEAM';

    private $data = [
        'id',
        'name',
        'userId',
        'createdAt',
        'updatedAt'
    ];

    /**
     * Listagem de todos os times.
     *
     * @author Maicon Cerutti
     *
     * @return void
     */
    public function test_teams_list()
    {
        Team::factory()->make()->save();

        $response = $this->graphQL(
            'teams',
            [
                'name' => '%%',
                'first' => 10,
                'page' => 1,
            ],
            [
                'paginatorInfo' => $this->paginatorInfo,
                'data' => $this->data,
            ],
            'query',
            false
        );

        $response->assertJsonStructure([
            'data' => [
                'teams' => [
                    'paginatorInfo' => $this->paginatorInfo,
                    'data' => [
                        '*' => $this->data
                    ]
                ],
            ],
        ])->assertStatus(200);
    }

    /**
     * Listagem de um time
     *
     * @author Maicon Cerutti
     *
     * @return void
     */
    public function test_team_info()
    {
        $team = Team::factory()->make();
        $team->save();

        $response = $this->graphQL(
            'team',
            [
                'id' => $team->id,
            ],
            $this->data,
            'query',
            false
        );

        $response->assertJsonStructure([
            'data' => [
                'team' => $this->data,
            ],
        ])->assertStatus(200);
    }

    /**
     * Método de criação de um time.
     *
     * @dataProvider teamCreateProvider
     * @author Maicon Cerutti
     *
     * @return void
     */
    public function test_team_create($parameters, $type_message_error, $expected_message, $expected, $permission)
    {
        $this->checkPermission($permission, 'Técnico', 'create-team');

        $response = $this->graphQL(
            'teamCreate',
            $parameters,
            $this->data,
            'mutation',
            false,
            true
        );

        $this->assertMessageError($type_message_error, $response, $permission, $expected_message);

        $response
            ->assertJsonStructure($expected)
            ->assertStatus(200);
    }

    /**
     *
     * @return Array
     */
    public function teamCreateProvider()
    {
        $faker = Faker::create();
        $userId = 1;
        $nameExistent = $faker->name . $this->teamText;
        $teamCreate = ['teamCreate'];

        return [
            'create team without permission, expected error' => [
                [
                    'name' => $nameExistent,
                    'userId' => $userId,
                ],
                'type_message_error' => false,
                'expected_message' => false,
                'expected' => [
                    'errors' => $this->errors,
                    'data' => $teamCreate
                ],
                'permission' => false,
            ],
            'create team, success' => [
                [
                    'name' => $nameExistent,
                    'userId' => $userId,
                ],
                'type_message_error' => false,
                'expected_message' => false,
                'expected' => [
                    'data' => [
                        'teamCreate' => $this->data,
                    ],
                ],
                'permission' => true,
            ],
            'name field is not unique, expected error' => [
                [
                    'name' => $nameExistent,
                    'userId' => $userId,
                ],
                'type_message_error' => 'name',
                'expected_message' => 'TeamCreate.name_unique',
                'expected' => [
                    'errors' => $this->errors,
                    'data' => $teamCreate
                ],
                'permission' => true,
            ],
            'name field is required, expected error' => [
                [
                    'name' => ' ',
                    'userId' => $userId,
                ],
                'type_message_error' => 'name',
                'expected_message' => 'TeamCreate.name_required',
                'expected' => [
                    'errors' => $this->errors,
                    'data' => $teamCreate
                ],
                'permission' => true,
            ],
            'name field is min 3 characteres, expected error' => [
                [
                    'name' => 'AB',
                    'userId' => $userId,
                ],
                'type_message_error' => 'name',
                'expected_message' => 'TeamCreate.name_min',
                'expected' => [
                    'errors' => $this->errors,
                    'data' => $teamCreate
                ],
                'permission' => true,
            ],
        ];
    }

    /**
     * Método de edição de um time.
     *
     * @dataProvider teamEditProvider
     * @author Maicon Cerutti
     *
     * @return void
     */
    public function test_team_edit($parameters, $type_message_error, $expected_message, $expected, $permission)
    {
        $this->checkPermission($permission, 'Técnico', 'edit-team');

        $teamExist = Team::factory()->make();
        $teamExist->save();
        $team = Team::factory()->make();
        $team->save();

        $parameters['id'] = $team->id;

        if ($expected_message == 'TeamEdit.name_unique') {
            $parameters['name'] = $teamExist->name;
        }

        $response = $this->graphQL(
            'teamEdit',
            $parameters,
            $this->data,
            'mutation',
            false,
            true
        );

        $this->assertMessageError($type_message_error, $response, $permission, $expected_message);

        $response
            ->assertJsonStructure($expected)
            ->assertStatus(200);
    }

    /**
     *
     * @return Array
     */
    public function teamEditProvider()
    {
        $faker = Faker::create();
        $userId = 2;
        $teamEdit = ['teamEdit'];

        return [
            'edit team without permission, expected error' => [
                [
                    'name' => $faker->name . $this->teamText,
                    'userId' => $userId,
                ],
                'type_message_error' => 'message',
                'expected_message' => 'This action is unauthorized.',
                'expected' => [
                    'errors' => $this->errors,
                    'data' => $teamEdit
                ],
                'permission' => false,
            ],
            'edit team, success' => [
                [
                    'name' => $faker->name . $this->teamText,
                    'userId' => $userId,
                ],
                'type_message_error' => false,
                'expected_message' => false,
                'expected' => [
                    'data' => [
                        'teamEdit' => $this->data,
                    ],
                ],
                'permission' => true,
            ],
            'name field is not unique, expected error' => [
                [
                    'userId' => $userId,
                ],
                'type_message_error' => 'name',
                'expected_message' => 'TeamEdit.name_unique',
                'expected' => [
                    'errors' => $this->errors,
                    'data' => $teamEdit
                ],
                'permission' => true,
            ],
            'name field is required, expected error' => [
                [
                    'name' => ' ',
                    'userId' => $userId,
                ],
                'type_message_error' => 'name',
                'expected_message' => 'TeamEdit.name_required',
                'expected' => [
                    'errors' => $this->errors,
                    'data' => $teamEdit
                ],
                'permission' => true,
            ],
            'name field is min 3 characteres, expected error' => [
                [
                    'name' => 'AB',
                    'userId' => $userId,
                ],
                'type_message_error' => 'name',
                'expected_message' => 'TeamEdit.name_min',
                'expected' => [
                    'errors' => $this->errors,
                    'data' => $teamEdit
                ],
                'permission' => true,
            ],
        ];
    }
}
