<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Arr;
use App\EmployeeTrip;
use App\Events\TripSubscriptionEvent;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class CreateEmployeeTripMutator
{
    /**
     * Return a value for the field.
     *
     * @param  null  $rootValue Usually contains the result returned from the parent field. In this case, it is always `null`.
     * @param  mixed[]  $args The arguments that were passed into the field.
     * @param  \Nuwave\Lighthouse\Support\Contracts\GraphQLContext  $context Arbitrary data that is shared between all fields of a single query.
     * @return mixed
     */
    public function create($rootValue, array $args, GraphQLContext $context)
    {
        $inputData = Arr::except($args, 'directive');
        $employeeTrip = EmployeeTrip::create($inputData);

        event(new TripSubscriptionEvent());

        return $employeeTrip;
    }
}
