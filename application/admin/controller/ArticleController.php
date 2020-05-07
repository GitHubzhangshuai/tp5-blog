<?php

namespace app\admin\controller;

use app\admin\controller\BaseController;
use think\Request;
use app\admin\model\Category;
use app\admin\model\Article;

class ArticleController extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $article = new Article;
        $arts = $article->getAllArticles(10,$request->param());
        $this->assign('arts',$arts);
        $category = new Category;
        $cats = $category->getAll();
        $this->assign('cats',$cats);
        $counts = $article->getCount($request->param());
        $this->assign('counts',$counts);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        $category = new Category;
        $cats = $category->getAll();
        $this->assign('cats',$cats);
        $catsCount = $category->getAllCount();
        if($catsCount==0){
            return $this->error('请先添加分类再添加文章','/admin/category');
        }
        return $this->fetch('add');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $data = $request->except(['file']);
        $article = new Article;
        $res = $article->addArt($data);
        if($res['status']=='fail'){
            return $this->error($res['info'],'/admin/article');
        }else{
            return $this->success($res['info'],'/admin/article');
        }
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
        $category = new Category;
        $cats = $category->getAll();
        $this->assign('cats',$cats);
        $article = new Article;
        $art = $article->getOneArticle($id);
        $this->assign('art',$art);
        return $this->fetch('edit');
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->except(['_method','file']);
        $article = new Article;
        $res = $article->updateArt($data,$id);
        if($res['status'] == 'fail'){
            return $this->error($res['info'],'/admin/article');
        }else{
            return $this->success($res['info'],'/admin/article');
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
        $article = new Article;
        $res = $article->deleteArt($id);
        return $res;
    }
}
