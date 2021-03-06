<?php

namespace app\admin\controller;

use app\admin\controller\BaseController;
use think\Request;
use app\admin\model\Category;

class CategoryController extends BaseController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $category = new Category;
        $cats = $category->getAll();
        $catsCount = $category->getAllCount();
        $this->assign('cats',$cats);
        $this->assign('catsCount',$catsCount);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
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
        $validate = validate('CatValidate');
        if(!$validate->check($request->param())){
            return $this->error($validate->getError(),'/admin/category');
        }
        $cat_name = $request->param('cat_name','trim');
        $cat_desc = $request->param('cat_desc','trim');
        $category = new Category;
        $res = $category->addCat($cat_name,$cat_desc);
        if($res['status']=='fail'){
            return $this->error($res['info'],'/admin/category');
        }else{
            return $this->success($res['info'],'/admin/category');
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
        $category = new Category;
        $cat = $category->getOne($id);
        $this->assign('cat',$cat);
        $cats = $category->getAll();
        $catsCount = $category->getAllCount();
        $this->assign('cats',$cats);
        $this->assign('catsCount',$catsCount);
        return $this->fetch('index');
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
        $validate = validate('CatValidate');
        if(!$validate->check($request->only(['cat_name','cat_desc','__token__']))){
            $this->error($validate->getError(),'/admin/category');
        }else{
            $category = new Category;
            $data = $request->only(['cat_name','cat_desc']);
            $res = $category->updateCat($id,$data);
            if($res['status']=='fail'){
                $this->error($res['info'],'/admin/category');
            }else{
                $this->success($res['info'],'/admin/category');
            }
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
        $category = new Category;
        $res = $category->deleteCat($id);
        return json($res);
    }
}
