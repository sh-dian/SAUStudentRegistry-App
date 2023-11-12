<?php

namespace App\Enums;

use Closure;
use Spatie\Enum\Laravel\Enum;

/**
 * @method static self Approved()
 * @method static self WaitingEmailVerification()
 * @method static self Rejected()
 * @method static self WaitingApproval()
 */

final class RegistrationStatusEnum extends Enum
{
    protected static function values(): array
    {
        return [
            'Approved' => 1,
            'WaitingEmailVerification' => 2,
            'Rejected' => 3,
            'WaitingApproval' => 4,
        ];
    }

    protected static function labels(): array
    {
        return [
            'WaitingEmailVerification' => __('Waiting Email Verification'),
            'WaitingApproval' => __('Waiting Approval'),
        ];
    }
}
