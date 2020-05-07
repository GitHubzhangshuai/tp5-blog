<?php
namespace app\home\controller;
use think\Controller;
use app\home\model\Article;
use app\home\controller\BaseController;

class IndexController extends BaseController
{
    public function index(){
        $article = new Article;
        $arts = $article->getAllArticles(3);
        $pics = $article->getAllPic();
		$this->assign('pics',$pics);
        $this->assign('arts',$arts);
        $this->assign('cat_id','all');
        return $this->fetch('');
    }
    public function list($cat_id){
        
    }
    public function detail($id){

    }
}