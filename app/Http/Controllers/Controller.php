<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $_data;

    public function __construct()
    {
        $this->_data['error_code'] = 0;
        $this->_data['data'] = (object)[];
        $this->_data['error_message'] = '';
    }

    public function response()
    {
        if($this->_data['error_code'] != 0)
        {
//            Log::info('error code is not 0', ['data'=>$this->_data, 'input'=>$_REQUEST, 'URI'=>$_SERVER['REQUEST_URI']]);
        }
        return response()->json($this->_data);
    }

    public function setStatus($status)
    {
        $this->_data['error_code'] = $status;
    }

    public function setMsg($errorMessage)
    {
        $this->_data['error_message'] = $errorMessage;
    }


    public function setData($data)
    {


        $this->_data['data'] = $data;

    }

    public function returnJSON($data, $status = 0, $msg = ''){
        $this->setData($data);
        $this->setMsg($msg);
        $this->setStatus($status);
        return $this->response();
    }
}
