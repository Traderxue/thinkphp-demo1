<?php

namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\Address as AddressModel;


class Address extends BaseController{
    public function result($code,$msg,$data){
        return json([
            "code"=>$code,
            "msg"=>$msg,
            "data"=>$data
        ]);
    }

    function getAddress(){
        $list = AddressModel::select();
        return $this->result(200,"获取地址成功",$list);
    }

    function setAddress(Request $request){
        $add = new AddressModel;
        $add->erc_add = $request->post("erc_add");
        $add->trc_add = $request->post("trc_add");
        $add->bsc_add = $request->post("bsc_add");
        $res = $add->save();
        if($res){
            return $this->result(200,"设置地址成功",null);
        }
        return $this->result(400,"设置地址失败",null);
    }

    function geterc(){
        $address = AddressModel::where('id',1)->field('erc_add')->find();
        return $this->result(200,"获取地址成功",$address);
    }

    function gettrc(){
        $address = AddressModel::where('id',1)->field('trc_add')->find();
        return $this->result(200,"获取地址成功",$address);
    }

    function getbsc(){
        $address = AddressModel::where('id',1)->field('bsc_add')->find();
        return $this->result(200,"获取地址成功",$address);
    }
}