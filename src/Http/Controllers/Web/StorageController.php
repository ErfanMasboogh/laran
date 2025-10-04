<?php

namespace ErfanMasboogh\Laran\Http\Controllers\Web;

use ErfanMasboogh\Laran\Models\Storage;
use \Illuminate\Contracts\View\View;
use \Illuminate\Support\Facades\Storage as BaseStorage;

class StorageController extends Controller
{
    /**
     * @param $sid
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function download($sid)
    {
        $isAdmin = (boolean) auth()->guard('manager')->user();

        $storage = Storage::query()
            ->where('SID', $sid)
            ->first();

        if (!$storage) {
            return $this->error('Record not found.');
        }

        if (!$storage->isUsed) {
            return $this->error('File not used.');
        }

        $filePathAfterStorage = lcfirst(class_basename($storage->storable_type)) . '/' . $storage->additionalPath . $storage->SID ;
        $filePath = config('laran.storage.path') . $filePathAfterStorage ;

        if (!BaseStorage::disk('public')->exists($filePath)) {
            return $this->error('File not found.');
        }

        if (!$isAdmin && !$storage->isPublic) {
            $model = new $storage->storable_type;

            if (!$model->haveAccessToMedia()) {
                return $this->error('Access denied.');
            }
        }

        return BaseStorage::disk('public')->response($filePath, $storage->fileName . $storage->fileExtension);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\Response
     */
    protected function error($message)
    {
        return response()->view('laran::errors.404', ['message' => $message], 404);
    }
}
