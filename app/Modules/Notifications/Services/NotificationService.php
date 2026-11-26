<?php

namespace App\Modules\Notifications\Services;

use App\Contracts\NotificationServiceInterface;
use App\Models\User;
use App\Modules\Notifications\Models\NotificationLog;
use Illuminate\Support\Facades\Mail;
use Throwable;

class NotificationService implements NotificationServiceInterface
{
    public function send(User $user, string $template, array $data = []): void
    {
        try {
            // TODO (Notifications team): replace this plain-text mail with one Mailable + Blade template per $template
            // TODO (Notifications team): queue the mail (implements ShouldQueue) so checkout is not slowed down
            Mail::raw($this->plainText($template, $data), function ($message) use ($user, $template) {
                $message->to($user->email)->subject($this->subject($template));
            });

            $this->log($user, $template, $data, 'sent');
        } catch (Throwable $e) {
            $this->log($user, $template, $data, 'failed', $e->getMessage());
        }
    }

    private function subject(string $template): string
    {
        return match ($template) {
            'order_placed' => 'We received your order',
            // TODO (Notifications team): payment_confirmed, order_cancelled, order_shipped, stock_low
            default => 'Update from '.config('app.name'),
        };
    }

    private function plainText(string $template, array $data): string
    {
        return match ($template) {
            'order_placed' => "Thank you! Your order {$data['order_number']} totaling PHP {$data['total']} was received.",
            default => 'You have a new update.',
        };
    }

    private function log(User $user, string $template, array $data, string $status, ?string $error = null): void
    {
        NotificationLog::create([
            'user_id' => $user->id,
            'template' => $template,
            'channel' => 'mail',
            'status' => $status,
            'data' => $data,
            'error' => $error,
        ]);
    }
}
