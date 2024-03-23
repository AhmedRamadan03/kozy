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
        // ['pending', 'received', 'preparation', 'shipping', 'reached', 'canceled', 'refund', 'paid']
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->index()->constrained()->onDelete('set null');
            $table->foreignId('country_id')->nullable()->index()->constrained()->onDelete('set null');
            $table->string('name');
            $table->longText('address');
            $table->decimal('total', 15);
            $table->decimal('sub_total', 15);
            $table->decimal('tax', 15);
            $table->decimal('shipping', 15);
            $table->decimal('discount', 15)->nullable();
            $table->decimal('after_discount', 15)->nullable();
            $table->string('coupon')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('status')->default('pending');
            $table->string('ref');
            $table->boolean('show')->default(0);
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
        Schema::dropIfExists('orders');
    }
};
