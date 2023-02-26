<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create(config('country.state_table_name'), function (Blueprint $table) {
            $table->id()->index();
            $table->string('name');
            $table->unsignedBigInteger('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop(config('country.state_table_name'));
    }
};