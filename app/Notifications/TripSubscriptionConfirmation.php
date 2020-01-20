<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TripSubscriptionConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $employeeTrip;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($employeeTrip)
    {
        $this->employeeTrip = $employeeTrip;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/trip/confirm/'.$this->employeeTrip->id);
        $employeeName = $this->employeeTrip->employee()->first()->name;

        return (new MailMessage)
            ->greeting('Hi, '.$employeeName)
            ->line('This is a confirmation message from the driver')
            ->action('Yes I am here', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
