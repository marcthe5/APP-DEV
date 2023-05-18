<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\delivery;

class DeliveryController extends Controller
{
    public function insertDelivery(Request $request){

        $data = [
            
                'DELIVERY_ID' => '1001',
                'DELIVERY_ADDRESS' => '1001',
                'EMP_NAME' => '1001',
                'EMP_PHONE' => '1001',
        ];

        delivery::insert($data);
    }
}
