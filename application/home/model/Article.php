<?php
namespace app\home\model;

use think\Db;
use think\Model;

class Article extends Model
{
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
            $data = $this->alias('a')->where($query)->field('a.id,a.title,a.views,a.created_at,c.cat_name,a.summary,a.img_url,a.contents,a.tag,a.comments')->join('category c','a.cat_id=c.id')->order('a.created_at desc')->paginate($list);
        }
        else{
            $data = $this->alias('a')->field('a.id,a.title,a.views,a.created_at,c.cat_name,a.summary,a.img_url,a.contents,a.tag,a.comments')->join('category c','a.cat_id=c.id')->order('a.created_at desc')->paginate($list);
        }
        return $data;
    }

    public function getById($id){
        return $this->alias('a')->field('a.id,a.title,a.views,a.created_at,c.cat_name,a.summary,a.img_url,a.contents,a.tag,a.author,a.comments')->join('category c','a.cat_id=c.id')->find($id);
    }

    public function getAllCats(){
        return Db::name('category')->field(['id,cat_name'])->select();
    }

    public function getCatName($cat_id){
        return Db::name('category')->where('id',$cat_id)->value('cat_name');
    }

    public function addViews($id){
        return $this->where('id',$id)->setInc('views');
    }

    public function getLastArt($num=3){
        return $this->order('created_at desc')->limit($num)->select();
    }

    public function getHotTag($num=3){
        return $this->field(['count(*)' => 'num','tag' => 'tag'])->group('tag')->order('num desc')->limit($num)->select();
    }

    public function getHotArts($num=3){
        return $this->field(['views' => 'num','title' => 'title','id' => 'id'])->order('views desc')->limit($num)->select();
    }

    public function getRandArts($id){
        $cat_id = $this->where('id',$id)->value('cat_id');
        return $this->where('cat_id',$cat_id)->field(['id','title','img_url'])->order('rand()')->limit(4)->select()->toArray();
    }

    public function getPrevAndNext($id){
        $cat_id = $this->where('id',$id)->value('cat_id');
        $prev = $this->where('cat_id',$cat_id)->where('id','<',$id)->field(['id,title'])->order('id desc')->limit(1)->select()->toArray();
        $next = $this->where('cat_id',$cat_id)->where('id','>',$id)->field(['id,title'])->order('id')->limit(1)->select()->toArray();
        if($prev){
            $res['prev'] = $prev[0];
        }
        if($next){
            $res['next'] = $next[0];
        }
        return $res;
    }

    	//获取幻灯片的信息
	public function getAllPic(){
		return Db::name('pic')->where('is_show',1)->field(['id','is_show'],true)->select()->toArray();
	}
	//获取友情链接
	public function getAllLink(){
		return Db::name('link')->order('order_by')->select();
	}
	//获取网站配置
	public function getSys(){
		return Db::name('sys')->find();
	}
	//评论加1
	public function addComments($id){
		$this->where('id',$id)->setInc('comments');	
	}
	//获取最多评论的文章
	public function getCommentArt(){
		return $this->field(['id','title','img_url'])->order('comments desc')->limit(4)->select()->toArray();
	}
}