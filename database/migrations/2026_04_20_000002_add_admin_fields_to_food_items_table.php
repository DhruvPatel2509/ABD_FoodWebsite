<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('food_items', function (Blueprint $table) {
            if (!Schema::hasColumn('food_items', 'image')) {
                $table->string('image')->nullable()->after('price');
            }

            if (!Schema::hasColumn('food_items', 'availability')) {
                if (Schema::hasColumn('food_items', 'image')) {
                    $table->string('availability')->default('available')->after('image');
                } else {
                    $table->string('availability')->default('available');
                }
            }

            if (!Schema::hasColumn('food_items', 'discount_percent')) {
                if (Schema::hasColumn('food_items', 'availability')) {
                    $table->unsignedInteger('discount_percent')->default(0)->after('availability');
                } else {
                    $table->unsignedInteger('discount_percent')->default(0);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('food_items', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('food_items', 'availability')) {
                $columns[] = 'availability';
            }

            if (Schema::hasColumn('food_items', 'discount_percent')) {
                $columns[] = 'discount_percent';
            }

            if (Schema::hasColumn('food_items', 'image')) {
                $columns[] = 'image';
            }

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
