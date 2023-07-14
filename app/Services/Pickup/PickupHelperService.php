<?php

namespace App\Services\Pickup;

class PickupHelperService
{

    const STATUS_PENDING = 1, STATUS_READY_TO_DELIVER = 2, STATUS_DELIVERED = 3, STATUS_PICKUP_POINT_PROCESS = 4;

    const PAYMENT_STATUS_NOT_PAID = 1, PAYMENT_STATUS_PAID = 2;

    const PAYMENT_METHOD_CASH = 1, PAYMENT_METHOD_BANK_TRANSFER = 2;

    public static function statuseBadge(){

        return [
            self::STATUS_PENDING   => '<span class="badge rounded-pill bg-warning">Pending</span>',
            self::STATUS_READY_TO_DELIVER => '<span class="badge rounded-pill bg-info">Ready to Deliver</span>',
            self::STATUS_DELIVERED => '<span class="badge rounded-pill bg-success">Delivered</span>',
            self::STATUS_PICKUP_POINT_PROCESS => '<span class="badge rounded-pill bg-primary">Processing</span>',
        ];
    }

    public static function paymentMethodLabel(){

        return [
            self::PAYMENT_METHOD_CASH   => 'Cash',
            self::PAYMENT_METHOD_BANK_TRANSFER => 'Bank Transfer',
        ];
    }

    public static function paymentStatusLabel(){

        return [
            self::PAYMENT_STATUS_NOT_PAID   => 'Not Paid',
            self::PAYMENT_STATUS_PAID => 'Paid',
        ];
    }

    public static function statusLabel(){

        return [
            self::STATUS_PENDING   => 'Pending',
            self::STATUS_READY_TO_DELIVER => 'Ready to Deliver',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_PICKUP_POINT_PROCESS => 'Processing',
        ];
    }

}
