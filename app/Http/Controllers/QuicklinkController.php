<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class QuicklinkController extends Controller
{

    private $_quicklink_host="";
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_quicklink_host=ENV("QUICKLINK_HOST");
    }

    public function get(){
        $client = new Client();
        $url=$this->_quicklink_host."quicklink/1/sku/ASC";
        $res = $client->request('GET', $url);
        $status=$res->getStatusCode();
        $contentType=$res->getHeaderLine('content-type');
        $content=$res->getBody();
        return response($content, $status)->header('Content-Type', $contentType);
    }
    public function post(Request $request){
        try {
            $client = new Client();
            $url = $this->_quicklink_host."quicklink";
            $res = $client->request('POST', $url, [
                'form_params' => $request->all()
            ]);
            $status = $res->getStatusCode();
            $contentType = $res->getHeaderLine('content-type');
            $content = $res->getBody();
        }catch (\GuzzleHttp\Exception\ServerException $e){
            $content= $e->getResponse()->getBody();
            $status=$e->getResponse()->getStatusCode();
            $contentType=$e->getResponse()->getHeaderLine('content-type');
        }
        return response($content, $status)->header('Content-Type', $contentType);
    }
    public function put($sku,Request $request){
        try {
            $client = new Client();
            $url = $this->_quicklink_host."quicklink/".$sku;
            $res = $client->request('PUT', $url, [
                'form_params' => $request->only(['comment','product_name'])
            ]);
            $status = $res->getStatusCode();
            $contentType = $res->getHeaderLine('content-type');
            $content = $res->getBody();
        }catch (\GuzzleHttp\Exception\ServerException $e){
            $content= $e->getResponse()->getBody();
            $status=$e->getResponse()->getStatusCode();
            $contentType=$e->getResponse()->getHeaderLine('content-type');
        }
        return response($content, $status)->header('Content-Type', $contentType);
    }
    public function delete(){

    }
    //
}
