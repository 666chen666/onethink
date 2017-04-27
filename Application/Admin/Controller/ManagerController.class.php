<?php
namespace Admin\Controller;


class ManagerController extends AdminController
{
    public function index(){
        /* 获取频道列表 */
        $repair = M('repair');
        $count = $repair->count();
        $page = new \Think\Page($count,2);
        $list = M('repair')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('page',$page->show());
        $this->assign('list', $list);
        $this->meta_title = '报修管理';
        $this->display('index');
    }
    public function add(){
            if(IS_POST){
                $Channel = D('repair');
                $data = $Channel->create();
                if($data){
                    $Channel->time=time();
                    $Channel->sn=rand(1000,9999);
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
                $this->assign('info',null);
                $this->meta_title = '新增报修';
                $this->display('edit');
            }
    }
    public function edit($id = 0){
        if(IS_POST){
            $Channel = D('repair');
            $data = $Channel->create();
            if($data){
                if($Channel->save()){
                    //记录行为
                    action_log('update_repair', 'repair', $data['id'], UID);
                    $this->success('编辑成功', U('index'));
                } else {
                    $this->error('编辑失败');
                }

            } else {
                $this->error($Channel->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('repair')->find($id);

            if(false === $info){
                $this->error('获取配置信息错误');
            }
            $this->assign('info', $info);
            $this->meta_title = '编辑导航';
            $this->display();
        }
    }
    public function del(){
        $id = array_unique((array)I('id',0));

        if ( empty($id) ) {
            $this->error('请选择要操作的数据!');
        }

        $map = array('id' => array('in', $id) );
        if(M('repair')->where($map)->delete()){
            //记录行为
            action_log('update_repair', 'repair', $id, UID);
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
}