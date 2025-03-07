<?php
class FormHandler
{
    private array $errors = [];

    public function __construct(
        private string $first_name,
        private ?string $middle_name, //'?' is used to make the property optional
        private string $last_name,
        private string $address,
        private string $email,
        private PDO $construction
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        // Validate first name
        if (empty($this->first_name)) {
            $this->errors[] = "First name is required.";
        }

        // Validate last name
        if (empty($this->last_name)) {
            $this->errors[] = "Last name is required.";
        }

        // Validate address
        if (empty($this->address) || strlen($this->address) < 6) {
            $this->errors[] = "Address is required and must be at least 6 characters long.";
        }

        // Validate email. PHP has a built-in function to validate email addresses
        if (empty($this->email) || !filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "A valid email address is required.";
        }
    }

    public function process(): void
    {
        if (empty($this->errors)) {
            try {
                $stmt = $this->construction->prepare("INSERT INTO users (first_name, middle_name, last_name, address, email) VALUES (:first_name, :middle_name, :last_name, :address, :email)"); //Prepare the SQL statement
                $stmt->execute([ //Replaces placeholders with actual values
                    ':first_name' => $this->first_name, //The placeholder is :first_name
                    ':middle_name' => $this->middle_name,
                    ':last_name' => $this->last_name,
                    ':address' => $this->address,
                    ':email' => $this->email,
                ]);

                echo "Form submitted successfully!";
            } catch (PDOException $e) { //Catch any exceptions in the database
                echo "Error: " . $e->getMessage();
            }
        } else {
            // Display errors
            foreach ($this->errors as $error) {
                echo "<p>$error</p>";
            }
        }
    }
}
