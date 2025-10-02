<?php

namespace ErfanMasboogh\Laran\Http\Controllers\Web;

use ErfanMasboogh\Laran\Models\Storage;
use \Illuminate\Contracts\View\View;
use \Illuminate\Support\Facades\Storage as BaseStorage;

class StorageController extends Controller
{
    /**
     * Temporary download process until user auth get completed (for file permissions)
     */
    public function download($sid)
    {
        $storage = Storage::query()
            ->where('SID', $sid)
            ->firstOrFail();

        $filePathAfterStorage = lcfirst(class_basename($storage->storable_type)) . '/' . $storage->additionalPath . $storage->SID ;
        $filePath = config('laran.storage.path') . $filePathAfterStorage ;

        if (!BaseStorage::disk('public')->exists($filePath)) {
            return abort(404);
        }

        return BaseStorage::disk('public')->response($filePath, $storage->fileName . $storage->fileExtension);
    }
}
