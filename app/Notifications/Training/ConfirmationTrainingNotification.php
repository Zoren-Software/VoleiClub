<?php

namespace App\Notifications\Training;

use App\Mail\Training\ConfirmationNotificationTrainingMail;
use App\Models\User;

class ConfirmationTrainingNotification extends Notification
{
    /**
     * Get the mail representation of the notification.
     *
     * @codeCoverageIgnore
     *
     * @param  mixed  $notifiable
     * @return \App\Mail\Training\ConfirmationNotificationTrainingMail
     */
    public function toMail(User $notifiable)
    {
        return (new ConfirmationNotificationTrainingMail($this->training, $notifiable))
            ->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @codeCoverageIgnore
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray(User $notifiable)
    {
        return [
            'userAction' => $notifiable,
            'training' => $this->training,
            'message' => trans('TrainingNotification.title_mail_confirmation'),
        ];
    }
}
