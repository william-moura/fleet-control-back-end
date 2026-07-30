<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertsSetting extends Model
{
    protected $table = 'alert_settings';
    protected $fillable = ['alert_type', 'days_before'];
}
