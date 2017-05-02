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
        if($this->login()){
           $this->redirect('home/user/login');
        }else{
            if(IS_POST){
                $identity = D('Identity');
                $data=I('post.');
                $user=session('user_auth');
                $data['aid']=$user['uid'];
                $res=$identity->add($data);
                if($res){
                    $this->redirect('index/index');
                }
                $this->redirect('Fuwu/index');
            }
            $this->display();
        }
    }
}