<?php
declare(strict_types=1);


namespace App\Events;



use Symfony\Component\Uid\Ulid;

class MerchantOwnerSetted
{
    public function __construct(
        public string $email,
        public Ulid $user_id
    )
    {

    }
}