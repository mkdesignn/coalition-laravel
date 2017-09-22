<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use SimpleXMLElement;

class HomeController extends Controller
{

    protected $request;
    /**
     * @var Carbon
     */
    private $carbon;

    /**
     * @param Request $request
     * @param Carbon $carbon
     */
    function __construct(Request $request, Carbon $carbon){

        $this->request = $request;
        $this->carbon = $carbon;
    }


    public function getIndex(){

        if( $this->request->ajax() ){
            $file = (array) json_decode(File::get(storage_path()."/app/public/order.json"));
            return $file;
        } else
            return View("home");
    }

    public function postStore(){

        $request = $this->request->only(["product_name", "Quantity", "price_per_item"]);
        $request["Datetime"] = $this->carbon->now()->toDateTimeString();

        $this->generateJsonFile($request)->generateXmlFile($request);

        return File::get(storage_path()."/app/public/order.json");
    }

    private function generateXmlFile($request){

        $file_content = '<root/>';
        if( file_exists(storage_path()."/app/public/order.xml") ){
            $file_content = File::get(storage_path()."/app/public/order.xml");
            if( $file_content == '' )
                $file_content = '<root/>';
        }


        $xml = new SimpleXMLElement($file_content);
        $track = $xml->addChild('product');
        foreach( $request as $key => $req ){
            $track->addChild($key, $req);
        }
//        array_walk_recursive($request, array ($xml, 'addChild'));
        $xml->asXML(storage_path()."/app/public/order.xml");
        return $this;
    }


    private function generateJsonFile($request){

        $file_content = [];
        if(file_exists(storage_path()."/app/public/order.json")){
            $file_content = (array) json_decode(File::get(storage_path()."/app/public/order.json"));
        }
        $next_row = count($file_content) + 1;
        $file_content[$next_row] = (object) $request ;
        File::put(storage_path()."/app/public/order.json", json_encode($file_content));
        return $this;
    }
}
