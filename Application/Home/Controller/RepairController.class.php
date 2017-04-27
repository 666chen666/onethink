<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/27 0027
 * Time: 上午 10:37
 */

namespace Home\Controller;
use Think\Controller;

class RepairController extends HomeController
{
    public function add(){
        if(!$this->login()){
            if(IS_POST){
                $Channel = D('repair');
                $data = $Channel->create();
                if($data){
                    $Channel->sn=rand(1000,99999);
                    //var_dump($Channel);exit;
                    $id = $Channel->add();
                    if($id){
                        $this->success('新增成功', U('index'));
                        //记录行为
                        action_log('update_repair', 'repair', $id, UID);
                    } else {
                        $this->error('新增失败');
                    }
                } else {
                    $this->error($Channel->getError());
                }
            } else {
                $this->display();
            }
        }
    }
}