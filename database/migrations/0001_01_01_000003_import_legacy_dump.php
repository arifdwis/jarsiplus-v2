<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Import legacy database from jarsiplus.gz dump.
 *
 * This migration loads the entire CREATE TABLE + INSERT statements from the
 * legacy dump in one shot. We strip the `users`, `personal_access_tokens`,
 * and `migrations` tables so they're only created here (no conflict with
 * Laravel internal migrations or our v2-only migrations that may add columns).
 *
 * Tables dropped before re-create:
 * - users
 * - all *_2024 archive tables (kept for historical reference)
 *
 * After this runs, follow-up migrations may ALTER tables (e.g. add v2 cols).
 */
return new class extends Migration
{
    public function up(): void
    {
        $dumpPath = dirname(__DIR__, 2) . '/jarsiplus.gz';

        if (! file_exists($dumpPath)) {
            // Try legacy path resolution from project root
            $alt = dirname(__DIR__, 3) . '/jarsiplus.gz';
            if (file_exists($alt)) {
                $dumpPath = $alt;
            } else {
                throw new \RuntimeException("Legacy dump not found at {$dumpPath} or {$alt}");
            }
        }

        $sql = gzfile($dumpPath);
        if ($sql === false) {
            throw new \RuntimeException("Cannot decompress dump at {$dumpPath}");
        }
        $sql = implode('', $sql);

        // Disable FK checks during import (multi-table circular FKs in dump)
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Drop tables we'll re-create from dump (avoids conflicts with Laravel internals)
        $tablesToDrop = [
            'users', 'personal_access_tokens', 'migrations',
        ];
        foreach ($tablesToDrop as $t) {
            Schema::dropIfExists($t);
        }

        // Split dump into individual statements at `;\n`
        $statements = preg_split('/;\s*\n/', $sql);

        foreach ($statements as $stmt) {
            $stmt = trim($stmt);
            if ($stmt === '' || str_starts_with($stmt, '--') || str_starts_with($stmt, '/*')) {
                continue;
            }

            // Skip mysqldump session-config statements
            if (preg_match('/^(SET|LOCK|UNLOCK|START|COMMIT|ROLLBACK)\s/i', $stmt)) {
                continue;
            }

            // Skip migrations table re-import (we re-create our own)
            if (preg_match('/INSERT INTO `migrations`/i', $stmt)) {
                continue;
            }

            try {
                DB::unprepared($stmt . ';');
            } catch (\Throwable $e) {
                // Re-throw with context
                throw new \RuntimeException(
                    "Failed importing dump statement: " . substr($stmt, 0, 200) . "...\nError: " . $e->getMessage(),
                    0,
                    $e
                );
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

    public function down(): void
    {
        $tables = [
            'permohonan_aprrove', 'permohonan_clone', 'permohonan_2024',
            'permohonan_penilaian', 'permohonan_histori_pembahasan_validasi',
            'permohonan_histori_pembahasan', 'permohonan_histori',
            'permohonan_monev', 'permohonan_file', 'permohonan',
            'pemohon_corporate', 'pemohon',
            'urusan', 'urusan_kategori',
            'master_parameter', 'master_indikator',
            'master_districts', 'master_cities', 'master_provinces', 'master_countries',
            'role_menu', 'role_users', 'role_permissions', 'user_permissions',
            'menu', 'permissions', 'roles',
            'slider', 'user_activities',
            'password_resets', 'personal_access_tokens', 'users',
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach ($tables as $t) {
            Schema::dropIfExists($t);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
};
