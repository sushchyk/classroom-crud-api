<?php

namespace App\Exception;

class ValidationException extends \DomainException
{
    /**
     * @var array
     */
    private $validationErrors;

    public function __construct(array $validationErrors)
    {
        $this->validationErrors = $validationErrors;
        parent::__construct('Data is invalid');
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }
}