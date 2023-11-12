<?php

namespace App\Helpers;
use App\Enums\RegistrationStatusEnum;


class EnumMap
{
    public static function getRegistrationStatus(): array
    {
        return [
            RegistrationStatusEnum::Approved()->value => RegistrationStatusEnum::Approved()->label,
            RegistrationStatusEnum::WaitingEmailVerification()->value => RegistrationStatusEnum::WaitingEmailVerification()->label,
            RegistrationStatusEnum::Rejected()->value => RegistrationStatusEnum::Rejected()->label,
            RegistrationStatusEnum::WaitingApproval()->value => RegistrationStatusEnum::WaitingApproval()->label,
        ];
    }
}
