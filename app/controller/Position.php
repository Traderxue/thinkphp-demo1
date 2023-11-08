<?php
namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\Position as PositionModel;

class Position extends BaseController
{
    function result($code, $msg, $data)
    {
        return json([
            "code" => $code,
            "msg" => $msg,
            "data" => $data
        ]);
    }

    function getList()
    {
        $list = PositionModel::select();
        return $this->result(200, "获取仓位成功", $list);
    }

    function insertPosition(Request $request)
    {
        $p = new PositionModel;
        $p->type = $request->post('type');
        $p->time = date("Y-m-d H:i:s");
        $p->open_price = $request->post('open_price');
        $p->close_price = $request->post('close_price');
        $p->profit = $request->post('profit');
        $p->up = $request->post('up');

        $res = $p->save();

        if ($res) {
            return $this->result(200, "仓位添加成功", null);
        }
        return $this->result(400, "仓位添加失败", null);
    }

    function deleteById($id){
        $res = PositionModel::where('id',$id)->delete();
        if($res){
            return $this->result(200,"删除成功",null);
        }
        return $this->result(400,"删除失败",null);
    }
}
