<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PickupNotification extends Model
{
    const STATUS_PENDING = 'PENDING';
    const STATUS_SENT = 'SENT';
    const STATUS_FAILED = 'FAILED';

    const VIA_EMAIL = 'email';
    const VIA_SMS = 'sms';
    const VIA_WHATSAPP = 'whatsapp';

    protected $fillable = [
        'pickup_id',
        'via',
        'address',
        'content',
        'status',
        'provider_remark',
    ];

    public function pickup()
    {
        return $this->belongsTo(Pickup::class);
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            self::STATUS_SENT => '<span class="badge bg-success">' . __('Sent') . '</span>',
            self::STATUS_FAILED => '<span class="badge bg-danger">' . __('Failed') . '</span>',
            default => '<span class="badge bg-warning">' . __('Pending') . '</span>',
        };
    }

    public function getViaBadgeAttribute()
    {
        return match ($this->via) {
            self::VIA_EMAIL => '<span class="badge bg-primary"><em class="icon ni ni-mail"></em> Email</span>',
            self::VIA_WHATSAPP => '<span class="badge bg-success"><em class="icon ni ni-whatsapp"></em> WhatsApp</span>',
            self::VIA_SMS => '<span class="badge bg-info"><em class="icon ni ni-mobile"></em> SMS</span>',
            default => '<span class="badge bg-secondary">' . $this->via . '</span>',
        };
    }
}
