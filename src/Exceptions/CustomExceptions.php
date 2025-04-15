<?php

declare(strict_types=1);

namespace src\Exceptions;

abstract class CustomException extends \Exception
{
    abstract public function handle(): void;
}
