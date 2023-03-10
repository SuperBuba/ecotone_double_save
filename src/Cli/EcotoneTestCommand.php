<?php

namespace App\Cli;

use App\Command\MerchantCreateCommand;
use Doctrine\DBAL\Logging\DebugStack;
use App\Command\MerchantSetOwnerCommand;
use Ecotone\Modelling\CommandBus;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Uid\Ulid;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Helper\Table;


#[AsCommand(
    name: 'ecotone:test',
    description: 'Test ecotone command -> event -> command',
)]
class EcotoneTestCommand extends Command
{
    private CommandBus $bus;

    private EntityManagerInterface $em;

    private DebugStack $logger;

    public function __construct(CommandBus $bus, EntityManagerInterface $em, string $name = null)
    {
        $this->bus  = $bus;
        $this->em   = $em;

        $this->logger = new DebugStack();
        $this->em->getConnection()
            ->getConfiguration()
            ->setSQLLogger($this->logger);

        parent::__construct($name);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        try {
            $id = $this->bus->send(new MerchantCreateCommand('merchant 1'));

            $this->bus->send(new MerchantSetOwnerCommand(new Ulid($id), 'merchant@test.com'));
            $io->note(sprintf('merchant created: %s', $id));

            return Command::SUCCESS;
        }
        catch (\Throwable $e) {
            $io->error($e->getMessage());

            $rows   = [];
            $index  = 0;
            foreach ($this->logger->queries as $query) {
                $params = $query['params'] === null ? [] : array_map(function($p) {
                    return (string)$p;
                }, $query['params']);

                $rows[] = [++$index, $query['sql'], implode(', ', $params)];
                if($index < count($this->logger->queries)) {
                    $rows[] = new TableSeparator();
                }
            }

            $table = new Table($output);
            $table
                ->setHeaders(['#', 'SQL', 'Params'])
                ->setRows($rows);
            $table->setColumnMaxWidth(0, 10);
            $table->setColumnMaxWidth(1, 70);
            $table->setColumnMaxWidth(2, 50);
            $table->render();


            return Command::FAILURE;
        }
    }
}
