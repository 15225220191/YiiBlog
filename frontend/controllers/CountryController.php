<?php
namespace frontend\controllers;
use yii\web\Controller;
use frontend\models\Country;
use yii\data\Pagination;

class CountryController  extends Controller{
    
    public function actionIndex() {
        
        $query = Country::find();
        
        
        $pagination = new Pagination([
            'defaultPageSize' => 2, // 每页几条数据
            'totalCount' => $query->count(), // 总页数
        ]);
        
        
        
        // 查询所有城市
        //$countrys = $query->all();
        // tp5 
        // Db::name("country") -> where("population", ">", "1000000000") -> select();
        // $countrys = $query->where([">", "population" , "100000000"])->all();
        
        $countrys = $query->offset($pagination->offset)->limit($pagination->limit)->all();
       
        // 如果使用sql查询,有可能会被攻击 -- sql 注入
        $countrus = Country::findBySql("select * from country")->all();
        
        // 1.查询大量数据 -- 查询所有商品的基本信息
        // 注意:直接查询会导致内存不够用
        // 解决办法:
        // 1) 过滤掉不必要的字段 select id from ****
        // 2) 返回的数据为标准数组,而不是对象
        $countrus = $query->asArray()->all();
        // 3) 分段查询  分页
        foreach ($query->batch(10) as $country) {
            
        }

        return $this->render("index" , [
            "countrys" => $countrys,
            'pagination' => $pagination,
            ]);
    }
    
    
}
