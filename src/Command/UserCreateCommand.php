<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Uid\Ulid;

class UserCreateCommand
{
    public function __construct(
        public readonly string $email,
        public readonly ?Ulid $user_id = null,
    )
    {

    }
}