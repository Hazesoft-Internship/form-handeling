<?php 

    $file = fopen("sample_data.csv", "w");

    if($file === false){
        die("Error creating file");
    }

    $firstNames = ["samir", "ramesh", "shishir", "kripesh", "aashish", "pratik", "kalyan", "samaya", "rishikesh", "suraj", "saisagun", "manish", "ashim", "bisesh", "dibesh", "ram", "sumin", "nischal", "alex", "kobid", "bablu", "pintu", "golu", "rabindra", "bibek", "sujal", "diresh", "prasanna"];

    $middleNames = ["prasad", "bahadur", "kumar", "chandra", "prakash", "shekhar"];

    $lastNames = ["deuba", "oli", "dahal", "thapa", "lamichhane", "sharma", "shrestha", "magar", "rai", "neupane", "chapagain", "gywali", "maharjan", "rana", "bhandari"];

    $addresses = ["kohalpur", "sallaghari", "basantapur", "lokanthali", "jhapa", "morang", "ramnagar", "banke", "bardiya", "illam", "panchtahr", "kavre", "syangha", "parvat", "kaski", "rukum", "dolpa", "bajang", "bajura"];

    $domains = ["gmail.com", "hotmail.com", "tu.edu.np", "co.uk", "edu.np", "yahoo.com", "hazesoft.co", "facebook.co", "meta.co", "moe.np", "mof.np", "mit.us", "ioe.np"];

fputcsv($file, ["fullname", "address", "email"]);


for($i=0; $i<10000; $i++){
        $fName = $firstNames[array_rand($firstNames)];
        $mName = $middleNames[array_rand($middleNames)];
        $lName = $lastNames[array_rand($lastNames)];
        $address = $addresses[array_rand($addresses)];
        $domain = $domains[array_rand($domains)];


        $fullName = $fName." ".$mName." ".$lName;
        $email = strtolower($fName).strtolower($lName).rand(1,999)."@".$domain;

        fputcsv($file, [$fullName, $address, $email]);
    }

    fclose($file);

?>