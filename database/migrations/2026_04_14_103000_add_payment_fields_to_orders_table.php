<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->default('cod')->after('address');
            $table->string('payment_transaction_id')->nullable()->after('payment_method');
        });
    }

    public function down() { 
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'payment_transaction_id']);
        });
    }
};
