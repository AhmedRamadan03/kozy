<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->string('slug')->unique()->index();
            $table->foreignId('brand_id')->index()->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->index()->constrained()->onDelete('cascade');
            $table->foreignId('country_id')->index()->constrained()->onDelete('cascade');
            $table->string('image');
            $table->string('sku')->nullable();
            $table->decimal('price', 10);
            $table->decimal('discount', 10)->default(0);
            $table->decimal('after_discount', 10);
            $table->unsignedInteger('quantity');
            $table->boolean('hide')->default(0);
            $table->softDeletes();
            $table->index(['brand_id', 'category_id', 'country_id']);
            $table->timestamps();
        });

        // Product Translations
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index()->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->mediumText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->mediumText('meta_keywords')->nullable();
            $table->mediumText('meta_description')->nullable();
            $table->unique(['product_id', 'locale']);
        });


         // Product Images
         Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index()->constrained()->onDelete('cascade');
            $table->string('image');
            $table->timestamps();
        });

        // colors
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value');
            $table->timestamps();
            $table->softDeletes();
        });


        //sizes
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('value');
            $table->timestamps();
            $table->softDeletes();
        });

        //product_variations
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index()->constrained()->onDelete('cascade');
            $table->foreignId('color_id')->index()->constrained()->onDelete('cascade');
            $table->foreignId('size_id')->index()->constrained()->onDelete('cascade');

            $table->float('quantity')->default(0);


            $table->timestamps();
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
        Schema::dropIfExists('product_translations');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('sizes');
        Schema::dropIfExists('product_variations');
    }
};
