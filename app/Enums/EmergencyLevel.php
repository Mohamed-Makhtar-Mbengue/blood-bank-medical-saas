<?php

namespace App\Enums;

enum EmergencyLevel: string
{
    case LOW = 'low';
    case MEDIUM = 'medium';
    case HIGH = 'high';
    case CRITICAL = 'critical';
    
    public function color(): string
    {
        return match($this) {
            self::LOW => 'blue',
            self::MEDIUM => 'yellow',
            self::HIGH => 'orange',
            self::CRITICAL => 'red',
        };
    }
}