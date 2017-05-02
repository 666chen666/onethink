<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/2 0002
 * Time: 上午 9:32
 */

namespace Home\Controller;

include './vendor/autoload.php';
use EasyWeChat\Foundation\Application;

class WechatController extends HomeController
{
    public function index(){
        $app = new Application(C('wechat'));
        $response = $app->server->serve();
        // 将响应输出
        $response->send();
    }
    public function getmenus(){
        $app = new Application(C('wechat'));
        $menu = $app->menu;
        $menus = $menu->all();
        var_dump($menus);
    }


    public function setmenus()
    {
        $app = new Application(C('wechat'));
        $menu = $app->menu;
        $buttons = [
            [
                "type" => "click",
                "name" => "热销商品",
                "key"  => "V1001_HOT"
            ],
            [
                "name"       => "个人中心",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "物业管理",
                        "url"  => U('Home/index/index','','',true)
                    ],
                    [
                        "type" => "view",
                        "name" => "绑定账号",
                        "url"  => U('Home/wechat/bang','','',true)
                    ],
                ],
            ],
        ];
        $r = $menu->add($buttons);
        var_dump($r);
    }

    //用户帐号信息
    public function user(){
        //如果session里面没有openid 就获取openid
        if(empty(session('openid'))){
            $app = new Application(C('wechat'));
            $response = $app->oauth->scopes(['snsapi_base'])
                ->redirect();
            $response->send();
        }
        //从session中获取openid
        $openid = session('openid');
        //根据openid查询数据库中是否有数据
        $member = M('member')->find($openid);
        //没有数据 跳转到绑定页面
        if(!$member){
            $this->redirect(['home/user/login']);
        }
       // $this->redirect('user/login');
        //有数据 获取数据
        $this->assign('member',$member);
        $this->display('user');
    }

    //授权回调
    public function callback(){
        $app = new Application(C('wechat'));
        $user = $app->oauth->user();
        //将用户的openid保存到session
        session('openid',$user->id);
        $this->redirect('Home/wechat/bang');
    }

    public function bang(){
        //判断session中是否有openid
        if(empty(session('openid'))){
            $app = new Application(C('wechat'));
            //发起授权
            $response = $app->oauth->scopes(['snsapi_userinfo'])
                ->redirect();
            $response->send();
            //设置回调地址,便于授权回调地址跳回当前页面
        }
        //var_dump(session('openid'));
        $openid = session('openid');
        //var_dump($openid);
        $member = D('Member')->where(['openid'=>$openid])->select();
        //var_dump($member);exit;
//        var_dump(D('Member')->getLastSql());exit;
        //判断是否绑定过
        if($member){
            $model = D('member');
            $model->login($member->uid);
            $this->redirect('Home/Index/index');
        }
        $this->redirect('Home/User/login');

    }
}