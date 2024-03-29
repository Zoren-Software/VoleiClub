<?php

namespace Tests\Unit\App\GraphQL\Validators\Mutation;

use App\GraphQL\Validators\Mutation\TrainingConfigEditValidator;
use Tests\TestCase;

class TrainingConfigEditValidatorTest extends TestCase
{
    /**
     * A basic unit test messages.
     *
     * @test
     *
     * @return void
     */
    public function messages()
    {
        $validator = new TrainingConfigEditValidator();

        $this->assertIsArray($validator->messages());
        $this->assertNotEmpty($validator->messages());
    }

    /**
     * A basic unit test rules.
     *
     * @test
     *
     * @return void
     */
    public function rules()
    {
        $validator = new TrainingConfigEditValidator();

        $this->assertIsArray($validator->rules());
        $this->assertNotEmpty($validator->rules());
    }
}
