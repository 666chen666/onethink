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
        $notices = D('Document')->select();
        foreach($notices as $k=>$cov){
            $res=D('Picture')->where(['id'=>$cov['cover_id']])->select();
            $notices[$k]['path']=$res[0]['path'];
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
}