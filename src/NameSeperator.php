<?php
class NameSeperator
{
    public static function seperate(string $fullname)
    {
        $stringSeperate = preg_replace("/\s+/", " ", $fullname);

        $arraySeperate = explode(" ", $stringSeperate);
        $seperateLength = count($arraySeperate);
        $result = [
            "firstName" => "",
            "middleName" => "",
            "lastName" => "",
        ];

        switch ($seperateLength) {
            case 1:
                $result["firstName"] = $arraySeperate[0];
                break;
            case 2:
                $result["firstName"] = $arraySeperate[0];
                $result["lastName"] = $arraySeperate[1];
                break;
            case 3:
                $result["firstName"] = $arraySeperate[0];
                $result["middleName"] = $arraySeperate[1];
                $result["lastName"] = $arraySeperate[2];
                break;
        }
        return $result;
    }
}
