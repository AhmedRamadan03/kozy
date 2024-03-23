<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_log';

    protected $fillable = [
        'log_name',
        'description',
        'subject_id',
        'subject_type',
        'causer_id',
        'causer_type',
        'properties',
        'created_at',
        'updated_at',

    ];

    public function causer()
    {
        return $this->belongsTo(Admin::class, 'causer_id');
    }

    public function subject()
    {
        $class = $this->subject_type;
        return $class ? $class::find($this->subject_id) : null;
    }

}
