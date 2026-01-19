<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class TenantDatabaseCreator
{
    public static function createTenantDatabase($dbName, $username, $password) {        
        if (! self::databaseExists($dbName)) {
            DB::statement("CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            // 3. Run migrations on the new tenant DB
            self::runMigrationsOnTenant($dbName, $username, $password);
        }
    }

    private static function runMigrationsOnTenant($dbName, $username, $password) {
        config([
            'database.connections.tenant.database' => $dbName,
        ]);

        DB::purge('tenant');
        DB::reconnect('tenant');

        // Run migrations from /database/migrations/tenant/
        Artisan::call('migrate', [
            '--path' => 'database/tenant',
            '--database' => 'tenant',
        ]);
    }

    public static function databaseExists($dbName) {
        $result = DB::select("SELECT SCHEMA_NAME 
                              FROM INFORMATION_SCHEMA.SCHEMATA 
                              WHERE SCHEMA_NAME = ?", [$dbName]);

        return !empty($result);
    }
}


?>