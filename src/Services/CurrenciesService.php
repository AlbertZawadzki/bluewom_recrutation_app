<?php


namespace App\Services;


use App\Entity\Currency;
use App\Fetcher\NBPFetcher;
use App\Repository\CurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use DateTime;

class CurrenciesService
{
    public function __construct(
        private NBPFetcher $NBPFetcher,
        private CurrencyRepository $currencyRepository,
        private EntityManagerInterface $em
    )
    {
    }

    public function getCurrencies(): array
    {
        $currencies = $this->currencyRepository->findAll();
        $today = (new DateTime());
        $todayString = (new DateTime())->format('Y-m-d');

        // Currencies are up to date
        if ($currencies !== [] && $currencies[0]->getUpdatedAt()->format('Y-m-d') === $todayString) {
            return $currencies;
        }

        // Currencies are outdated - fetch them
        $currencies = $this->NBPFetcher->fetch()['rates'] ?? [];

        foreach ($currencies as $currencyData) {
            $currency = $this->currencyRepository->findByCode($currencyData['code']) ?? new Currency();
            $currency->setCode($currencyData['code'])
                ->setName(ucfirst($currencyData['currency']))
                ->setRate($currencyData['mid'])
                ->setUpdatedAt($today);
            $this->em->persist($currency);
        }

        $this->em->flush();

        return $this->currencyRepository->findAll();
    }
}