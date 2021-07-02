<?php

namespace App\Controller;

use App\Services\RegisterService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthenticatorController extends AbstractController
{
    /**
     * @Route("/logowanie", name="app_login", methods={"GET","POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $infoLogin = $request->get('info_login') ?? false;
        $infoRegister = $request->get('info_register') ?? false;

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/index.html.twig', [
            'login_username' => $lastUsername,
            'error' => $error,
            'info_login' => $infoLogin,
            'info_register' => $infoRegister,
        ]);
    }

    /**
     * @Route("/rejestracja", name="app_register", methods={"POST", "GET"})
     */
    public function register(Request $request, RegisterService $registerService)
    {
        $nick = $request->get('nick', '');
        $password = $request->get('password', '');
        $passwordRepeat = $request->get('password-repeat', '');

        if ($registerService->validate($nick, $password, $passwordRepeat)) {
            try {
                $user = $registerService->getUser();
                $this->getDoctrine()->getManager()->persist($user);
                $this->getDoctrine()->getManager()->flush();

                $request->getSession()->set(Security::LAST_USERNAME, $nick);

                return $this->redirectToRoute('app_login', [
                    'info_login' => 'Zaloguj się nowym kontem'
                ]);
            } catch (Exception $e) {
                return $this->redirectToRoute('app_login',
                    [
                        'info_register' => 'Coś poszło nie tak: ' . $e->getMessage()
                    ]
                );
            }
        }

        return $this->render('security/index.html.twig', [
            'register_nick' => $nick,
            'errors' => $registerService->getErrors()
        ]);
    }

    /**
     * @Route("/wyloguj", name="app_logout")
     */
    public function logout()
    {
    }
}
