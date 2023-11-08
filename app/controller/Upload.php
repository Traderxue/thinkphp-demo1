<?php
namespace app\controller;

class Upload
{
    function upload()
    {
        $file = request()->file("file");

        if ($file) {
            $info = $file->move('uploads/');
            if ($info) {
                // 文件上传成功
                return json(['code' => 1, 'message' => '文件上传成功']);
            } else {
                // 文件上传失败
                return json(['code' => 0, 'message' => $file->getError()]);
            }
        } else {
            return json(['code' => 0, 'message' => '未找到上传文件']);
        }
    }
}
