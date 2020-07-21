<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CsvImportRequest;
use Illuminate\Support\Facades\Validator;
use Importer;
use Excel;
use App\Ph_ip;
use App\Ph_price;
use DB;

class ImportController extends Controller
{

    public function phonePriceIp()
    {   
        $info = $this->getphonePriceIp();
        echo "<pre>"; print_r($info); echo "</pre>";
    }

    public function getphonePriceIp(){
        $info = DB::table('ph_prices as price')->join('ph_ips as ip', 'price.ph', '=','ip.ph')
                                               ->get();
    }
    public function uploadFile(CsvImportRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'price' => 'required|max:5000|mimes:xlsx,xls,csv',
            'ip' => 'required|max:5000|mimes:xlsx,xls,csv',
        ]);
        // upload to server
        $price = $request->file('price');
        $ip = $request->file('ip');
        $pathIp = public_path('/upload/ph_ips/');
        $pathPrice = public_path('/upload/ph_prices/');
        $path_price = $this->uploadToServer($price, $pathIp);
        $path_ip    = $this->uploadToServer($ip, $pathPrice);
        // upload to server
        // get CSV data
        $dataIp     = $this->getCsvArr($path_ip);
        $dataPrice  = $this->getCsvArr($path_price);
        // get CSV data
        // upload to db
        $dataIp     = $this->getDbArr($dataIp, 1);
        $dataPrice  = $this->getDbArr($dataPrice, 2);
        Ph_ip::insert($dataIp);
        Ph_price::insert($dataPrice);
        echo "<pre>"; print_r($dataIp); echo "</pre>";
        echo "<pre>"; print_r($dataPrice); echo "</pre>";
        
    }

    public function getCsvArr($path){
        $data = \Excel::toArray('', $path, null, \Maatwebsite\Excel\Excel::TSV)[0];
        return $data;
    }

    public function uploadToServer ($file,$savePath){
        $dateTime = strtotime(date('Y-m-d H:i:s'));
        $fileName = $dateTime . '-' . $file->getClientOriginalName();
        $savePath = public_path('/upload/');
        $file->move($savePath, $fileName);
        $path = $savePath . $fileName;
        return $path;
    }

    public function getDbArr ($data,$flag)
    {
        $result = array();
        foreach ($data as $value) 
        {
            if(sizeof($value) == 2){
                if ($flag == 1) 
                {
                    $result[]= array(
                                        "ph"            => $value[0],
                                        "ip"            => $value[1],
                                        "created_at"    => date('Y-m-d H:i:s'),
                                        "updated_at"    => date('Y-m-d H:i:s'),
                                    ); 
                }else{
                    $result[]= array(
                                        "ph"            => $value[0],
                                        "price"         => $value[1],
                                        "created_at"    => date('Y-m-d H:i:s'),
                                        "updated_at"    => date('Y-m-d H:i:s'),
                                    );              
                }
            }
            
        }
        return $result;
    }

    

    

}
