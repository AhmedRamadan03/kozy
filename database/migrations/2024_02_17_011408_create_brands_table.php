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


        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->string('slug')->unique()->index();
            $table->string('image')->nullable();
            $table->boolean('hide')->default(0);
            $table->timestamps();
        });

        // Brand Translations
        Schema::create('brand_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->index()->constrained()->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->unique(['brand_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brands');
        Schema::dropIfExists('brand_translations');
    }
};
