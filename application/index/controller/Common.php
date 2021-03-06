<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;
use think\Config;

class Common extends Controller
{
    /*
     * 数据表前缀
     */
    protected $prefix = '';

    /*
     * 网站主题
     */
    protected $theme = 'default';


    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->prefix = Config::get('database.prefix');
        $this->theme = get_system_value('site_theme');
        //查询文章分类
        $cate = Db::name('category')->where(['modelid' => 1, 'status' => 1])->select();
        $this->assign('rcate', $cate);
    }

    /*
     * 空操作
     */
    public function _empty()
    {
        abort(404,'页面不存在');
    }
}
