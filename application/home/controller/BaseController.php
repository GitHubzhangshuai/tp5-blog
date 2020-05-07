<?php

namespace app\home\controller;

use think\Controller;
use app\home\model\Article;
use think\View;
use think\Request;

class BaseController extends Controller
{
    //
    public function _initialize(){
        $article = new Article;
        $cats = $article->getAllCats();
        View::share('cats',$cats);
        $hots = $article->getHotTag(3);
        View::share('hots',$hots);
        $last = $article->getLastArt(10);
        View::share('last',$last);
        $hotArts = $article->getHotArts(10);
        View::share('hotArts',$hotArts);
        $domain = Request::instance()->domain();
        View::share('domain',$domain);
        $links = $article->getAllLink();
        View::share('links',$links);
        $sys = $article->getSys();
        View::share('sys',$sys);
        $mostComments = $article->getCommentArt();
        View::share('mostComments',$mostComments);
    }
}
