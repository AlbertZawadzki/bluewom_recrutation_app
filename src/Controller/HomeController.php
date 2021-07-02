<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\CurrenciesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET", "POST"})
     */
    public function index(Request $request, CurrenciesService $currenciesService): Response
    {
        $currencies = $currenciesService->getCurrencies();

        /** @var ?User $user */
        $user = $this->getUser();

        // On post remove all currencies
        if ($request->isMethod('POST') && $user) {
            foreach ($user->getFavouriteCurrencies() as $currency) {
                $user->removeFavouriteCurrency($currency);
            }
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
        }

        $userCurrencies = $user ? $user->getFavouriteCurrencies() : [];

        return $this->render('home/index.html.twig',
            [
                'currencies' => $currencies,
                'userCurrencies' => $userCurrencies
            ]
        );
    }
}
