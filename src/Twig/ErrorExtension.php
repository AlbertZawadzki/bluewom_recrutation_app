<?php

namespace App\Twig;

use App\Model\ErrorModel;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ErrorExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('has_field_error', [$this, 'hasFieldError']),
            new TwigFunction('get_field_error', [$this, 'getFieldError']),
        ];
    }

    /**
     * @param ErrorModel[] $errors
     */
    public function hasFieldError(array $errors, string $field): bool
    {
        foreach ($errors as $error) {
            if ($error->getField() === $field) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param ErrorModel[] $errors
     */
    public function getFieldError(array $errors, string $field): ?ErrorModel
    {
        foreach ($errors as $error) {
            if ($error->getField() === $field) {
                return $error;
            }
        }

        return null;
    }
}