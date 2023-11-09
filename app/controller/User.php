<?php
namespace app\controller;

use app\BaseController;
use think\Request;
use app\model\User as UserModel;
use Firebase\JWT\JWT;

class User extends BaseController
{
    function result($code, $msg, $data)
    {
        return json([
            "code" => $code,
            "msg" => $msg,
            "data" => $data
        ]);
    }

    function register(Request $request)
    {

        $username = $request->post("username");
        $password = password_hash($request->post("password"), PASSWORD_DEFAULT);

        $user = UserModel::where('username', $username)->find();

        if ($user) {
            return $this->result(400, "注册失败，用户已存在", null);
        }

        $u = new UserModel;

        $u->username = $username;
        $u->password = $password;

        $res = $u->save();

        if ($res) {
            return $this->result(200, "注册成功", null);
        }
        return $this->result(400, "注册失败", null);
    }

    function login(Request $request)
    {
        $username = $request->post("username");
        $password = $request->post("password");

        $user = UserModel::where('username', $username)->find();

        if (!$user) {
            return $this->result(400, "登录失败,用户不存在", null);
        }

        $password_hash = UserModel::where('username', $username)->field('password')->find();

        if (password_verify($password, $password_hash)) {
            $secretKey = '123456789'; // 用于签名令牌的密钥，请更改为安全的密钥

            $payload = array(
                // "iss" => "http://127.0.0.1:8000",  // JWT的签发者
                // "aud" => "http://127.0.0.1:9528/",  // JWT的接收者可以省略
                "iat" => time(),
                // token 的创建时间
                "nbf" => time(),
                // token 的生效时间
                "exp" => time() + 3600 * 10,
                // token 的过期时间
                "data" => [
                    // 包含的用户信息等数据
                    "username" => $username,
                ]
            );
            // 使用密钥进行签名
            $token = JWT::encode($payload, $secretKey, 'HS256');

            return $this->result(200, '登录成功', $token);
        }
        return $this->result(400, '登录失败，用户名或密码错误', null);
    }

    function getAll()
    {
        $user = UserModel::select();
        return $this->result(200, "获取用户成功", $user);
    }

    function getById($id)
    {
        $user = UserModel::where($id)->find();
        return $this->result(200, "获取用户成功", $user);
    }

    function resetPwd(Request $request)
    {
        $suername = $request->post("username");
        $old_password = $request->post("old_password");
        $new_password = $request->post("new_password");

        $u = UserModel::where('username', $suername)->find();

        if (!password_verify($old_password, $u->password)) {
            return $this->result(400, "旧密码错误", null);
        }

        $u->password = password_hash($new_password, PASSWORD_DEFAULT);

        $res = $u->save();

        if ($res) {
            return $this->result(200, "修改成功", null);
        }
        return $this->result(400, "修改密码失败", null);
    }

    function setBalance(Request $request){
        $username = $request->post("username");
        $balance = $request->post("balance");

        $u = UserModel::where("username",$username)->find();

        $res = $u->save(['balance'=>$balance]);

        if($res){
            return $this->result(200,"充值成功",null);
        }
        return $this->result(400,"充值失败",null);
    }

    function freeze(Request $request){
        $username = $request->post("username");
        $status = $request->post("status");

        $u = UserModel::where("username",$username)->find();

        $res = $u->save(['status'=>$status]);

        if($res){
            return $this->result(200,"冻结成功",null);
        }
        return $this->result(400,"冻结失败",null);        
    }

    function getPaginateData(Request $request){
        $page = $request->param('page',1);
        $pageSize = $request->param('page_size',10);

        $list = UserModel::field('id,username,balance,status,avatar')->paginate([
            'page'=>$page,
            'list_rows'=>$pageSize
        ]);

        return $this->result(200,"获取数据成功",$list);
    }
}
