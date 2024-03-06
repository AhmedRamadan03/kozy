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
        Schema::create('to_dos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('admins')->cascadeOnDelete("set null");
            $table->foreignId('created_by')->constrained('admins')->cascadeOnDelete();
            $table->string('subject');
            $table->text('task');
            $table->date('end_date');
            $table->enum('status',['pending','process','hold','complet'])->default('pending');

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
        Schema::dropIfExists('to_dos');
    }
};
