<?php

declare(strict_types=1);

namespace src\Exceptions;

class DatabaseException extends CustomException
{
    public function handle(): void
    {
        error_log("Database Error: " . $this->getMessage());
        echo "A database error occurred. Please try again later.";
    }
}
?>