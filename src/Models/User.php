<?php

declare(strict_types=1);

namespace src\Models;

use PDO;
use src\Config\DB;
use src\Exceptions\DatabaseException;

class User
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = DB::getConnection();
    }

    public function getUserByEmail(string $email): ?array
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
