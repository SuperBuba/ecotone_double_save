<?php
declare(strict_types=1);

namespace Domain\Merchant\Commands;

use Symfony\Component\Uid\Ulid;

class MerchantSetOwnerCommand
{
    public function __construct(
        public readonly Ulid $id,
        public readonly string $email
    )
    {

    }
}