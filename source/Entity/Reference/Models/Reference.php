<?php

namespace Source\Entity\Reference\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Source\Entity\User\Models\User;
use Source\Lib\Abstracts\SearchInputs;
use Source\Lib\Contracts\ModelFilterFromRequest;
use Source\Lib\DTO\PaginatorModelDTO;
use Source\Lib\FileIdentityDTO;
use Source\Lib\FileStorage;

use function Source\Lib\Text\artwooShortText;

class Reference extends \Illuminate\Database\Eloquent\Model implements ModelFilterFromRequest
{
    use HasFactory;

    private const PER_PAGE = 60;
    private const CACHE_FIRST_TEN_REFERENCES_PREFIX = 'core:reference:first_ten_';

    protected $fillable = ['name', 'folder_id'];

    public $timestamps = false;

    protected $casts = [];

    public function folder(): BelongsTo
    {
        return $this->belongsTo(Folder::class);
    }

    private static function topPreferencesCacheKey(int $userId): string
    {
        return static::CACHE_FIRST_TEN_REFERENCES_PREFIX.$userId;
    }

    public static function setTopReferencesToCache(User $user): bool
    {
        $refenreces = static::orderByDesc('id')->limit(10)->get()->reduce(function ($accum, $ref) use ($user) {
            $fs = new FileStorage();
            $file = $fs->getFiles(new FileIdentityDTO('reference', $user->id, $ref->folder_id, "user_references_{$ref->id}"));
            if ($file) {
                $file = $file[0];
                $accum[] = [
                    'url' => url("filesmanager/{$file->pathnamehash}"),
                    'name' => artwooShortText($file->filename),
                    'id' => $ref->id,
                ];
            }

            return $accum;
        }, []);

        return Cache::put(static::topPreferencesCacheKey($user->id), $refenreces, 60 * 60);
    }

    /**
     * Получить максимум 10 элементов рефов из кеша
     */
    public static function getTenReferencesByCache(User $user): ?array
    {
        $refs = Cache::get(static::topPreferencesCacheKey($user->id));
        if (is_null($refs)) {
            static::setTopReferencesToCache($user);
        } else {
            return $refs;
        }

        return Cache::get(static::topPreferencesCacheKey($user->id));
    }

    public function scopeFilter(Builder $query, array $requestParams): void
    {
        $rules = $this->filterRules($query);

        foreach ($requestParams as $key => $value) {
            if (empty($value)) continue;
            if (isset($rules[$key])) {
                $rules[$key]($value);
            }
        }
    }

    protected function filterRules(Builder $query): array
    {
        return [
            'search' => static function($value) use($query) {
                $query->where('name', 'like', '%'.$value.'%');
            },
            'folder_id' => static function ($value) use($query) {
                $query->where('folder_id', '=', $value);
            }
        ];
    }

    public static function getWithPaginator(int $userid, ?SearchInputs $filter = null): PaginatorModelDTO|false
    {
        $foldersQuery = Folder::where('user_id', '=', $userid);

        if (isset($filter()['folder_id'])) {
            $foldersQuery->where('id', '=', $filter()['folder_id']);
        }

        $folders = $foldersQuery->get();

        if ($folders->isEmpty()) {
            return false;
        }

        $query = static::whereBelongsTo($folders);

        $query->orderBy('id');

        if ($filter) {
            $query->filter($filter());
        }

        $paginator = $query->simplePaginate(self::PER_PAGE);
        $references = [];
        foreach ($paginator->items() as $reference) {
            $reference = $reference->toArray();
            $fs = new FileStorage();
            $file = $fs->getFilesAsUrl(new FileIdentityDTO(
                'reference',
                $userid,
                $reference['folder_id'],
                "user_references_{$reference['id']}"
            ));

            if (! empty($file)) {
                $reference['image_url'] = $file[0];
                $references[] = $reference;
            }
        }

        return new PaginatorModelDTO($paginator, $references);
    }
}
