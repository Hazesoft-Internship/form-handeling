<?php

namespace App\Data;
use Exception;


class Data
{

    public static function getData(string $path)
    {

        try {
            $file = fopen($path, "r");

            if (!$file) {
                throw new Exception("File not found");
            }

            $data = [];

            while (($line = fgetcsv($file)) !== false) {
                $data[] = $line;
            }
            return $data;
        } catch (Exception $exception) {
            echo "Error: " . $exception->getMessage();
        } finally {
            fclose($file);
        }
    }
}
