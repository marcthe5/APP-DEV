<?php

namespace App\Http\Controllers\Bizpartner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\glbmbizpartner;
use Carbon\Carbon;

class BizPartnerController extends Controller
{   

    public function showPage(){

        return view('bizpartner/bizpartner_template');
    }

    public function sampleData(){
        $data = [
            [
               /* 'title'   => "Bizpartner",
                'name'    => "Noel",
                'age'     => 1,
                'status'  => ""
                */

                'DELIVERY_ID' =>"10001",
			'DELIVERY_ADDRESS'  => "Cebu City",
			'EMP_NAME'  => "Juan De la Cruz",
			'EMP_PHONE' => "09123456789",
			'EMP_EMAIL' => "juan123@gmail.com",
			'EMP_DELIVERY_DATE' => "04/13/23",
            'EMP_DELIVERY_TIME' => "07:00",
			'EMP_DELIVERY_INSTRUCTION' => "Deliver at Arrival Time!",
			'EMP_SHIPPING_METHOD' => "COD",
			'EMP_SHIPPING_CARRIER' => "LBC",
            'EMP_TRACKING_NUMBER' => "12345",
			'EMP_PACKAGE_WEIGHT' => "10kg",
			'EMP_PACKAGE_DIMENSION' => "10x10",
			'EMP_DELIVERY_CONFIRMATION' => "true",
			'EMP_SIGNATURE_REQUIRED'	=> "true",
			'EMP_ORDER_NUMBER' => "01",
			'EMP_SHIPPING_COST' => "100.00",
			'EMP_INSURANCE' => "50.00",
			'EMP_CUSTOMS_INFO' => "false",
			'EMP_ORDER_STATUS' => "Shipping"
            ]
    
        ];

        return $data;
    }


    public function createBP(Request $request){
    
        $createBpData[] = $request->all();
        $return = [];

        try{

            $date = date('Y-m-d H:i:s');
            $newDate = Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('m/d/Y');

            foreach($createBpData as $k => $v){
                $createBpData[$k]['ADDRESS_ID'] =  1000112;
                $createBpData[$k]['DEL_FLAG'] =  ($createBpData[$k]['DEL_FLAG']) ? "X" : ""; 
                $createBpData[$k]['created_at'] =  \Carbon\Carbon::now();
                $createBpData[$k]['created_by'] =  "Noel";
                $createBpData[$k]['updated_by'] =  "Noel";
            }
           
            glbmbizpartner::insert($createBpData);
        }catch(\Exception $e){
            Log::error($e);
            $return['error']  = true;
            $return['message'] = $e->getMessage();
        }

        return compact('return','createBpData');

    }

    public function updateBP(Request $request){
    
        $updateBpData = (!empty($request->get('bpDataupdate')) ? $request->get('bpDataupdate') : []);
        $bpId = (!empty($request->get('BP_ID')) ? $request->get('BP_ID') : "");

        $return = [];

        try{
          
            foreach($updateBpData as $k => $v){
                $updateBpData[$k]['DEL_FLAG'] =  ($updateBpData[$k]['DEL_FLAG']) ? "X" : ""; 
                $updateBpData[$k]['updated_at'] =  \Carbon\Carbon::now();
                $updateBpData[$k]['created_by'] =  "Noel";
                $updateBpData[$k]['updated_by'] =  "Noel";
            }
            
            glbmbizpartner::where('DELIVERY_ID',$bpId)->update($updateBpData[0]);
        }catch(\Exception $e){
            Log::error($e);
            $return['error']  = true;
            $return['message'] = $e->getMessage();
        }

        return compact('return','updateBpData');

    }

    public function getBpById($bpId){
        
        $bpId = base64_decode($bpId);
        $getBpById = glbmbizpartner::where('DELIVERY_ID',$bpId)->get();
        
        return $getBpById;
    }

    public function getBpData(){

        $data = glbmbizpartner::get();

        return $data;
    }

    public function removeBpById(Request $request){
        $bpId = (!empty($request->get('BP_ID')) ? $request->get('BP_ID') : "");
        
        try{

            $getBpById = glbmbizpartner::where('DELIVERY_ID',$bpId)->delete();

        }catch(\Exception $e){
            Log::error($e);
            $return['error']  = true;
            $return['message'] = $e->getMessage();
        }
        
        
        return $getBpById;
    }
    


   
}