<?php
// namespace Lattefront\FormHandeling\Service;

// class OrderService
// {
//     public static function calculateTotalPrice(array $cartItems): float
//     {
//         $totalPrice = 0.0;
//         foreach ($cartItems as $item) {
//             $totalPrice += $item['price'] * $item['quantity'];
//         }
//         return $totalPrice;
//     }

//     public static function paymentMethod(array $productTypes): array
//     {
//         $availableMethods = [];
//         $physical=0;
//         $digital=0;
//         // ["digital","physical"]
//         // count = 1 and that is digital 
//         // option[]="esewa"
//         // count = 1 and that is physical 
//         // option[]="cod"
//         // if array_in("digital") and array_in("physical")
//         // option[]="cod"

//         // array_unique(array_column($arr,"type"));

//         foreach ($productTypes as $type) {
//             if ($type == "digital") {
//                 $availableMethods[] = "Khalti";
//                 $digital+=1;
                
//             }
//             if ($type == "physical") {
//                 $availableMethods[] = "Cash on Delivery";
//                 $availableMethods[] = "Esewa";
//                 $physical+=1;
//             }
            
//         }
//         if($physical !=0 && $digital!=0){
//             $availableMethods[] = "Khalti";
//             $availableMethods[] = "Esewa";
//         }
//         return $availableMethods;  
//     }
    
// }