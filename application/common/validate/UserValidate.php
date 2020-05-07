<?php
namespace app\common\validate;
use think\Validate;

class userValidate extends Validate{
    protected $rule = [
        'captcha|验证码' => 'require|length:4|captcha|token'
    ];
}