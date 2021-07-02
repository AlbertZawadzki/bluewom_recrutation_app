<?php

namespace App\Handler;

use App\Model\ErrorModel;

trait ErrorHandler
{
    private iterable $errors = [];

    public function addFieldError(string $field, string $message): void
    {
        $this->errors[] = new ErrorModel($field, null, $message);
    }

    public function addNamedError(string $name, string $message): void
    {
        $this->errors[] = new ErrorModel(null, $name, $message);
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