<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{
    /**
     * 显示用户个人信息页面
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {

        // dd($request->avatar);

        //获取提交的所有数据
        $data = $request->all();

        //如果上传了头像
        if ($request->avatar) {
            //获得图片的路径
            $result = $uploader->save($request->avatar, 'avatar', $user->id, 416);
            //如果返回图片路径正确
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }

        //更新用户资料
        $user->update($data);

        //重定向跳转
        return redirect()->route('users.show', $user->id)->with('success', '个人资料更新成功');
    }
}
