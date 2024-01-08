<?php

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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text("message");
            $table->string("file")->nullable();
            $table->unsignedBigInteger('sender_id');
            $table->foreign("sender_id")->references("id")->on("users");
            $table->unsignedBigInteger('reciever_id');
            $table->foreign("reciever_id")->references("id")->on("users");
            $table->unsignedBigInteger('room_id');
            $table->foreign("room_id")->references("id")->on("chat_rooms");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};