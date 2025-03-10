<?php

    require_once "upload.php";

    class InsertUser {
        public $file;
        private $line;
        
        public function __construct() {
            $this->file = fopen(filename: 'users.csv', mode: "r");
            $this->line = fgetcsv($this->file);
        }

        public function upload(): void
        {

            while($this->line) {
                $wordArray = explode(" ", $this->line[0]);
                if (count($wordArray) == 2) {
                    list($fName, $lName) = explode(" ", $this->line[0], 2);
                    $mName = "";
                    $user1 = new User;
                    $user1->createUser($fName, "", $lName, $this->line[1],$this->line[2]);
                }
                else{
                    list($fName, $mName, $lName) = explode(" ", $this->line[0], 3);
                    
            $user1 = new User;
            $user1->createUser($fName, $mName, $lName, $this->line[1],$this->line[2]);
                }
                //fetches the next row of elements
                $this->line = fgetcsv($this->file );
            }
        }

        public function uploadToDB(): void 
        {
        }
    }

        $insert1 = new InsertUser;
        $insert1->upload();
    // also add the validation for the data array of the csv file.
?>