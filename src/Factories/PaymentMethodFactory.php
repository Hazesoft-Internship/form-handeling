<?php

namespace Hazesoft\Backend\Factories;

use Exception;

class PaymentMethodFactory
{
    public function getPaymentMethods($productTypes){
        try {
            $typeArray = [];
            foreach ($productTypes as $type) {
                $typeArray[] = $type["type"];
            }
            if ((in_array("physical", $typeArray)) && (in_array("digital", $typeArray))) {
                return ["eSewa", "Khalti"];
            } elseif (in_array("physical", $typeArray)) {
                return ["Cash on Delivery", "eSewa"];
            } elseif (in_array("digital", $typeArray)) {
                return ["Khalti"];
            } else {
                return [];
            }
        } catch (Exception $exception) {
            echo ($exception->getMessage());
            return null;
        }
    }
}