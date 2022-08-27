<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->string('activity', 100)->nullable()->default(NULL);;
            $table->string('type', 100)->nullable()->default(NULL);;
            $table->integer('participants');
            $table->float('price');
            $table->string('link', 100)->nullable()->default(NULL);;
            $table->string('key', 100)->nullable()->default(NULL);;
            $table->integer('accessibility');
            $table->timestamp('create_date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
};
