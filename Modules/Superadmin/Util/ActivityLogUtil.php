<?php

namespace App\Util;
namespace Modules\Superadmin\Util;

use Illuminate\Support\Facades\DB;

class ActivityLogUtil
{

    /**
     * Logs an activity to the activity log table.
     *
     * @param string $name The name of the log.
     * @param string $description The description of the log.
     * @param object|null $subject The subject of the log.
     * @param array $properties The properties of the log.
     *
     * @return bool Returns true if the log was successfully inserted into the database.
     */
    public static function logs($name, $description, $subject = null, $properties = [])
    {
        DB::table('activity_log')->insert([
            'log_name' => $name,
            'description' => __('lang.this_model_has_been', ['event' => __('lang.' . $name), 'model' => __('lang.' . $description), 'causer' => auth('admin')->user()->username]),
            // 'subject_type' => get_class($subject) ?? null,
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject->id ?? null,
            'causer_type' => get_class(auth('admin')->user()) ?? null,
            'causer_id' => auth('admin')->user()->id,
            'properties' => json_encode($properties),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return true;
    }

    public static function log($action, $description, $model, $properties = [])
    {
        DB::table('activity_log')->insert([
            'log_name' => $action,
            'description' => $description,
            'subject_type' => $model ? get_class($model) : null,
            'subject_id' => $model->id ?? null,
            'causer_type' => get_class(auth('admin')->user()) ?? null,
            'causer_id' => auth('admin')->user()->id,
            'properties' => json_encode($properties),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return true;
    }
}
