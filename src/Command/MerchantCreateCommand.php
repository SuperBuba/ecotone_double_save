<?php
declare(strict_types=1);

namespace App\Command;


class MerchantCreateCommand
{
    public function __construct(
        public readonly string $name
    )
    {

    }
}