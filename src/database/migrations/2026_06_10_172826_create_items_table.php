<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->unsignedInteger('price');
            $table->string('image_path');
            $table->string('brand')->nullable();
            $table->foreignId('condition_id')->constrained()->cascadeOnDelete();
            $table->timestamp('sold_at')->nullable();
            $table->timestamps();
        });
    }

    public function favoritedUsers()
    {
        return $this->belongsToMany(Item::class, 'favorites');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
