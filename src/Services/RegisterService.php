<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Traits\Validator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterService
{
    use Validator;

    private ?User $user;

    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private UserRepository $userRepository
    )
    {
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function validate(string $nick, string $password, string $passwordRepeat): bool
    {
        $sameNickUser = $this->userRepository->getUserByNick($nick);
        // Check if nick is unique
        if ($sameNickUser !== []) {
            $this->addError('nick', 'Ten nick jest już zajęty');
        }
        // Check if nick has at least 5 chars
        if (strlen($nick) < 5) {
            $this->addError('nick', 'Nick jest za krótki, min 5 znaków');
        }
        // Check if passwords match
        if ($password !== $passwordRepeat) {
            $this->addError('password', 'Hasła są różne');
            $this->addError('password-repeat', 'Hasła są różne');
        }
        // Check if password has at least 8 chars
        if (strlen($password) < 8) {
            $this->addError('password', 'Hasło za krótkie, min 8 znaków');
            $this->addError('password-repeat', 'Hasło za krótkie, min 8 znaków');
        }

        if ($this->isValid()) {
            $user = new User();
            $user->setNick($nick)
                ->setPassword($this->userPasswordHasher->hashPassword($user, $password));
            $this->user = $user;

            return true;
        }

        return false;
    }
}