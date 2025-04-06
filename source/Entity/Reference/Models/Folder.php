<?php

namespace Source\Entity\Reference\Models;

use Database\Factories\ReferenceFolderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Source\Entity\User\Models\User;
use Source\Lib\DTO\PaginatorModelDTO;
use Source\Lib\FileIdentityDTO;
use Source\Lib\FileStorage;
use function Source\Lib\Text\artwooShortText;
use Illuminate\Database\Eloquent\Factories\Factory;

class Folder extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;
    private const CACHE_KEY_ALL_REFS_COUNT_PREFIX = 'core:reference:all_refs_';

    private const CACHE_KEY_FOLDER_QUANTITY_REFS_PREFIX = 'core:reference:folder_refs_';

    protected $table = 'reference_folders';

    protected $fillable = ['name', 'description', 'user_id', 'time_visited', 'automatic_deletion'];

    public $timestamps = false;

    protected $casts = [
        'automatic_deletion' => 'boolean',
    ];

    protected static function newFactory(): Factory
    {
        return ReferenceFolderFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reference(): HasMany
    {
        return $this->hasMany(Reference::class);
    }

    private static function allQuantityReferenceCacheKey(int $userId): string
    {
        return static::CACHE_KEY_ALL_REFS_COUNT_PREFIX."$userId";
    }

    private function folderQuantityReferenceCacheKey(int $folderId): string
    {
        return static::CACHE_KEY_FOLDER_QUANTITY_REFS_PREFIX.$folderId;
    }

    public static function updateAllQuantityReferencesInCache(User $user): bool
    {
        $count = $user->through('folder')->has('reference')->get()->count();

        return Cache::put(static::allQuantityReferenceCacheKey($user->id), $count, 60 * 60 * 24);
    }

    /**
     * Обновить количество рефов в директории в кеше
     */
    public function updateFolderQuantityReferenceInCache(): bool
    {
        $this->refresh(); // на всякий случай обновим модель
        $count = $this->reference->count();

        return Cache::put($this->folderQuantityReferenceCacheKey($this->id), $count, 60 * 60 * 24);
    }

    /**
     * Получить общее количество рефов пользователя из кеша (ttl - 1 сутки)
     */
    public static function getAllQuantityReferenceByCache(User $user): int
    {
        $count = Cache::get(static::allQuantityReferenceCacheKey($user->id));
        if ($count === null) {
            static::updateAllQuantityReferencesInCache($user);
        } else {
            return $count;
        }

        return (int) Cache::get(static::allQuantityReferenceCacheKey($user->id));
    }

    /**
     * Получить количество рефов в папке из кеша
     */
    public function getFolderQuantityReferenceFromCache(): int
    {
        $count = Cache::get($this->folderQuantityReferenceCacheKey($this->id));
        if (is_null($count)) {
            $this->updateFolderQuantityReferenceInCache();
        } else {
            return $count;
        }

        return Cache::get($this->folderQuantityReferenceCacheKey($this->id));
    }

    public function delete(): bool
    {
        $fr = new FileStorage();
        $fr->delete(new FileIdentityDTO('reference', $this->user_id, $this->id));

        return parent::delete();
    }
}
