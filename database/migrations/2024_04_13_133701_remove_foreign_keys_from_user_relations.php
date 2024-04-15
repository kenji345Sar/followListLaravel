<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_relations', function (Blueprint $table) {
            // 外部キー制約を削除
            $table->dropForeign(['user_id']);
            $table->dropForeign(['target_user_id']);
        });
    }

    public function down()
    {
        Schema::table('user_relations', function (Blueprint $table) {
            // 外部キー制約を再設定
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('target_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
