<?php
namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\Card as CardModel;

class Card extends BaseController
{
    function result($code, $msg, $data)
    {
        return json([
            "code" => $code,
            "msg" => $msg,
            "data" => $data
        ]);
    }

    function getAll()
    {
        $cards = CardModel::select();
        return $this->result(200, "获取数据成功", $cards);
    }

    function getById($id)
    {
        $card = CardModel::where('id', $id)->find();
        return $this->result(200, "获取数据成功", $card);
    }

    function add(Request $request)
    {
        $card = new CardModel;
        $card->name = $request->post('name');
        $card->phone = $request->post('phone');
        $card->yhk = $request->post('yhk');
        $card->user_id = $request->post('user_id');

        $res = $card->save();

        if ($res) {
            return $this->result(200, "添加数据成功", null);
        }
        return $this->result(400, "添加数据失败", null);
    }

    function deleteById($id)
    {
        $res = CardModel::where('id', $id)->delete();
        if ($res) {
            return $this->result(200, "删除数据成功", null);
        }
        return $this->result(400, "删除数据失败", null);
    }

    function getPaginateData(Request $request){
        $page = $request->param("page",1);
        $pageSize = $request->param("page_size",10);

        $list = CardModel::paginate([
            'page'=>$page,
            'list_rows'=>$pageSize
        ]);

        return $this->result(200,"获取数据成功",$list);
    }
}