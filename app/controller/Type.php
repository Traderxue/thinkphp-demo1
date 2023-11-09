<?php
namespace app\controller;

use app\BaseController;
use THink\Request;
use app\model\Type as TypeModel;

class Type extends BaseController
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
        $list = TypeModel::select();
        return $this->result(200, "获取列表成功", $list);
    }

    function addList(Request $request)
    {
        $t = new TypeModel;
        $t->type = $request->post("type");
        $res = $t->save();
        if ($res) {
            return $this->result(200, "添加成功", null);
        }
        return $this->result(400, "添加失败", null);
    }

    function deleteById($id)
    {
        $res = TypeModel::where('id', $id)->delete();
        if ($res) {
            return $this->result(200, "删除列表成功", null);
        }
        return $this->result(400, "删除列表失败", null);
    }

    function getPaginateData(Request $request)
    {
        $page = $request->param('page', 1);
        $pageSize = $request->param('page_size', 10);

        $list = TypeModel::paginate(['page'=>$page,'list_rows'=>$pageSize]);

        return $this->result(200, "获取数据成功", $list);
    }
}