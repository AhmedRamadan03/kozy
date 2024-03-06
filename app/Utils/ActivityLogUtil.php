<?php

namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ActivityLogUtil
{

    public static function actitvityLog($user, $action, $ip, $pc_name, $browser, $os, $device)
    {
        DB::table('user_logs')->insert([
            'user_id' => $user,
            'action' => $action,
            'ip' => $ip,
            'pc_name' => $pc_name,
            'browser' => $browser,
            'os' => $os,
            'device' => $device,
            'last_activity' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return true;
    }
}
