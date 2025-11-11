<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('electricity_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('note_id')->constrained('electricity_notes')->onDelete('cascade');
            $table->string('appliance_name');
            $table->integer('quantity');
            $table->integer('duration_hours');
            $table->integer('duration_minutes');
            $table->integer('wattage');
            $table->decimal('cost', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('electricity_items');
    }
};