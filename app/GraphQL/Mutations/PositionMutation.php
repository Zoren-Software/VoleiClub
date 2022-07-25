<?php

namespace App\GraphQL\Mutations;

use App\Models\SpecificFundamental;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

final class PositionMutation
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function create($rootValue, array $args, GraphQLContext $context)
    {
        $position = new Position();
        $position->name = $args['name'];
        $position->user_id = $args['user_id'];
        $position->save();

        return $position;
    }

    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function edit($rootValue, array $args, GraphQLContext $context)
    {
        $position = Position::find($args['id']);
        $position->name = $args['name'];
        $position->user_id = $args['user_id'];
        $position->save();

        return $position;
    }
}
