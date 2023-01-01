<?php

namespace Tests\Unit\App\GraphQL\Mutations;

use Tests\TestCase;
use App\Models\Config;
use App\GraphQL\Mutations\ConfigMutation;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Mockery\MockInterface;

class ConfigMutationTest extends TestCase
{
    /**
     * A basic unit test make.
     *
     * @return void
     */
    public function test_make()
    {
        $graphQLContext = $this->createMock(GraphQLContext::class);
        $configMock = $this->mock(Config::class, function (MockInterface $mock) {
            $mock->shouldReceive('find')
                ->once()
                ->andReturn($mock);

            $mock->shouldReceive('update')->once()->andReturn($mock);
        });

        $data = [
            'user_id' => 1,
            'name_tenant' => 'name',
            'language_id' => 'value',
        ];

        $configMutation = new ConfigMutation($configMock);
        $configMockReturn = $configMutation->make(
            null,
            $data,
            $graphQLContext
        );

        $this->assertEquals($configMock, $configMockReturn);
    }
}