<?php
declare(strict_types=1);


namespace App\Service;

use App\Command\UserCreateCommand;
use App\Events\MerchantOwnerSetted;
use Ecotone\Modelling\CommandBus;
use Ecotone\Modelling\Attribute\EventHandler;

class UserService
{
    #[EventHandler]
    public function onMerchantOwnerSetted(MerchantOwnerSetted $event, CommandBus $bus) : void
    {
        $bus->send(new UserCreateCommand($event->email, $event->user_id));
    }
}