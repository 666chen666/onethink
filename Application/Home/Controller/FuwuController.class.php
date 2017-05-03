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
                $data=$identity->create($data);
                //var_dump($data);exit;
                if($data){
                    $identity->add($data);
                    $this->redirect('index/index');
                }else{

                }
                $this->redirect('Fuwu/index');
            }
            $this->display();
        }
    }
    public function tips(){

    }

}