<?php
 namespace app\controller;
 
 use app\BaseController;
 use think\Request;
 use app\model\Assets as AssetsModel;

 class Assets extends BaseController{
    function result($code,$msg,$data){
        return json([
            "code"=>$code,
            "msg"=>$msg,
            "data"=>$data
        ]);
    }

    function getByUserId($id){
       $res = AssetsModel::where('u_id',$id)->find();
       if($res){
        return $this->result(200,"获取数据成功",$res);
       }
       return $this->result(400,"获取数据失败",null);
    }

    function getAll(){
        $list = AssetsModel::select();
        return $this->result(200,"获取数据成功",$list);
    }

    function add(Request $request){
        $assets = new AssetsModel;
        $assets->type = $request->post("type");
        $assets->btc_balance = $request->post("btc_balance");
        $assets->eth_balance = $request->post("eth_balance");
        $assets->usdt_balance = $request->post("usdt_balance");
        $assets->u_id = $request->post("u_id");

        $res = $assets->save();

        if($res){
            return $this->result(200,"添加数据成功",null);
        }
        return $this->result(400,"添加数据失败",null);
    }

    function getPage(Request $request){
        $page = $request->param("page",1);
        $pageSize = $request->param("page_size",10);

        $list = AssetsModel::paginate([
            'page'=>$page,
            'list_rows'=>$pageSize
        ]);

        return $this->result(200,"获取数据成功",$list);
    }

    function deleteById($id){
        $res = AssetsModel::where('id',$id)->delete();
        if($res){
            return $this->result(200,"删除成功",null);
        }
        return $this->result(400,"删除成功",null);
    }

 }