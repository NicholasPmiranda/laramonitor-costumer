<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('laramonitor_http_client_entries', function (Blueprint $table) {
            $table->id();
            $table->string('method');
            $table->string('url');
            $table->string('status_code')->nullable();
            $table->json('payload');
            $table->json('response')->nullable();
            $table->json('headers');
            $table->string('origin');
            $table->string('environment');
            $table->dateTime('sending_at');
            $table->boolean('connection_failed')->default(false);
            $table->integer('processed')->default(0);
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
        Schema::dropIfExists('laramonitor_http_client_entries');
    }
};
