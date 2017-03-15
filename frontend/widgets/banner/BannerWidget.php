<?php
namespace frontend\widgets\banner;
use yii\base\Widget;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BannerWidget
 *
 * @author Administrator
 */
class BannerWidget extends Widget {
    public $items = [];
    public function init() {
        //初始化数据
        if(count($this->items) == 0){
            $this->items =[
                [
                    'active' => "active",
                    'image_url' => "/statics/images/banner/0.jpg",
                    "html" => "http://www.baidu.com",
                    "image_name" => "图片1",
                    "image_title" => "欢迎光临",
                ],
                [
                    'active' => "",
                    'image_url' => "/statics/images/banner/1.jpg",
                    "html" => "http://www.baidu.com",
                    "image_name" => "图片2",
                    "image_title" => "欢迎光临",
                ],
                [
                    'active' => "",
                    'image_url' => "/statics/images/banner/2.jpg",
                    "html" => "http://www.baidu.com",
                    "image_name" => "图片3",
                    "image_title" => "欢迎光临",
                ],
                [
                    'active' => "",
                    'image_url' => "/statics/images/banner/3.jpg",
                    "html" => "http://www.baidu.com",
                    "image_name" => "图片4",
                    "image_title" => "欢迎光临",
                ],
            ];
        };
        
    }
    public function run() {
        
        return $this->render('index',['items'=>$this->items]);
    }
}
