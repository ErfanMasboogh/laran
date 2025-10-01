<?php

namespace ErfanMasboogh\Laran\Models;

use Illuminate\Support\Facades\Auth;
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
        'isUsed' => 'boolean',
        'isPublic' => 'boolean',
        'created' => 'integer',
        'updated' => 'integer',
    ];

    /**
     * Store the received file after changes in temporary file's directory with unique name
     *
     * @param $file
     * @return Storage
     */
    public static function upload($file)
    {
        $fileType = $file->getClientMimeType();
        $fileType = explode('/', $fileType)[0];

        $fileExtension = $file->getClientOriginalExtension();
        $fileSize = $file->getSize();

        $fileName = $file->getClientOriginalPath();
        $fileName = preg_replace('/[^\p{L}\p{N}\s-]/u', '', strip_tags($fileName));
        $fileName = mb_substr(rtrim($fileName, $fileExtension), 0, 127);

        $userID = Auth::id() ?? 0;

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
}
