<?php

namespace App\Notifications\Tasks;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Task $task
    )
    {
        $this->afterCommit();
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Bạn đã được giao một công việc mới')
            ->greeting('Xin chào ' . $notifiable->name)
            ->line('Bạn đã được giao một công việc mới.')
            ->line('Tiêu đề: ' . $this->task->title)
            ->line('Mô tả: ' . $this->task->description)
            ->line('Hạn hoàn thành: ' . $this->task->due_date)
            ->action('Xem chi tiết', url('/tasks/' . $this->task->id))
            ->line('Cảm ơn bạn đã sử dụng ứng dụng của chúng tôi!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
