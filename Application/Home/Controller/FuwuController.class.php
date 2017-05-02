<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/2 0002
 * Time: 上午 10:50
 */

namespace Home\Controller;


class FuwuController extends HomeController
{
    public function Identity(){
        if(!$this->login()){
            if(1){};
        }
    }
}