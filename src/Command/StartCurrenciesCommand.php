<?php

namespace App\Command;

use App\Entity\Currency;
use App\Fetcher\NBPFetcher;
use App\Repository\CurrencyRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'start:currencies',
    description: 'Fetches currencies from chosen date',
)]
class StartCurrenciesCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $em,
        private NBPFetcher $NBPFetcher,
        private CurrencyRepository $currencyRepository,
        string $name = null
    )
    {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->addArgument('date', InputArgument::REQUIRED, 'date');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $date = $input->getArgument('date');

        if (!$date || !preg_match('/20[1-2]\d-(0[1-9]|[1[0-2])-([0-2]\d|3[0-1])/', $date)) {
            $io->error('You must give date in format Y-m-d');
            return Command::FAILURE;
        }

        $currencies = $this->NBPFetcher->setDate($date)->fetch()['rates'] ?? [];

        foreach ($currencies as $currencyData) {
            $currency = $this->currencyRepository->findByCode($currencyData['code']) ?? new Currency();
            $currency->setCode($currencyData['code'])
                ->setName(ucfirst($currencyData['currency']))
                ->setRate($currencyData['mid'])
                ->setUpdatedAt(new DateTime());
            $this->em->persist($currency);
        }

        $io->success('Set currencies (' . count($currencies) . ') from date ' . $date);

        return Command::SUCCESS;
    }
}
