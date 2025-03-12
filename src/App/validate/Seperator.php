<?php

namespace App\validate;

error_reporting(E_ALL);
ini_set('display_errors', 1);
class Seperator
{
    public static function seperate(string $fullname)
    {
        $result = [
            "firstName" => "",
            "middleName" => "",
            "lastName" => "",
        ];

        $trimmedFullName = preg_replace("/\s+/", " ", $fullname);
        $seperatedFullName = explode(" ", $trimmedFullName);

        switch (count($seperatedFullName)) {
            case 1:
                $result["firstName"] = $seperatedFullName[0];
                break;
            case 2:
                $result["firstName"] = $seperatedFullName[0];
                $result["lastName"] = $seperatedFullName[1];
                break;

            case 3:
                $result["firstName"] = $seperatedFullName[0];
                $result["middleName"] = $seperatedFullName[1];
                $result["lastName"] = $seperatedFullName[2];
                break;
        }
        return $result;
    }
}
