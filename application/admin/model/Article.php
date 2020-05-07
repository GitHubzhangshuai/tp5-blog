<?php

namespace app\admin\model;

use think\Model;

class Article extends Model
{
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created_at';
    protected $updateTime = 'updated_at';
    public function addArt($data){
        if($this->save($data)){
            $res = ['status' => 'success', 'info' => '插入成功'];
        }else{
            $res = ['status' => 'fail','info' => '插入失败'];
        }
        return $res;
    }

    public function getAllArticles($list,$data=null){
        if($data){
            if(isset($data['cat_id'])&&$data['cat_id']){
                $query['cat_id'] = $data['cat_id'];
            }
            if(isset($data['title'])&&$data['title']){
                $query['title'] = ['like','%'.$data['title'].'%'];
            }
            if(isset($data['startTime'])&&isset($data['endTime'])&&$data['startTime'] && $data['endTime']){
                $query['created_at'] = ['between time',[$data['startTime'],$data['endTime']]];
            }
            if(isset($data['startTime'])&&isset($data['endTime'])&&$data['startTime'] && !$data['endTime']){
                $query['created_at'] = ['> time',$data['startTime']];
            }
            if(isset($data['startTime'])&&isset($data['endTime'])&&!$data['startTime'] && $data['endTime']){
                $query['created_at'] = ['< time',$data['endTime']];
            }
            $data = $this->alias('a')->where($query)->field('a.id,a.title,a.views,a.created_at,c.cat_name')->join('category c','a.cat_id=c.id')->order('created_at desc')->paginate($list);
        }
        else{
            $data = $this->alias('a')->field('a.id,a.title,a.views,a.created_at,c.cat_name')->join('category c','a.cat_id=c.id')->order('created_at desc')->paginate($list);
        }
        return $data;
    }
    public function getCount($data=null){
        if($data){
            if(isset($data['cat_id'])&&$data['cat_id']){
                $query['cat_id'] = $data['cat_id'];
            }
            if(isset($data['title'])&&$data['title']){
                $query['title'] = ['like','%'.$data['title'].'%'];
            }
            if(isset($data['startTime'])&&isset($data['endTime'])&&$data['startTime'] && $data['endTime']){
                $query['created_at'] = ['between time',[$data['startTime'],$data['endTime']]];
            }
            if(isset($data['startTime'])&&isset($data['endTime'])&&$data['startTime'] && !$data['endTime']){
                $query['created_at'] = ['> time',$data['startTime']];
            }
            if(isset($data['startTime'])&&isset($data['endTime'])&&!$data['startTime'] && $data['endTime']){
                $query['created_at'] = ['< time',$data['endTime']];
            }
            return $this->where($query)->count();
        }else{
            return $this->count();
        }
    }

    public function getOneArticle($id){
        $data = $this->field(['views,created_at,updated_at'],true)->find($id)->toArray();
        return $data;
    }

    public function updateArt($data,$id){
        if($this->where('id',$id)->update($data)){
            $res = ['status' => 'success', 'info' => '更新成功'];
        }else{
            $res = ['status' => 'fail', 'info' => '更新失败']; 
        }
        return $res;
    }
    public function deleteArt($id){
        if($this->where('id',$id)->delete()){
            $res = ['status' => 'success', 'info' => '删除成功'];
        }else{
            $res = ['status' => 'fail', 'info' => '删除失败']; 
        }
        return $res;
    }

    
}
