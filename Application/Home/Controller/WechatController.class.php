<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/2 0002
 * Time: 上午 9:32
 */

namespace Home\Controller;


use EasyWeChat\Foundation\Application;

class WechatController extends HomeController
{
    public function index(){
        include './vendor/autoload.php';
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
                        "url"  => U('home/index/index','','',true)
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
        if($member == null){
            $this->redirect(['wechat/bang']);
        }
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
    }

    public function bang(){
        var_dump(session('openid'));
    }
}