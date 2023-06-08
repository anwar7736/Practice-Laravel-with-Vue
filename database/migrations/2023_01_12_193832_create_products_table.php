<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('sku')->nullable();
            $table->decimal('price',8, 2);
            $table->string('discount_type')->nullable();
            $table->decimal('discount',8, 2)->nullable()->default(0);
            $table->decimal('discount_amount',8, 2)->nullable()->default(0);
            $table->decimal('price_after_discount',8, 2)->nullable()->default(0);
            $table->text('desc')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
