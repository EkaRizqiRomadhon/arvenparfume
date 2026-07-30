<?php

namespace App\Services;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactService
{
    /**
     * Simpan pesan kontak dan kirim notifikasi ke admin.
     */
    public function storeAndNotify(array $data, string $ip): ContactMessage
    {
        $message = ContactMessage::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'subject'    => $data['subject'],
            'message'    => $data['message'],
            'ip_address' => $ip,
            'status'     => 'unread',
            'created_at' => now(),
        ]);

        // Mail dinonaktifkan sengaja agar form submit tetap instan.
        // Aktifkan kembali via queued job setelah driver mail dikonfigurasi.
        // $this->sendAdminNotification($message);

        return $message;
    }

    /**
     * Kirim email notifikasi teks ke admin. Kegagalan dicatat ke log
     * tanpa menghentikan alur utama.
     */
    private function sendAdminNotification(ContactMessage $message): void
    {
        $adminEmail = config('mail.admin_email', config('mail.from.address'));

        if (blank($adminEmail) || $adminEmail === 'hello@example.com') {
            return;
        }

        try {
            Mail::raw(
                "Pesan baru dari: {$message->name} <{$message->email}>\n\n" .
                "Subjek: {$message->subject}\n\n" .
                "Pesan:\n{$message->message}\n\n" .
                "IP: {$message->ip_address}",
                function ($mail) use ($message, $adminEmail) {
                    $mail->to($adminEmail)
                         ->subject("[Arven Parfum] Pesan Baru: {$message->subject}")
                         ->replyTo($message->email, $message->name);
                }
            );
        } catch (\Exception $e) {
            Log::error('ContactService: mail delivery failed.', [
                'error'      => $e->getMessage(),
                'message_id' => $message->id,
            ]);
        }
    }
}
