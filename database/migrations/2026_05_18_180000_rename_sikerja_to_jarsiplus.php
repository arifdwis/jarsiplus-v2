<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Rename legacy 'sikerja' uri/slug to 'jarsiplus' across menu and permissions.
 * Idempotent — safe to run on any DB state.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Menu URIs: sikerja → jarsiplus, sikerja/foo → jarsiplus/foo
        DB::table('menu')
            ->where('uri', 'sikerja')
            ->update(['uri' => 'jarsiplus']);

        DB::table('menu')
            ->where('uri', 'like', 'sikerja/%')
            ->get()
            ->each(function ($m) {
                DB::table('menu')->where('id', $m->id)->update([
                    'uri' => preg_replace('/^sikerja/', 'jarsiplus', $m->uri),
                ]);
            });

        // Permissions slug + http_path
        DB::table('permissions')
            ->where('slug', 'sikerja')
            ->update(['slug' => 'jarsiplus']);

        DB::table('permissions')
            ->where('http_path', '/sikerja')
            ->update(['http_path' => '/jarsiplus']);

        DB::table('permissions')
            ->where('http_path', 'like', '/sikerja/%')
            ->get()
            ->each(function ($p) {
                DB::table('permissions')->where('id', $p->id)->update([
                    'http_path' => preg_replace('/^\/sikerja/', '/jarsiplus', $p->http_path),
                ]);
            });
    }

    public function down(): void
    {
        DB::table('menu')->where('uri', 'jarsiplus')->update(['uri' => 'sikerja']);
        DB::table('menu')
            ->where('uri', 'like', 'jarsiplus/%')
            ->get()
            ->each(function ($m) {
                DB::table('menu')->where('id', $m->id)->update([
                    'uri' => preg_replace('/^jarsiplus/', 'sikerja', $m->uri),
                ]);
            });

        DB::table('permissions')->where('slug', 'jarsiplus')->update(['slug' => 'sikerja']);
        DB::table('permissions')->where('http_path', '/jarsiplus')->update(['http_path' => '/sikerja']);
        DB::table('permissions')
            ->where('http_path', 'like', '/jarsiplus/%')
            ->get()
            ->each(function ($p) {
                DB::table('permissions')->where('id', $p->id)->update([
                    'http_path' => preg_replace('/^\/jarsiplus/', '/sikerja', $p->http_path),
                ]);
            });
    }
};
