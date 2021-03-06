<?php

namespace app\admin\controller;

use think\Db;

class Nav extends Common
{
    //模型table
    private static $_model = 'model';
    //栏目table
    private static $_category = 'category';


    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        //获取已定义模型
        $model = Db::name(self::$_model)->field('id,name')->select();
        //已添加栏目
        $category = Db::name(self::$_category)->field('id,name')->where('pid', 0)->select();

        $this->assign('model', $model);
        $this->assign('category', $category);
    }

    //导航页
    function index()
    {
        return $this->fetch();
    }

    //添加导航UI
    function add()
    {
        if (request()->isGet()) {
            return $this->fetch();
        } elseif (request()->isPost()) {
            $param = input('post.');
            $data = [
                'name' => $param['name'],
                'ename' => $param['ename'],
                'modelid' => $param['model'],
                'pid' => $param['parent_id'],
                'keywords' => $param['keywords'],
                'description' => $param['description'],
                'position' => $param['position'],
                'sort' => $param['sort'],
                'status' => $param['status']
            ];
            //新增导航
            if(!input('?post.id')){
                $flag = Db::name(self::$_category)->insert($data);
                if ($flag) {
                    $this->success('添加栏目成功', 'nav/add');
                }else{
                    $this->error('添加栏目失败', 'nav/add');
                }
            }else{
                $id = $param['id'];
                unset($param['id']);
                $flag = Db::name(self::$_category)->where('id',$id)->update($data);
                if ($flag) {
                    $this->success('修改栏目成功');
                }else{
                    $this->error('修改栏目失败');
                }
            }

        }

    }

    /*
     * 编辑导航
     */
    public function edit($id){
        $data = Db::name(self::$_category)->where('id',$id)->find();
        $this->assign('data',$data);
        return $this->fetch();
    }

    /*
     * 删除导航
     */
    public function dele($id){
        $flag = Db::name(self::$_category)->where('id',$id)->delete();
        if ($flag) {
            $this->success('删除栏目成功');
        }else{
            $this->error('删除栏目失败');
        }
    }
}
