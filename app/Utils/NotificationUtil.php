<?php

namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NotificationUtil
{

    public static function sendNotification($user, $model, $message)
    {
        DB::table('model_notifications')->insert([
            'user_id' => $user,
            'model_id' => $model->id,
            'model_type' =>get_class($model),
            'message' => $message,
            'is_read' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        return true;
    }
}
