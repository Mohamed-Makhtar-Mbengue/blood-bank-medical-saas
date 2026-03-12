<?php

namespace App\Notifications;

use App\Models\EmergencyRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EmergencyAlertNotification extends Notification
{
    use Queueable;

    public function __construct(public EmergencyRequest $emergency)
    {
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle Demande d\'Urgence - ' . strtoupper($this->emergency->emergency_level->value))
            ->line('Une nouvelle demande d\'urgence a été enregistrée:')
            ->line('Patient: ' . $this->emergency->patient_name)
            ->line('Groupe Sanguin: ' . $this->emergency->blood_type->value)
            ->line('Quantité: ' . $this->emergency->quantity_ml . ' ml')
            ->action('Voir la Demande', url('/emergencies/' . $this->emergency->id));
    }

    public function toArray($notifiable)
    {
        return [
            'emergency_id' => $this->emergency->id,
            'patient_name' => $this->emergency->patient_name,
            'blood_type' => $this->emergency->blood_type->value,
            'level' => $this->emergency->emergency_level->value,
        ];
    }
}