<?php

namespace App\GraphQL\Mutations;

use App\Models\SpecificFundamental;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class SpecificFundamentalMutation
{
    public function __construct(SpecificFundamental $specificFundamental)
    {
        $this->specificFundamental = $specificFundamental;
    }

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function create($rootValue, array $args, GraphQLContext $context)
    {
        $this->specificFundamental = $this->specificFundamental->create($args);

        if (isset($args['fundamental_id']) && $this->specificFundamental->fundamentals()) {
            $this->specificFundamental->fundamentals()->syncWithoutDetaching($args['fundamental_id']);
        }

        $this->specificFundamental->fundamentals;

        return $this->specificFundamental;
    }

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function edit($rootValue, array $args, GraphQLContext $context)
    {
        $this->specificFundamental = $this->specificFundamental->find($args['id']);
        $this->specificFundamental->update($args);

        if (isset($args['fundamental_id']) && $this->specificFundamental->fundamentals()) {
            $this->specificFundamental->fundamentals()->syncWithoutDetaching($args['fundamental_id']);
        }

        return $this->specificFundamental;
    }

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function delete($rootValue, array $args, GraphQLContext $context)
    {
        $specificFundamentals = [];
        foreach ($args['id'] as $id) {
            $this->specificFundamental = $this->specificFundamental->deleteSpecificFundamental($id);
            $specificFundamentals[] = $this->specificFundamental;
        }

        return $specificFundamentals;
    }
}
