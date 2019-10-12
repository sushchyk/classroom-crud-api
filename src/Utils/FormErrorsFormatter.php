<?php

namespace App\Utils;

use Symfony\Component\Form\FormInterface;

class FormErrorsFormatter
{
    public function formatFormErrors(FormInterface $form)
    {
        $errors = [];
        foreach ($form->getErrors(true, true) as $error) {
            $errorKey = $error->getOrigin()->getName();
            $errorMessage = $error->getMessage();
            $errors[] = "$errorKey: $errorMessage";
        }

        return $errors;
    }
}