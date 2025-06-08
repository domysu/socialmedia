<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Group;
use App\Models\GroupUser;
class GroupInviteNotification extends Notification
{
    use Queueable;


   private Group $group;
   private GroupUser $groupUser;
    /**
     * Create a new notification instance.
     */
    public function __construct(Group $group, GroupUser $groupUser)
    {
        $this->group = $group;
        $this->groupUser = $groupUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line("You have been invited to join group - {$this->group->name}")
                    ->action('Accept invite', url("/group-invite/{$this->groupUser->token}"))
                    ->line('Your invitation will expire in 24h !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
