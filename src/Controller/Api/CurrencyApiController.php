<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\CurrencyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyApiController extends AbstractController
{
    /**
     * @Route("/api/currency/add", name="add_currency", methods={"POST"})
     */
    public function remove(Request $request, CurrencyRepository $currencyRepository): Response
    {
        $currencyId = $request->get('currencyId', false);
        if (!$currencyId) {
            return $this->json([], 400);
        }

        $currency = $currencyRepository->find($currencyId);
        if (!$currency) {
            return $this->json([], 400);
        }

        /** @var ?User $user */
        $user = $this->getUser();
        $user->addFavouriteCurrency($currency);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        $html = $this->render('components/single-currency.html.twig', ['currency' => $currency]);

        return $this->json(['html' => $html]);
    }

    /**
     * @Route("/api/currency/remove", name="remove_currency", methods={"POST"})
     */
    public function add(Request $request, CurrencyRepository $currencyRepository): Response
    {
        $currencyId = $request->get('currencyId', false);
        if (!$currencyId) {
            return $this->json([], 400);
        }

        $currency = $currencyRepository->find($currencyId);
        if (!$currency) {
            return $this->json([], 400);
        }

        /** @var ?User $user */
        $user = $this->getUser();
        $user->removeFavouriteCurrency($currency);

        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->json([]);
    }
}
