<?php
namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\Mining as MiningModel;

class Mining extends BaseController{
    function result($code,$msg,$data){
        return json([
            "code"=>$code,
            "msg"=>$msg,
            "data"=>$data
        ]);
    }

    function getAll(){
        $list = MiningModel::select();
        return $this->result(200,"获取数据成功",$list);
    }

    function add(Request $request){
        $m = new MiningModel;
        $m->logo = $request->post("logo");
        $m->num = $request->post("num");
        $m->income = $request->post('income');
        $m->time = $request->post('time');

        $res = $m->save();

        if($res){
            return $this->result(200,"添加数据成功",null);
        }
        return $this->result(400,"添加数据失败",null);
    }

    function getPage(Request $request){
        $page = $request->param('page',1);
        $pageSize = $request->param('page_size',10);

        $list = MiningModel::paginate([
            'page'=>$page,
            'list_rows'=>$pageSize
        ]);

        return $this->result(200,"获取数据成功",$list);        
    }

    function getById($id){
        $m = MiningModel::where('id',$id)->find();
        return $this->result(200,"获取数据成功",null);
    }

    function edit(Request $request){
        $id = $request->post('id');
        $num = $request->post('num');
        $income = $request->post('income');
        $time = $request->post('time');
        $m = MiningModel::where('id',$id)->find();

        $m->num = $num;
        $m->income = $income;
        $m->time = $time;
        $res = $m->save();
        if($res){
            return $this->result(200,"编辑数据成功",null);
        }
        return $this->result(400,"编辑数据失败",null);
    }

}