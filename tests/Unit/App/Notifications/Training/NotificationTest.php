<?php

namespace Tests\Unit\App\Notifications\Training;

use App\Models\Training;
use App\Models\User;
use App\Notifications\Training\Notification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    /**
     * A test method via.
     *
     * @test
     *
     * @dataProvider dataProvider
     *
     * @return void
     */
    public function via(
        $notificationTechnicianByEmail,
        $notificationTeamByEmail,
        $hasRoleTechnician,
        $hasRolePlayer,
        $expected
    ) {
        $userMock = $this->createMock(User::class);
        $userMock->method('hasRoleTechnician')->willReturn($hasRoleTechnician);
        $userMock->method('hasRolePlayer')->willReturn($hasRolePlayer);

        $trainingMock = $this->createMock(Training::class);
        $notification = new Notification($trainingMock);
        $via = $notification->via($userMock, 'mock', $notificationTechnicianByEmail, $notificationTeamByEmail);

        $this->assertIsArray($via);
        $this->assertEquals($expected, $via);
    }

    /**
     * A data provider for via.
     *
     * @return array
     */
    public static function dataProvider()
    {
        return [
            'notify player or technician by email and database' => [
                'notificationTechnicianByEmail' => true,
                'notificationTeamByEmail' => true,
                'hasRoleTechnician' => true,
                'hasRolePlayer' => true,
                'expected' => [
                    'database',
                    'mail',
                ],
            ],
            'notify player by email and database' => [
                'notificationTechnicianByEmail' => false,
                'notificationTeamByEmail' => true,
                'hasRoleTechnician' => false,
                'hasRolePlayer' => true,
                'expected' => [
                    'database',
                    'mail',
                ],
            ],
            'notify technician by email and database' => [
                'notificationTechnicianByEmail' => true,
                'notificationTeamByEmail' => false,
                'hasRoleTechnician' => true,
                'hasRolePlayer' => false,
                'expected' => [
                    'database',
                    'mail',
                ],
            ],
            'notify technician by database only' => [
                'notificationTechnicianByEmail' => false,
                'notificationTeamByEmail' => false,
                'hasRoleTechnician' => true,
                'hasRolePlayer' => false,
                'expected' => [
                    'database',
                ],
            ],
            'notify player by database only' => [
                'notificationTechnicianByEmail' => false,
                'notificationTeamByEmail' => false,
                'hasRoleTechnician' => false,
                'hasRolePlayer' => true,
                'expected' => [
                    'database',
                ],
            ],
        ];
    }

    /**
     * A test method tags.
     *
     * @test
     *
     * @return array
     */
    public function tags()
    {
        $trainingMock = $this->createMock(Training::class);
        $notification = new Notification($trainingMock);
        $tags = $notification->tags();

        $this->assertIsArray($tags);
        $this->assertEquals(['tenant:'], $tags);
    }
}
