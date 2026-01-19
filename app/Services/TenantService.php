<?php 

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Company;

class TenantService
{
    public static function connect($dbName)
    {
        if (empty($dbName)) {
            return;
        }

        config([
            'database.connections.tenant.database' => $dbName,
        ]);

        DB::purge('tenant');       // Clear old connection
        DB::reconnect('tenant');   // Reconnect with new DB
    }
}


?>