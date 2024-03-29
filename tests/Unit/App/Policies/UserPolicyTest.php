<?php

namespace Tests\Unit\App\Policies;

use App\Models\User;
use App\Policies\UserPolicy;
use Mockery\MockInterface;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    /**
     * A basic unit test create.
     *
     * @dataProvider permissionProvider
     *
     * @test
     */
    public function permissionCreate(bool $expected): void
    {
        $user = $this->createMock(User::class);
        $user->expects($this->once())
            ->method('hasPermissionTo')
            ->with('edit-user')
            ->willReturn($expected);

        $userPolicy = new UserPolicy();
        $userPolicy->create($user);
    }

    public static function createProvider(): array
    {
        return [
            'when permission allows' => [
                true,
            ],
            'when permission does not allow' => [
                false,
            ],
        ];
    }

    /**
     * A basic unit test edit.
     *
     * @dataProvider permissionProvider
     *
     * @test
     */
    public function permissionEdit(bool $expected): void
    {
        $user = $this->createMock(User::class);
        $user->expects($this->once())
            ->method('hasPermissionTo')
            ->with('edit-user')
            ->willReturn($expected);

        $userPolicy = new UserPolicy();
        $userPolicy->edit($user);
    }

    /**
     * A basic unit test delete.
     *
     * @dataProvider permissionProvider
     *
     * @test
     */
    public function permissionDelete(bool $expected): void
    {
        $user = $this->createMock(User::class);
        $user->expects($this->once())
            ->method('hasPermissionTo')
            ->with('edit-user')
            ->willReturn($expected);

        $userPolicy = new UserPolicy();
        $userPolicy->delete($user);
    }

    /**
     * A basic unit test view.
     *
     * @dataProvider permissionProvider
     *
     * @test
     */
    public function permissionView(bool $expected): void
    {
        $userMock = $this->mock(User::class, function (MockInterface $mock) use ($expected) {
            $mock->shouldReceive('hasPermissionTo')
                ->with('edit-user')
                ->andReturn($expected);

            $mock->shouldReceive('hasPermissionTo')
                ->with('view-user')
                ->andReturn($expected);
        });

        $userPolicy = new UserPolicy();

        $this->assertEquals($expected, $userPolicy->view($userMock));
    }
}
