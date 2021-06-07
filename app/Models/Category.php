<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    //因为数据库表结构未生成时间戳，使用$timestamps = false; 进行设置，告知laravel此模型在创建和更新时不需要维护 created_at 和 update_at 两个字段
    public $timestamps = false;

    //允许被修改的字段
    protected $fillable = [
        'name',
        'description'
    ];
}
