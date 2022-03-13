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
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamps();

            // Client ID: 1
            // Client secret: eJ8lLIl8LyLMDyMoelKWbj0Q4x6uVJQA2DhaMwAU
            // Password grant client created successfully.
            // Client ID: 2
            // Client secret: EOUsaCb6XtLOkgCbkKgDTyfqiS7un2Jm8DXhsWFh
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};
