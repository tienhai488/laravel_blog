<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table
            ->integer('user_id')
            ->after('slug')
            ->unsigned();
            $table
            ->foreign('user_id')
            ->references('id')
            ->on('users');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign('posts_user_id_foreign');
            $table->dropIndex('posts_user_id_foreign');
            $table->dropColumn('user_id');
        });
    }
};