<?php
/**
 * Date: 2018/8/24
 * Time: 16:40
 */

namespace App\Utils;


trait Error
{
    private $errMsg;

    private $errCode;

    public function errMsg()
    {
        return $this->errMsg;
    }

    public function errCode()
    {
        return $this->errCode;
    }

    private function setErr($msg, $code = 0)
    {
        $this->errMsg = $msg;
        $this->errCode = $code;
    }
}