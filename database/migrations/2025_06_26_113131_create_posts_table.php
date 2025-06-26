<?php

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class CreatePostsTable extends Migration
// {
//     public function up(): void
//     {
//         Schema::create('posts', function (Blueprint $table) {
//             $table->id();
//             $table->foreignId('user_id')
//                   ->constrained()
//                   ->cascadeOnDelete();
//             $table->string('title');
//             $table->text('text');
//             $table->timestamps();
//         });
//     }

//     public function down(): void
//     {
//         Schema::dropIfExists('posts');
//     }


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            // user_id с внешним ключом на users.id
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('title');
            $table->text('text');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
    
}
