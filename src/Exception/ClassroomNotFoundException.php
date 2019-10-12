<?php

namespace App\Exception;

use Throwable;

class ClassroomNotFoundException extends \DomainException
{
    public function __construct(int $classroomId)
    {
        parent::__construct("Classroom with id `$classroomId` not found.");
    }
}