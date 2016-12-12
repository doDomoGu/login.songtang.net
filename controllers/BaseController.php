<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    public $user;
    //public $layout = 'main';
    public function beforeAction($action){
        if (!parent::beforeAction($action)) {
            return false;
        }

        $s = file_get_contents('http://staff.localsongtang.net/site/get-user?uid=1');
        $s = json_decode($s);
        var_dump($s);exit;

        if(!Yii::$app->user->isGuest){

//            Yii::$app->user->logout();
            return $this->goHome();
        }


        if(!$this->checkLogin()){
            return false;
        }


        return true;
    }

    //检测是否登陆
    public function checkLogin(){
        //除“首页”和“登陆页面”以外的页面，需要进行登陆判断
        if(!in_array($this->route,[
                'site/index',
                'site/login',
                'site/error'
            ])){
            if(Yii::$app->user->isGuest){
                $this->redirect(Yii::$app->urlManager->createUrl(Yii::$app->user->loginUrl));
                return false;
            }
        }

        return true;
    }



}