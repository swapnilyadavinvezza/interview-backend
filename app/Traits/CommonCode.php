<?php namespace App\Traits;

use Log;
use Auth;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ModuleExport;

trait CommonCode
{
    public function modelName($model) {
        $className = 'App\\Models\\' . Str::studly(Str::singular($model));
        if(class_exists($className)) {
            return new $className;
        } else {
            abort(404);
        }
    }   
    public function exportModule($model = null,$query,$heading) {
        return Excel::download(
            new ModuleExport($model,$query,$heading),
            'moduel.xlsx'
        );
    }
}
?>