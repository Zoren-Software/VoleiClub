<?php

namespace App\GraphQL\Mutations;

use App\Models\SpecificFundamental;

final class SpecificFundamentalMutation
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function create($rootValue, array $args, GraphQLContext $context)
    {
        $specificFundamental = new SpecificFundamental();
        $specificFundamental->name = $args['name'];
        $specificFundamental->user_id = $args['user_id'];
        $specificFundamental->save();

        return $specificFundamental;
    }

        /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function edit($rootValue, array $args, GraphQLContext $context)
    {
        $specificFundamental = SpecificFundamental::find($args['id']);
        $specificFundamental->name = $args['name'];
        $specificFundamental->user_id = $args['user_id'];
        $specificFundamental->save();

        return $specificFundamental;
    }
}
