<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up():void

{
    Schema::create('contact_message', function (Blueprint $table){
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->string('phone')->nullable();
        $table->string('subject');
        $table->text('message');
        $table->enum('status',['new','read','replied','archived'])->default('new');
        $table->text('admin_notes')->nullable();
        $table->timestamp('read_at')->nullable();
        $table->timestamps();

        $table->index('status');
        $table->index('created_at');
});
}



public function down():void
{
Schema::dropIfExists('contact_messages');
}
};