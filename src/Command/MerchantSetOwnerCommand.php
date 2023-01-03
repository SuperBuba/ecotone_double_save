<?php
declare(strict_types=1);

namespace App\Command;

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