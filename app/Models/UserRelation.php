<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRelation extends Model
{
    use HasFactory;

    protected $table = 'user_relations';  // モデルが使用するテーブル名

    protected $fillable = [
        'user_id',
        'target_user_id',
        'is_blocking'
    ];
}
