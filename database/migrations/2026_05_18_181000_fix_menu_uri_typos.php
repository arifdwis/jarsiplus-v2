<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Fix legacy menu URI bugs:
 * - 'home' should be 'dashboard' (matches our /dashboard route)
 * - '/support' has leading double slash from dump
 */
return new class extends Migration
{
    public function up(): void
    {
        DB::table('menu')->where('uri', 'home')->update(['uri' => 'dashboard']);
        DB::table('menu')->where('uri', '/support')->update(['uri' => 'support']);
    }

    public function down(): void
    {
        DB::table('menu')->where('uri', 'dashboard')->update(['uri' => 'home']);
        DB::table('menu')->where('uri', 'support')->update(['uri' => '/support']);
    }
};
