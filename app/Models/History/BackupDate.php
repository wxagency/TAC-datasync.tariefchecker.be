<?php

namespace App\Models\History;

use Illuminate\Database\Eloquent\Model;

class BackupDate extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'backup_dates';
    
    protected $fillable = ['backupdate', 'status', 'counter', 'last_restored'];
}
