<?php

namespace App\Models;

use App\Config\DataBase;




use Exception;
use PDO;

class ProductModel
{
    public object $connection;

    public function __construct()
    {
        $this->connection = DataBase::connect();
    }

    public function insertProduct(string $name,  string $description, float $price, int $quantity, int $userId): void
    {
        try {
            $sql = "INSERT INTO products (name, description, price,quantity,user_id) VALUES ( ?, ?,?,?,?)";
            $statement = $this->connection->prepare($sql);
            // $statement->bind_param("ssdii", $name, $description, $price, $quantity, $userId);
            $statement->bindParam(1, $name, PDO::PARAM_STR);
            $statement->bindParam(2, $description, PDO::PARAM_STR);
            $statement->bindParam(3, $price, PDO::PARAM_INT);
            $statement->bindParam(4, $quantity, PDO::PARAM_INT);
            $statement->bindParam(5, $userId, PDO::PARAM_INT);

            if ($statement->execute()) {
                echo "Product added successfully!";
            } else {
                throw new Exception("Error executing query: " . $statement->error);
            }
        } catch (\PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }

    public function updateProduct(int $id, string $name, string $description, float $price, int $quantity): bool
    {
        try {
            $sql = "UPDATE products SET name = ?, description = ?, price = ?, quantity = ? WHERE product_id = ?";
            $statement = $this->connection->prepare($sql);
            // $statement->bind_param("ssdii", $name, $description, $price, $quantity, $id);
            $statement->bindParam(1, $name, PDO::PARAM_STR);
            $statement->bindParam(2, $description, PDO::PARAM_STR);
            $statement->bindParam(3, $price, PDO::PARAM_INT);
            $statement->bindParam(4, $quantity, PDO::PARAM_INT);
            $statement->bindParam(5, $id, PDO::PARAM_INT);

            if ($statement->execute()) {

                return true;
            } else {
                return false;
            }
        } catch (\PDOException $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        }
    }

    public function deleteProduct(int $id): bool
    {
        try {
            $sql = "DELETE FROM products WHERE product_id = ?";
            $statement = $this->connection->prepare($sql);
            // $statement->bind_param("i", $id);
            $statement->bindParam(1, $id, PDO::PARAM_INT);

            if ($statement->execute()) {
                // echo "Product deleted successfully!";
                return true;
            } else {
                return false;
            }
        } catch (\PDOException $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return false;
        }
    }

    public function getAllProducts(): array
    {
        try {
            $sql = "SELECT * FROM products";
            $statement = $this->connection->prepare($sql);
            if ($statement->execute()) {
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                if ($result == false) {
                    throw new Exception("Error fetching products: " . $statement->error);
                }


                return $result;
            } else {
                throw new Exception("Error executing query: " . $statement->error);
            }
        } catch (\PDOException $exception) {
            echo "Error: " . $exception->getMessage();
            return [];
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
            return [];
        }
    }

    public function getUserProducts(int $userId): array
    {
        try {
            $sql = "SELECT * FROM products WHERE user_id = ?";
            $statement = $this->connection->prepare($sql);
            // $statement->bind_param("i", $userId);
            $statement->bindParam(1, $userId, PDO::PARAM_INT);

            if ($statement->execute()) {
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);

                if ($result == false) {
                    return [];
                }
                return $result;
            } else {
                throw new Exception("Error executing query: " . $statement->error);
            }
        } catch (\PDOException $exception) {
            echo "Error: " . $exception->getMessage();
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        }
    }
}
