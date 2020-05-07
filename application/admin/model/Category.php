<?php

namespace app\admin\model;

use think\Model;
use think\Db;

class Category extends Model
{
    public function addCat($cat_name,$cat_desc){
        $data = ['cat_name' => $cat_name,'cat_desc'=>$cat_desc];
        if($this->save($data)){
            $res = ['status' => 'success', 'info' => '插入成功'];
        }else{
            $res = ['status' => 'fail', 'info' => '插入失败'];
        }
        return $res;
    }

    public function getAll(){
        return $this->select()->toArray();
    }
    public function getAllCount(){
        return $this->count();
    }

    public function getOne($id){
        return $this->find($id)->toArray();
    }

    public function updateCat($id,$data){
        if($this->where('id',$id)->update($data)){
            $res = ['status'=>'success','info' => '更新成功'];
        }else{
            $res = ['status'=>'fail','info' => '更新失败'];
        }
        return $res;
    }
    
    public function deleteCat($id){
        $data = Db::name('article')->where('cat_id',$id)->find();
        if($data){
            $res = ['status'=>'fail','info' => '分类下面还有文章'];
            return $res;
        }
        if($this->where('id',$id)->delete($id)){
            $res = ['status'=>'success','info' => '删除成功'];
        }else{
            $res = ['status'=>'success','info' => '删除成功'];
        }
        return $res;
    }
}