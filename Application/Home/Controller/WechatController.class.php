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
    public function actionUser(){
            $app = new Application(C('wechat'));
            $response = $app->oauth->redirect();
            //将当前路由保存到session，便于授权回调地址跳回当前页面
            \Yii::$app->session->setFlash('back','wechat/user');
            $response->send();
        var_dump(\Yii::$app->session->get('openid'));
    }
}