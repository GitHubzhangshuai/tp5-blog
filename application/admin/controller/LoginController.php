<?php
namespace app\admin\controller;
use think\Controller;
use think\Config;
use think\Request;
use think\Session;
use think\captcha\Captcha;
use app\admin\model\Admin;

class LoginController extends Controller
{
    public function index(Request $request){
        if($request->isPost()){
            $validate = validate('userValidate');
            $check = $request->only(['captcha','__token__']);
            if(!$validate->check($check)){
                return $this->error($validate->getError(),'/admin/login');
            }
            $username = $request->param('username','trim');
            $password = $request->param('password','trim');
            $admin = new Admin;
            $res = $admin->checkLogin($username,$password);
            if($res['status'] == 'fail'){
                return $this->error($res['info'],'/admin/login','','10');
            }else{
                Session::set('username',$username);
                return $this->success($res['info'],'/admin/index');
            }
        }else{
            if(Session::get('username')){
                return $this->redirect('/admin/index');
            }else{
                return view();
            }
        }
    }
    public function captcha(){
        $config = Config::get('captcha');
        $captcha = new Captcha($config);
        return $captcha->entry();
    }

    public function logout(){
        Session::delete('username');
        return $this->redirect('/admin/login');
    }
}