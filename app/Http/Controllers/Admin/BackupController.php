<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\History\BackupDate;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process as Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class BackupController extends Controller
{
    public function backup()
    {
        $backupdate = BackupDate::get();
        $activeRestore = BackupDate::where('status', 1)->first();
        return view('admin.backup.backup', compact('backupdate', 'activeRestore'));
    }

    public function fullBackup()
    {
        Artisan::call('backup:start');
        return back();
    }

    public function restoreAll(Request $request)
    {
        $activeRestore = BackupDate::find($request->get('id'));

        if ($activeRestore->status == 0) {
            $activeRestore->status = 1;
            $activeRestore->counter = 1;
            $activeRestore->save();
        }

        // $activeRestore->counter = 1;
        // $activeRestore->save();

        $updateStatus = BackupDate::where('id', '!=', $activeRestore->id)->update([
            'status' => 0,
        ]);


        Artisan::call('restore:all');
        // $process = new Process('php ../artisan restore:all');
        // $process->start();


        return ['status' => true];
    }

    function getProgress()
    {
        $activeRestore = BackupDate::where('status', 1)->first();
        $progress = 100;
        if ($activeRestore) {
            $progress = (int) ($activeRestore->counter * 100) / 19;
        }
        return ['progress'=> intVal($progress),'id'=> @$activeRestore->id];
    }
}
