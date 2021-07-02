<?php

namespace App\Traits;

use App\Model\ErrorModel;

trait Validator
{
    private iterable $errors = [];

    public function addError(string $field, string $message): void
    {
        $this->errors[] = new ErrorModel($field, null, $message);
    }

    public function isValid(): bool
    {
        return $this->errors === [];
    }

    public function hasErrors(): bool
    {
        return $this->errors !== [];
    }

    /**
     * @return ErrorModel[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasError(string $field): bool
    {
        foreach ($this->errors as $error) {
            if ($error['field'] === $field) {
                return true;
            }
        }

        return false;
    }

    public function getErrorMessage(string $field): string
    {
        foreach ($this->errors as $error) {
            if ($error['field'] === $field) {
                return $error['message'];
            }
        }

        return "";
    }
}