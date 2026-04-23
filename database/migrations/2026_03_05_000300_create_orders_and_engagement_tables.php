<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_number')->unique();
                $table->unsignedBigInteger('customer_user_id');
                $table->string('status', 20)->default('pending');
                $table->string('payment_method', 30)->default('cash');
                $table->decimal('subtotal', 14, 2)->default(0);
                $table->decimal('discount', 14, 2)->default(0);
                $table->decimal('total', 14, 2)->default(0);
                $table->text('notes')->nullable();
                $table->unsignedBigInteger('processed_by_user_id')->nullable();
                $table->timestamp('placed_at')->useCurrent();
                $table->timestamp('processed_at')->nullable();
                $table->timestamps();

                $table->index(['customer_user_id', 'status']);
                $table->index(['status', 'placed_at']);
            });

            if (Schema::hasTable('users')) {
                Schema::table('orders', function (Blueprint $table) {
                    $table->foreign('customer_user_id')->references('id')->on('users')->cascadeOnDelete();
                    $table->foreign('processed_by_user_id')->references('id')->on('users')->nullOnDelete();
                });
            }
        }

        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('product_id');
                $table->integer('quantity');
                $table->decimal('unit_price', 12, 2);
                $table->decimal('line_total', 14, 2);
                $table->timestamps();

                $table->index(['order_id', 'product_id']);
            });

            Schema::table('order_items', function (Blueprint $table) {
                if (Schema::hasTable('orders')) {
                    $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
                }
                if (Schema::hasTable('products')) {
                    $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
                }
            });
        }

        if (!Schema::hasTable('favorite_products')) {
            Schema::create('favorite_products', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('product_id');
                $table->timestamps();

                $table->unique(['user_id', 'product_id']);
            });

            Schema::table('favorite_products', function (Blueprint $table) {
                if (Schema::hasTable('users')) {
                    $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
                }
                if (Schema::hasTable('products')) {
                    $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
                }
            });
        }

        if (!Schema::hasTable('product_reviews')) {
            Schema::create('product_reviews', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('product_id');
                $table->unsignedTinyInteger('rating');
                $table->text('review')->nullable();
                $table->boolean('is_approved')->default(true);
                $table->timestamps();

                $table->unique(['user_id', 'product_id']);
                $table->index(['product_id', 'rating']);
            });

            Schema::table('product_reviews', function (Blueprint $table) {
                if (Schema::hasTable('users')) {
                    $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
                }
                if (Schema::hasTable('products')) {
                    $table->foreign('product_id')->references('id')->on('products')->cascadeOnDelete();
                }
            });
        }

        if (!Schema::hasTable('promotions')) {
            Schema::create('promotions', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('discount_type', 20)->default('percent');
                $table->decimal('discount_value', 12, 2)->default(0);
                $table->string('code')->nullable()->unique();
                $table->timestamp('starts_at')->nullable();
                $table->timestamp('ends_at')->nullable();
                $table->boolean('is_active')->default(true);
                $table->unsignedBigInteger('created_by_user_id')->nullable();
                $table->timestamps();

                $table->index(['is_active', 'starts_at', 'ends_at']);
            });

            if (Schema::hasTable('users')) {
                Schema::table('promotions', function (Blueprint $table) {
                    $table->foreign('created_by_user_id')->references('id')->on('users')->nullOnDelete();
                });
            }
        }

        if (!Schema::hasTable('user_notifications')) {
            Schema::create('user_notifications', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->string('type', 100);
                $table->string('title');
                $table->text('message');
                $table->json('data')->nullable();
                $table->boolean('is_read')->default(false);
                $table->timestamp('read_at')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'is_read']);
                $table->index(['user_id', 'created_at']);
            });

            if (Schema::hasTable('users')) {
                Schema::table('user_notifications', function (Blueprint $table) {
                    $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
                });
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user_notifications');
        Schema::dropIfExists('promotions');
        Schema::dropIfExists('product_reviews');
        Schema::dropIfExists('favorite_products');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};

