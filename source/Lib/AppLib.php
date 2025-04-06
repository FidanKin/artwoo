<?php

namespace Source\Lib;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Typography\FontFactory;
use Source\Access\Enums\RoleEnum;
use Source\Entity\User\Models\User;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Exceptions\DecoderException;

class AppLib
{
    const TOKEN_TABLE = 'secrets';
    const USER_TOKEN_NAME = 'antpx4gt5cv';

    /* ================================================= */
    /* ==============     TOKENS    ==================== */
    /* ================================================= */

    public static function verify_api_key(string $key): bool
    {
        return config('app.api_key') === $key;
    }

    /**
     * Создаем токен
     */
    public static function generate_token($type = 400, $component = null, $record_id = null): false|string
    {
        $token = Str::random(42);
        if (DB::table(static::TOKEN_TABLE)->insert([
            'token' => $token,
            'component' => $component,
            'record_id' => $record_id,
        ])
        ) {
            return $token;
        }

        return false;
    }

    /**
     * Метод для удаления файла по API (запросом с фронта)
     */
    public static function deleteFileByApi(string $pathnamehash, string $token): bool
    {
        if (empty($token)) {
            return false;
        }

        if (! FileStorage::deleteByPathnamehash($pathnamehash)) {
            return false;
        }

        return true;
    }

    /* ================================================= */
    /* ==============     TIME    ==================== */
    /* ================================================= */

    /* ================================================= */
    /* ==============     ARRAY    ==================== */
    /* ================================================= */
    public static function isArrayFullNull($arr): bool
    {
        return $arr === array_filter($arr, 'is_null');
    }

    /* ================================================= */
    /* ==============     SESSIONS    ==================== */
    /* ================================================= */

    public static function isUserSelf(int $targetUserId): bool
    {
        $user = auth()->user();
        if (empty($user)) {
            return false;
        }

        if ($user->id === $targetUserId) {
            return true;
        }

        return false;
    }

    /* ================================================= */
    /* ============     SIMPLE PERMISSION    =========== */
    /* ================================================= */

    /**
     * Проверяем, может ли текущий пользовать выполнить действие редактирования
     *
     * @param  User  $targetUser - автра контента
     */
    public static function canEditBase(User $targetUser): bool
    {
        $currentUser = auth()->user();
        $adminID = RoleEnum::admin->value;
        if (empty($currentUser)) {
            return false;
        }
        if ($targetUser['role'] === $adminID) {
            return true;
        }
        if ($currentUser->id === $targetUser->id) {
            return true;
        }

        return false;
    }

    /**
     * Проверяем, является ли пользователь модератором
     *
     * @param User $user
     * @return bool
     */
    public static function isModerator(User $user): bool
    {
        $moderatorRoles = [RoleEnum::moderator->value, RoleEnum::admin->value];
        return in_array($user->role, $moderatorRoles);
    }

    /**
     * Проверяем, является ли пользователь администратором
     *
     * @param User $user
     * @return bool
     */
    public static function isAdmin(User $user): bool
    {
        if ($user->role === RoleEnum::admin->value) {
            return true;
        }

        if (in_array($user->id, config('app.artwoo.admins'))) {
            return true;
        }

        return false;
    }

    public static function generateApiToken(): string
    {
        return Str::random(64);
    }
}

/**
 * Добавляет текст к загруженному изображению. Текст Artwoo.ru
 * Добавляет справой нижней стороны
 *
 * @param \stdClass $fileSource - запись файла из БД
 * @param User $user - пользователь
 * @param bool $overwrite - если true, то текущий файл заменится на файл с ватермаркой, иначе - создасться с суффиксом _watermark
 * @return bool
 */
function artwooAddImageWatermark(\stdClass $fileSource, User $user, bool $overwrite = true): bool {
    if ($fileSource->watermarked) {
        return false;
    }

    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    if (! in_array($fileSource->mimetype, $allowedExtensions)) {
        return false;
    }

    $fs = new FileStorage();
    $fullImagePath = $fs->getFileRealPath($fileSource->pathnamehash);

    if (empty($fullImagePath)) {
        return false;
    }

    try {
        @ini_set('memory_limit', '512M');
        $ir = Image::read($fullImagePath);
        $width = $ir->width();
        $height = $ir->height();
        $posX = $width - 150;
        $posY = $height - 100;
        $ir->text('Artwoo.ru', $posX, $posY, function(FontFactory $font) {
            $font->filename(Storage::disk('assets')->path('OpenSansExtraBold.ttf'));
            $font->size(24);
            $font->color('ffffff3F');
            $font->angle(45);
        });
        $ir->text(sprintf('Author: %s', $user->login), 15, $height - 15, function(FontFactory $font) {
            $font->filename(Storage::disk('assets')->path('OpenSansExtraBold.ttf'));
            $font->size(24);
            $font->color('ffffff3F');
        });
        $ir->save($fullImagePath);

        // помечаем, что ватермарка добавлена
        FileRecord::setWatermarked($fileSource->contenthash);
    } catch (DecoderException $exception) {
        return false;
    }

    return true;
}
