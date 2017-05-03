<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Controller;
use OT\DataDictionary;

/**
 * 前台首页控制器
 * 主要获取首页聚合数据
 */
class IndexController extends HomeController {

	//系统首页
    public function index(){

        $category = D('Category')->getTree();
        $lists    = D('Document')->lists(null);

        $this->assign('category',$category);//栏目
        $this->assign('lists',$lists);//列表
        $this->assign('page',D('Document')->page);//分页

                 
        $this->display();
    }
    public function notice(){
        $document = D("Document");
        $notices = $document->where(['category_id'=>40])->page(I('p',1),C('LIST_ROWS'))->select();
        foreach($notices as &$v){
            $v['create_time'] = date('Y-m-d H:i',$v['create_time']);
            $v['path'] = get_cover($v['cover_id'],"path");
            $v['url'] = U('detail',['id'=>$v['id']]);
        }

        if(IS_AJAX){//判断是否是ajax请求
            if(empty($notices)){
                $this->error('没有数据');
            }else{
                $this->success($notices);
            }
        }
        $this->assign('notices',$notices);
        $this->display();
    }
    public function detail($id){
        $detail=D('Document')->where(['id'=>$id])->find();
        $content=D('Document_article')->find($detail['id']);
        $detail['content']=$content['content'];
        $this->assign('detail',$detail);
        $this->display();
    }
    public function shop(){
        $document = D("Document");
        $shops = $document->where(['category_id'=>41])->page(I('p',1),C('LIST_ROWS'))->select();
        foreach($shops as &$v){
            $v['create_time'] = date('Y-m-d H:i',$v['create_time']);
            $v['path'] = get_cover($v['cover_id'],"path");
            $v['url'] = U('detail',['id'=>$v['id']]);
        }

        if(IS_AJAX){//判断是否是ajax请求
            if(empty($shops)){
                $this->error('没有数据');
            }else{
                $this->success($shops);
            }
        }
        $this->assign('shops',$shops);
        $this->display();
    }
    public function activity(){
        $document = D("Document");
        $activitys = $document->where(['category_id'=>42])->page(I('p',1),C('LIST_ROWS'))->select();
        foreach($activitys as &$v){
            $v['create_time'] = date('Y-m-d H:i',$v['create_time']);
            $v['path'] = get_cover($v['cover_id'],"path");
            $v['url'] = U('detail',['id'=>$v['id']]);
        }

        if(IS_AJAX){//判断是否是ajax请求
            if(empty($activitys)){
                $this->error('没有数据');
            }else{
                $this->success($activitys);
            }
        }
        $this->assign('activitys',$activitys);
        $this->display();
    }

    public function joining(){
        if(!$this->login()){
            $id=I('id');
            $user = session('user_auth');
            $activity= D('Activity');
            $activity->aid=$id;
            $activity->uid=$user['uid'];
            $count=$activity->where(['aid'=>$id],'uid='.$user['uid'])->count();
            if($count){
                return '111';
            }
            if($activity->add()){
                $data=[
                    'success'=>'true',
                    'msg'=>'添加成功',
                ];
                $this->success($data);
            }
        }
    }
    public function my(){
        $this->display();
    }
    public function fuwu(){
        $this->display();
    }
    public function zushou(){
        $document = M('Document');
        $zus=$document->where('category_id=43')->select();
        foreach($zus as &$v){
            $v['create_time'] = date('Y-m-d H:i',$v['create_time']);
            $v['path'] = get_cover($v['cover_id'],"path");
            $v['url'] = U('detail',['id'=>$v['id']]);
        }
        $this->assign('zus',$zus);
        $this->display();
    }
}