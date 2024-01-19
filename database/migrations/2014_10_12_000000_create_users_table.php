<?php

use App\Enum\UserStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments("id");
            $table->string('first_name', 30);
            $table->string('last_name', 30);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->string('address')->nullable();
            $table->boolean('status')->default(UserStatusEnum::PENDING);
            $table->string('role')->default("user");
            // $table->enum('role', ["user", "admin"])->default("user");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};