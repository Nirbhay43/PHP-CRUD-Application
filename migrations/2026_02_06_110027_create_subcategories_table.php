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
    Schema::create('subcategories', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('cat_id');
        $table->string('subcatname');
        $table->timestamps();

        $table->foreign('cat_id')
              ->references('id')
              ->on('categories')
              ->onDelete('cascade');
    });
}
};
