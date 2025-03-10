<?php

declare(strict_types=1);

require 'classes/DB.php';
require 'classes/User.php';

use Classes\DB;
use Classes\User;

$db = new DB();
$user = new User($db);

$csvFile = 'dummy.csv';
$batchSize = 1000;
$totalUsers = 10000;

// Generating random dummy data  
$firstNames = ['Lalit', 'Kushal', 'Rohit', 'Sompal', 'Paras', 'Binod', 'Karan', 'Sandeep', 'Asif', 'Arif'];
$middleNames = ['Kumar', 'Lal', 'Gopal', 'Krishna', 'Bahadur', 'Bhopal', 'Bir', 'Dev', 'Dhoj', 'Bhagat'];
$lastNames = ['Rajbanshi', 'Bhurtel', 'Malla', 'Kami', 'Khadka', 'Bhandari', 'K.C', 'Lamichane', 'Seikh', 'Paudel'];
$adresses = ['Gaushala', 'Baneshwor', 'Chabel', 'Ratnapark', 'Tripureshwor', 'Sundhara', 'Jawalakhel', 'Ekantakuna', 'New Road', 'Tinkune'];
$domains = ['example.com', 'test.com', 'mail.com', 'random.org', 'demo.net'];

function getRandomElement(array $array): string {
    return $array[array_rand($array)];
}

function generateUser(int $id): array {
    global $firstNames, $middleNames, $lastNames, $adresses, $domains;
    
    $firstName = getRandomElement($firstNames);
    $middleName = getRandomElement($middleNames);
    $lastName = getRandomElement($lastNames);
    
    $address = rand(100, 9999) . ' ' . getRandomElement($adresses);
    $email = strtolower($firstName . '.' . $lastName . $id . '@' . getRandomElement($domains));

    return [
        'full_name' => "$firstName $middleName $lastName",
        'address' => $address,
        'email' => $email
    ];
}

// Writing dummy data into a CSV file
$fp = fopen($csvFile, 'w');


fputcsv($fp, ['full_name', 'address', 'email']);

$users = [];

for ($i = 1; $i <= $totalUsers; $i++) {
    $users[] = generateUser($i);
    
    if (count($users) === $batchSize) {
        foreach ($users as $user) {
            fputcsv($fp, $user);
        }
        $users = []; 
    }
}


foreach ($users as $user) {
    fputcsv($fp, $user);
}

fclose($fp);

echo "Generated and saved 10,000 random users to $csvFile\n <br>";

// Inserting dummy data from generated dummy CSV file into exisiting database
$db = new DB();
$user = new User($db);

$csvFile = fopen('dummy.csv', 'r');
fgetcsv($csvFile);  

$users = [];

while (($row = fgetcsv($csvFile)) !== false) {
    [$fullName, $address, $email] = $row;
    $names = explode(' ', $fullName);

    $userData = [
        'first_name' => $names[0] ?? '',
        'middle_name' => $names[1] ?? '',
        'last_name' => $names[2] ?? '',
        'address' => $address,
        'email' => $email
    ];

    $users[] = $userData;

    if (count($users) === $batchSize) {
        insertBatch($users, $user);
        $users = [];
    }
}

if (count($users) > 0) {
    insertBatch($users, $user);
}

fclose($csvFile);

echo "10,000 users inserted successfully into the database.\n";

function insertBatch(array $users, User $user): void
{
    foreach ($users as $userData) {
        $user->insertUser($userData);
    }
}