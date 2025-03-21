<?php

namespace App\Notifications\Tasks;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskCompletedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly Task $task)
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
            ->subject('Công việc đã được hoàn thành')
            ->greeting('Xin chào ' . $notifiable->name)
            ->line('Công việc sau đây đã được hoàn thành:')
            ->line('Tiêu đề: ' . $this->task->title)
            ->line('Mô tả: ' . $this->task->description)
            ->action('Xem chi tiết', route('tasks.show', $this->task->id))
            ->line('Cảm ơn bạn đã sử dụng ứng dụng của chúng tôi!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
