<?php

namespace App\Command;

use App\Service\CryptocompareService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadCommand extends Command
{
    protected static $defaultName = 'app:load-history';
    private $cryptocompareService;
    private $currencies = ['USD', 'EUR', 'RUB'];

    protected function configure(): void
    {
        $this
            ->setDescription('Загружает данные по ценам.')
            ->addArgument('limit', InputArgument::OPTIONAL, 'Количество запрашиваемых записей', 1)
        ;
    }

    public function __construct(CryptocompareService $cryptocompareService)
    {
        $this->cryptocompareService = $cryptocompareService;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $limit = $input->getArgument('limit');
        $output->write('Команда начала работу', true);
        foreach ($this->currencies as $currency) {
            $this->cryptocompareService->loadData('BTC', $currency, $limit);
        }
        $output->write('Команда закончила работу', true);
        return Command::SUCCESS;
    }
}