<?php

namespace ErfanMasboogh\Laran\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage as BaseStorage;

class Storage extends Model
{
    public $primaryKey = 'SID';
    public $keyType = 'string';
    public $incrementing = false;
    public $table = 'storage';

    protected $fillable = [
        'SID',
        'userID',
        'storable_type',
        'storable_id',
        'fileType',
        'fileName',
        'fileExtension',
        'fileSize',
        'additionalPath',
        'isUsed',
        'isPublic',
    ];

    protected $casts = [
        'SID' => 'string',
        'userID' => 'integer',
        'storable_type' => 'string',
        'storable_id' => 'integer',
        'fileType' => 'string',
        'fileName' => 'string',
        'fileExtension' => 'string',
        'fileSize' => 'integer',
        'additionalPath' => 'string',
        'isUsed' => 'boolean',
        'isPublic' => 'boolean',
        'created' => 'integer',
        'updated' => 'integer',
    ];

    /**
     * Call clearCache method after each save and deletion
     * @return void
     */
    public static function booted()
    {
        static::saved(function () {
            self::clearCache();
        });
        static::deleted(function () {
            self::clearCache();
        });
    }

    /**
     * Flush the method's cache tag
     * @return bool
     */
    public static function clearCache()
    {
        return Cache::tags(self::cacheTag())->flush();
    }

    /**
     * @param $tag
     * @return string
     */
    public static function cacheTag($tag = ''): string
    {
        return 'storage' . $tag;
    }

    /**
     * Store the received file after changes in temporary file's directory with unique name
     *
     * @param $file
     * @return Storage
     */
    public static function upload($file, $additionalPath = null)
    {
        $fileType = $file->getClientMimeType();
        $fileType = explode('/', $fileType)[0];

        $fileExtension = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();

        $fileName = $file->getClientOriginalPath();
        $fileName = preg_replace('/[^\p{L}\p{N}\s-]/u', '', strip_tags($fileName));
        $fileName = mb_substr(rtrim($fileName, $fileExtension), 0, 127);

        $userID = Auth::id() ?? 0;

        $additionalPath = $additionalPath ? (trim($additionalPath, '/') . '/') : null;

        $SID = uuid_create();
        static::prepareForStore($SID);


        BaseStorage::disk('public')->put(config('laran.storage.tempPath') . $SID, $file->getContent());

        $storage = static::create([
            'SID' => $SID,
            'userID' => $userID,
            'fileType' => $fileType,
            'fileName' => $fileName,
            'fileExtension' => $fileExtension,
            'fileSize' => $fileSize,
            'additionalPath' => $additionalPath,
        ]);

        return $storage;
    }

    /**
     * Ensure the temporary directory existance and SID uniqueness
     *
     * @param $SID
     * @return void
     */
    private static function prepareForStore(&$SID)
    {
        $tempPath = base_path() . '/storage/app/public/' . config('laran.storage.tempPath');
        if (!is_dir($tempPath)) {
            mkdir($tempPath, 0755, true);
        }

        while (true) {
            $storage = Storage::query()
                ->where('SID', $SID)
                ->exists();
            if (!$storage) {
                break;
            }
            $SID = uuid_create();
        }
    }

    /**
     * Delete the file and record of received SID
     * @param $SID
     * @return void
     */
    public static function deleteBySID($SID)
    {
        $storage = self::findBySID($SID);

        if ($storage) {
            $filePath = config('laran.storage.path') . lcfirst(class_basename($storage->storable_type)) . '/'
                . $storage->additionalPath . $storage->SID;

            BaseStorage::disk('public')->delete($filePath);

            $storage->delete();
        }
    }

    /**
     * Cache and returns the storage record of received SID
     * @param $SID
     * @return mixed
     */
    public static function findBySID($SID)
    {
        $cacheKey = self::cacheKey('_' . $SID);

        $storage = Cache::tags(self::cacheTag())->remember($cacheKey, now()->addMinutes(10), function () use ($SID) {
            return self::query()
                ->where('SID', $SID)
                ->first();
        });

        return $storage;
    }

    public static function cacheKey($key = ''): string
    {
        return 'storage' . $key;
    }

    /**
     * Fill remained fields and move the file to it's directory
     * @param $model
     * @param $isPublic
     * @return void
     */
    public function useFor($model, $isPublic = true)
    {
        $storable_type = null;
        $storable_id = $model->ID;

        $namespaces = [
            "App\\Models\\",
            "ErfanMasboogh\\Laran\\Models\\",
        ];

        foreach ($namespaces as $namespace) {
            $class = $namespace . class_basename($model);
            if (class_exists($class)) {
                $storable_type = $class;
            }
        }

        $storePath = config('laran.storage.path') . lcfirst(class_basename($model)) . '/' . $this->additionalPath;

        if (!is_dir(storage_path() . '/app/public/' . $storePath)) {
            mkdir(storage_path() . '/app/public/' . $storePath, 0755, true);
        }

        BaseStorage::disk('public')->move(config('laran.storage.tempPath') . $this->SID, $storePath . $this->SID);

        $this->update([
            'storable_type' => $storable_type,
            'storable_id' => $storable_id,
            'isPublic' => $isPublic,
            'isUsed' => true,
        ]);
    }
}
