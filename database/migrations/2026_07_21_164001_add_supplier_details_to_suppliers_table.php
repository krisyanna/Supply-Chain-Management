<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->string('contact_person')->nullable()->after('name');
            $table->string('email')->nullable()->after('contact_person');
            $table->string('phone_number')->nullable()->after('email');
            $table->enum('status', ['Active', 'Pending'])
                  ->default('Pending')
                  ->after('phone_number');
        });
    }

    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn([
                'contact_person',
                'email',
                'phone_number',
                'status',
            ]);
        });
    }
};