<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\CurrenciesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CurrenciesService $currenciesService): Response
    {
        $currencies = $currenciesService->getCurrencies();

        /** @var ?User $user */
        $user = $this->getUser();
        $userCurrencies = $user ? $user->getFavouriteCurrencies() : [];

        return $this->render('home/index.html.twig',
            [
                'currencies' => $currencies,
                'userCurrencies' => $userCurrencies
            ]
        );
    }
}
