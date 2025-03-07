<?php

class UserInserter
{
    private $file;

    //Constructor to open the CSV file
    public function __construct(private string $filename, private PDO $pdo)
    {
        $this->file = fopen($filename, 'a');
        $this->pdo = $pdo;

        // Check if the file is empty and write headers if it is
        if (filesize($filename) == 0) {
            fputcsv($this->file, ['Full Name', 'Address', 'Email']);
        }
    }
    //Destructor to close the CSV file
    public function __destruct()
    {
        fclose($this->file);
    }

    //Function to generate random user data
    private function generateRandomUser()
    {
        $first_names = ['Ram', 'Laxman', 'Hari', 'Shreya', 'Laxmi', 'Avantika', 'Venu', 'Farukh', 'Fatima', 'Akanshya'];
        $middle_names = ['Kumar', 'Gopal', 'Kumari', 'Devi', 'Kaur', 'Rani', 'Ali', 'Begum', 'Prasad', 'Bahadur'];
        $last_names = ['Sharma', 'Khan', 'Thapa', 'Rai', 'Pandey', 'Tamang', 'Shrestha', 'Gurung', 'Rana', 'Bhattarai', 'Iyer'];
        $addresses = ['Kathmandu', 'Lalitpur', 'Bhaktapur', 'Pokhara', 'Biratnagar', 'Butwal', 'Dharan', 'Hetauda', 'Birgunj', 'Nepalgunj'];
        $domains = ['gmail.com', 'live.com', 'hotmail.com'];

        $first_name = $first_names[array_rand($first_names)];
        $middle_name = rand(0, 1) ? $middle_names[array_rand($middle_names)] : NULL;
        $last_name = $last_names[array_rand($last_names)];
        $address = $addresses[array_rand($addresses)];
        $email = strtolower($first_name) . '.' . strtolower($last_name) . '@' . $domains[array_rand($domains)];

        // Return an associative array with user data
        return [
            'first_name' => $first_name,
            'middle_name' => $middle_name,
            'last_name' => $last_name,
            'address' => $address,
            'email' => $email
        ];
    }

    //Function to insert multiple users into the CSV file and database
    public function insertUsers($count)
    {
        for ($i = 0; $i < $count; $i++) {
            $user = $this->generateRandomUser();
            $full_name = trim($user['first_name'] . ' ' . ($user['middle_name'] ?? '') . ' ' . $user['last_name']);
            fputcsv($this->file, [$full_name, $user['address'], $user['email']]);
            $this->insertUserIntoDatabase($user);
        }
    }

    //Function to insert a single user into the database
    private function insertUserIntoDatabase($user)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (first_name, middle_name, last_name, address, email) VALUES (:first_name, :middle_name, :last_name, :address, :email)");
        $stmt->execute([
            ':first_name' => $user['first_name'],
            ':middle_name' => $user['middle_name'],
            ':last_name' => $user['last_name'],
            ':address' => $user['address'],
            ':email' => $user['email']
        ]);
    }
}
