<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use App\Http\Controllers\Controller;
use App\Http\Requests\DatabaseBackup\UpdateRequest;
use App\Models\DatabaseBackupSetting;
use Exception;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class DatabaseBackupSettingController extends Controller
{
    public $middleware = [];
    public $appSetting = null;
    public $reply = null;
    public $backupSetting = [];
    public $backups = [];
    public function __construct()
    {

    }

    public function index()
    {
        $disk = Storage::disk('storage');
        $files = $disk->files('/Laravel');
        $backups = [];
        foreach ($files as $file) {
            if (substr($file, -4) == '.zip' && $disk->exists($file)) {
                $backups[] = [
                    'file_path' => $file,
                    'file_name' =>  explode('/',$file)[1],
                    'file_size' => $disk->size($file),
                    'last_modified' => $disk->lastModified($file),
                ];
            }
        }
        $this->backupSetting = DatabaseBackupSetting::first();
        $this->backups = array_reverse($backups);
        return view('admin.setting.database-backup-settings.index', ['backups'=>$this->backups]);
    }

    public function create()
    {

    }

    public function store(UpdateRequest $request)
    {

    }

    public function createBackup($id)
    {
        try {
            if($id==1){
            //$backupResult = Artisan::call('backup:run --only-db');
            $projectDir= substr(getcwd(), 0, strpos(getcwd(), '\public'));
            $command = 'cd /d '.$projectDir .'&& php artisan backup:run --only-db';
            exec($command);
            return redirect()->back()->with(['success'=>'Database Backed Up successfully']);
            }
            elseif($id==2){
                //$backupResult = Artisan::call('backup:run');
                $projectDir= substr(getcwd(), 0, strpos(getcwd(), '\public'));
                $command = 'cd /d '.$projectDir .'&& php artisan backup:run ';
                exec($command);
                return redirect()->back()->with(['success'=>'Source And Database Backed Up successfully']);
            }
        } catch (Exception $e) {
            return redirect()->back()->with(['error'=>'Something Went Wrong!','backupResult'=>$e]);
        }

    }

    public function download($file_name)
    {
        try {
            $file =  "Laravel/".$file_name;
            if (Storage::disk('local')->exists($file)) {
                return Response::download(storage_path().'/'.'app/'.$file);
            }
            return redirect()->back()->with('error', 'Something Went Wrong!');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something Went Wrong!');
        }
    }

    public function delete($file_name)
    {
        try {
            $file =  "Laravel/".$file_name;
            if (Storage::disk('local')->exists($file)) {
                Storage::disk('local')->delete($file);
                return redirect()->back()->with('success', 'File deleted successfully');
            }
            else{
                return redirect()->back()->with('success', 'File deleted successfully');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something Went Wrongd!');
        }
    }

    public static function humanFileSize($size, $unit = '')
    {
        if ((!$unit && $size >= 1 << 30) || $unit == 'GB') {
            return number_format($size / (1 << 30), 2) . 'GB';
        }

        if ((!$unit && $size >= 1 << 20) || $unit == 'MB') {
            return number_format($size / (1 << 20), 2) . 'MB';
        }

        if ((!$unit && $size >= 1 << 10) || $unit == 'KB') {
            return number_format($size / (1 << 10), 2) . 'KB';
        }

        return number_format($size) . ' bytes';
    }

}
