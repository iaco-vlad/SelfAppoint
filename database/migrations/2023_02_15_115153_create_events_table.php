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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->integer('administrator_id');
            $table->integer('user_id')->nullable();
            $table->integer('service_id')->nullable();
            $table->datetime('date');
            $table->smallInteger('time');
            $table->enum(
                'status',
                ['pending', 'canceled', 'confirmed', 'declined', 'honored', 'unhonored']
            );
            $table->text('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
