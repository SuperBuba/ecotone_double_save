<?php

namespace App\Entity;

use App\Events\MerchantOwnerSetted;
use Doctrine\ORM\Mapping as ORM;

use App\Command\MerchantCreateCommand;
use Domain\Merchant\Commands\MerchantSetOwnerCommand;
use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\AggregateIdentifier;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\EventBus;
use Symfony\Component\Uid\Ulid;
use Symfony\Bridge\Doctrine\Types\UlidType;
//use App\Values\Owner;

#[ORM\Entity]
#[ORM\Table('merchants')]
#[Aggregate]
class Merchant
{
    #[ORM\Id]
    #[ORM\Column(type: UlidType::NAME)]
    #[AggregateIdentifier]
    private Ulid $id;

    #[ORM\Column(type: 'string', length: 180, nullable: true)]
    private string $name;

    #[ORM\Embedded(class: Owner::class)]
    private Owner $owner;

    private function __construct(Ulid $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function id() : Ulid
    {
        return $this->id;
    }

    #[CommandHandler]
    public static function create(MerchantCreateCommand $command): self
    {
        return new self(new Ulid(), $command->name);
    }

    #[CommandHandler]
    public function setOwner(MerchantSetOwnerCommand $command, EventBus $bus) : void
    {
        $this->owner    = new Owner(new Ulid(), $command->email);

        $bus->publish(new MerchantOwnerSetted($this->owner->email(), $this->owner->userId()));
    }
}