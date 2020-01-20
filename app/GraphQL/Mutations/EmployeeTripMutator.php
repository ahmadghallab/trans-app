<?php

namespace App\GraphQL\Mutations;

use App\EmployeeTrip;
use App\Notifications\TripSubscription;
use App\Notifications\TripSubscriptionConfirmation;
use Illuminate\Support\Arr;
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

        $trip = $args['trip'];
        $employees = $args['employee'];

        $output = [];
        $emails = [];

        foreach($employees as $employee) {

            $employeeTrip = new EmployeeTrip();

            $employeeTrip->trip = $trip;
            $employeeTrip->employee = $employee;

            $employeeTrip->save();

            array_push($output, $employeeTrip);
            array_push($emails, $employeeTrip->employee()->first()->email);
            
        }

        Notification::route('mail', $emails)
            ->notify(new TripSubscription($trip));

        return $output;
    }

    public function bulkCreate($rootValue, array $args, GraphQLContext $context)
    {
        $input = Arr::except($args, ['directive'])['input'];

        $employeeTrip = EmployeeTrip::insert($input);

        return "Resources created";
    }

    public function join($rootValue, array $args, GraphQLContext $context)
    {
        $employeeTrip = EmployeeTrip::findOrFail($args['id']);
        return $this->setTimeNow($employeeTrip, 'subscribed_at');
    }

    public function sendConfirmation($rootValue, array $args, GraphQLContext $context)
    {
        $employeeTrip = EmployeeTrip::findOrFail($args['id']);
        $employee = $employeeTrip->employee()->first();

        Notification::route('mail', $employee->email)
            ->notify(new TripSubscriptionConfirmation($employeeTrip));

        return $this->setTimeNow($employeeTrip, 'confirmation_sent_at');
    }

    public function confirm($rootValue, array $args, GraphQLContext $context)
    {
        $employeeTrip = EmployeeTrip::findOrFail($args['id']);
        return $this->setTimeNow($employeeTrip, 'confirmed_at');
    }

    protected function setTimeNow($employeeTrip, $field)
    {
        $employeeTrip->$field = Carbon::now();
        $employeeTrip->save();

        return $employeeTrip;
    }


}
