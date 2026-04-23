<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('sms_messages');
    }

    public function down(): void
    {
        if (Schema::hasTable('sms_messages')) {
            return;
        }

        Schema::create('sms_messages', function (Blueprint $table) {
            $table->id();
            $table->string('recipient_phone');
            $table->text('message');
            $table->string('context_type')->nullable();
            $table->unsignedBigInteger('context_id')->nullable();
            $table->string('status')->default('simulated');
            $table->string('provider_reference')->nullable();
            $table->json('meta')->nullable();
            $table->unsignedBigInteger('sent_by_user_id')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['context_type', 'context_id']);
            $table->index(['status', 'sent_at']);
        });

        if (Schema::hasTable('users')) {
            Schema::table('sms_messages', function (Blueprint $table) {
                $table->foreign('sent_by_user_id')->references('id')->on('users')->nullOnDelete();
            });
        }
    }
};
