<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Handlers\ImageUploadHandler;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', [
            // 我们通过 except 方法来设定 指定动作 不使用 Auth 中间件进行过滤，意为 —— 除了此处指定的动作以外，所有其他动作都必须登录用户才能访问，类似于黑名单的过滤机制。相反的还有 only 白名单方法，将只过滤指定动作
            'except' => ['show']
        ]);
    }


    /**
     * 显示用户个人信息页面
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }


    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {

        $this->authorize('update', $user);

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
