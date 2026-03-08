<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->date('birthday')->nullable()->after('name');
            $table->string('birthplace_city')->nullable()->after('birthday');
            $table->string('birthplace_country')->nullable()->after('birthplace_city');
            $table->text('bio')->nullable()->after('birthplace_country');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'birthday',
                'birthplace_city',
                'birthplace_country',
                'bio',
            ]);
        });
    }
};
