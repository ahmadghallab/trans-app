<?php

namespace App\GraphQL\Mutations;

use App\EmployeeTrip;
use App\Notifications\TripSubscription;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

class EmployeeTripMutator
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
        $inputData = [
            'trip' => $args['trip'],
            'employee' => $args['employee']
        ];
        $employeeTrip = EmployeeTrip::create($inputData);

        $employee = $employeeTrip->employee()->first();

        Notification::route('mail', $employee->email)
            ->notify(new TripSubscription($employeeTrip));

        return $employeeTrip;
    }

    public function join($rootValue, array $args, GraphQLContext $context)
    {
        return $this->joinConfirmTrip($args['id'], 'subscribed_at');
    }

    public function sendConfirmation($rootValue, array $args, GraphQLContext $context)
    {
        return $this->joinConfirmTrip($args['id'], 'confirmation_sent_at');
    }

    public function confirm($rootValue, array $args, GraphQLContext $context)
    {
        return $this->joinConfirmTrip($args['id'], 'confirmed_at');
    }

    protected function joinConfirmTrip($id, $field)
    {
        $employeeTrip = EmployeeTrip::findOrFail($id);
        $employeeTrip->$field = Carbon::now();
        $employeeTrip->save();

        return $employeeTrip;
    }


}
