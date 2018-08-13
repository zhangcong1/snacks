<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/8/7
 * Time: 9:51
 */

namespace app\lib\exception;


use Exception;
use think\exception\Handle;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code = 400;
    private $msg = '';
    private $errorCode = 40000;
    public function render(Exception $e)
    {
        if ($e instanceof BaseException){
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }else{
            if (config("app_debug")){
                return parent::render($e);
            }else{
                $this->code = 500;
                $this->msg = '服务器内部错误';
                $this->errorCode = 999;
            }
        }
        $request = Request::instance();
        $result = [
            "msg" => $this->msg,
            "error_code" => $this->errorCode,
            "url" => $request->url()
        ];
        return json($result,$this->code);
    }
}