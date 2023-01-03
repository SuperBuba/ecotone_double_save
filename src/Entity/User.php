<?php
declare(strict_types=1);

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Command\UserCreateCommand;
use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\AggregateIdentifier;
use Ecotone\Modelling\Attribute\CommandHandler;
use Symfony\Bridge\Doctrine\Types\UlidType;
use Symfony\Component\Uid\Ulid;

#[ORM\Entity]
#[ORM\Table('users')]
#[Aggregate]
class User
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME)]
    #[AggregateIdentifier]
    private Ulid $id;

    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    private string $email;

    private function __construct(Ulid $id, $email)
    {
        $this->id       = $id;
        $this->email    = $email;
    }

    #[CommandHandler]
    public static function create(UserCreateCommand $command) : self
    {
        return new self(
            $command->user_id ?? new Ulid(),
            $command->email
        );
    }
}