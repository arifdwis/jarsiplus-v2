<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add v2-only SSO fields to legacy users table.
 *
 * The legacy dump's users table already has: uid, photo, phone, address,
 * gender, date_birth, level, jenis, unit_id, etc. SSO Samarinda response
 * additionally provides `number_id` and `type_id` which we want to persist.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'number_id')) {
                $table->string('number_id', 191)->nullable()->after('level');
            }
            if (! Schema::hasColumn('users', 'type_id')) {
                $table->string('type_id', 191)->nullable()->after('number_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['number_id', 'type_id']);
        });
    }
};
