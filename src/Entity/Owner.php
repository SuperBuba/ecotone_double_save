<?php
declare(strict_types=1);

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Ulid;
use Symfony\Bridge\Doctrine\Types\UlidType;

#[ORM\Embeddable]
class Owner
{
    public function __construct(
        #[ORM\Column(type: UlidType::NAME, nullable: true)]
        private readonly Ulid $user_id,

        #[ORM\Column(type: 'string', length: 180, nullable: true)]
        private readonly string $email
    )
    {

    }

    public function userId() : Ulid
    {
        return $this->user_id;
    }

    public function email() : string
    {
        return $this->email;
    }
}