<?php

namespace Source\Entity\Artwork\Models;

use App\Exceptions\BaseFileHandlerException;
use App\View\Core\Components\ContentMetaInfo\ContentMetaInfo;
use App\View\Core\Components\ContentMetaInfo\MainInfo;
use App\View\Core\Components\ContentMetaInfo\MetaInfoFromModelInterface;
use App\View\Core\Components\ContentMetaInfo\SecondaryInfo;
use App\View\Core\Components\ContentMetaInfo\TagInfo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Source\Entity\Artwork\Dictionaries\ArtworkStatus;
use Source\Entity\Artwork\Dictionaries\Colors;
use Source\Entity\User\Models\User;
use Source\Lib\Abstracts\SearchInputs;
use Source\Lib\Contracts\ModelFilterFromRequest;
use Source\Lib\DTO\ArtworkSizeDTO;
use Source\Lib\DTO\PaginatorModelDTO;
use Source\Lib\FileIdentityDTO;
use Source\Lib\FileRecord;
use Source\Lib\FileStorage;
use Source\Lib\TagDTO;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Artwork extends \Illuminate\Database\Eloquent\Model implements MetaInfoFromModelInterface, ModelFilterFromRequest
{
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'category',
        'topic',
        'price',
        'created_year',
        'color',
        'size',
        'number_components'
    ];

    protected $attributes = [
        'number_components' => 1,
    ];

    protected function name(): Attribute
    {
        return Attribute::get(fn(string $value) => strip_tags($value));
    }

    protected function size(): Attribute
    {
        return Attribute::get(fn($value) => array_slice(json_decode($value, true), 0, $this->number_components));
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Метод создания новой записи
     * Возвращается массив ошибок. Если массив пуст, значит всё прошло ок
     * Ошибки содержат ключ инпута. Если же ошибка при сохранение самой сущености, то возващается ошибку по ключу
     *  model, ['model' => 'error_code']
     *
     * @return array|string[]
     */
    public function store($inputData): array
    {
        require_once base_path('source/Helper/AppLib.php');

        $errors = [];
        $data = $this->prepareData($inputData);
        $this->setAttribute('size', json_encode($data['size']));
        $this->setAttribute('number_components', $data['number_components']);
        $this->setAttribute('description', nl2br(strip_tags($this->description)));
        $this->save();

        if (! empty($this->id)) {
            $id = $this->id;

            $fs = new FileStorage();
            try {
                $fs->saveMany($inputData['images'], new FileIdentityDTO('artwork', $this->user_id, $id));
            } catch (BaseFileHandlerException $exception) {
                $errors['images'] = $exception->getMessage();
            }

            return $errors;
        }

        return ['model' => 'cannot_save'];
    }

    /**
     * Обновление записи
     *
     * @return array|string[]
     */
    public function edit($inputData): array
    {
        $errors = [];
        $data = $this->prepareData($inputData);
        $this->fill($data);

        $this->setAttribute('description', nl2br(strip_tags($this->description)));
        if (! $this->save()) {
            return ['model' => 'cannot_save'];
        }

        if (! empty($data['images'])) {
            $maxFiles = config('app.artwoo.artwork.max_files');
            $fs = new FileStorage();
            try {
                $files = is_array($inputData['images']) ? $inputData['images'] : [$inputData['images']];
                $fileDTO = new FileIdentityDTO('artwork', $this->user_id, $this->id);

                $exists = count($fs->getFiles($fileDTO));
                if ($exists < $maxFiles) {
                    $files = array_slice($files, 0, $maxFiles - $exists);
                    $fs->saveMany($files, $fileDTO);
                }
            } catch (BaseFileHandlerException $exception) {
                $errors['images'] = $exception->getMessage();
            }
        }

        return $errors;
    }

    protected function prepareData(array $data): array
    {
        $data['size'] = $this->prepareSize($data);
        if (empty($data['number_components'])) {
            $data['number_components'] = 1;
        }

        if (count($data['size']) !== $data['number_components']) {
            $data['number_components'] = count($data['size']);
        }

        return Arr::only($data, $this->fillable);
    }

    /**
     * Выполнить удаление творческой работы
     *
     * @throws \Exception
     */
    public function delete(): bool
    {
        try {
            $deleted = parent::delete();
            if ($deleted) {
                $fs = new FileStorage();
                $fs->delete(new FileIdentityDTO('artwork', $this->user_id, $this->id));
            }

            return $deleted;
        } catch (\Exception $exception) {
            if (config('app.debug')) {
                throw new $exception;
            }
            Log::warning("Cannot delete model. Reason: {$exception->getMessage()}");
        }

        return false;
    }

    /**
     * Обновляем сортировку загруженным изображениям
     *
     * @param array $items
     * @return bool
     */
    public function updateImagesOrder(array $items): bool
    {
        $pathnamehashes = array_map(function ($item) {
            return $item[0];
        }, $items);

        $fileRecords = DB::table('files')->whereIn('pathnamehash', $pathnamehashes)->select(['id', 'item_id'])
            ->get()->toArray();

        $valid = true;

        // проверяем, что пользователь правил свои изображения, а не чужие
        foreach ($fileRecords as $fileRecord) {
            if ($fileRecord->item_id !== $this->id) {
                $valid = false;
                break;
            }
        }

        if (! $valid) {
            return false;
        }

        return FileRecord::setOrder($items);
    }

    /**
     * Список возможных типов размещаемой работы
     */
    public static function artwork_types_list(): array
    {
        return [
            'picture' => __('artwork.types.picture'),
            'handmade' => __('artwork.types.handmade'),
            'sculpture' => __('artwork.types.sculpture'),
        ];
    }

    /**
     * Возможные темы для выбора при размещении работ
     *
     * @see https://www.notion.so/e219c8c8a4444c2c935f6041de2f8a9c
     */
    public static function artwork_topics_list(): array
    {
        return [
            'abstraction' => __('artwork.topics.abstraction'),
            'animals' => __('artwork.topics.animals'),
            'architecture' => __('artwork.topics.architecture'),
            'plants' => __('artwork.topics.plants'), // цветы и растения
            'nature' => __('artwork.topics.nature'),
            'erotica' => __('artwork.topics.erotica'),
            'people' => __('artwork.topics.people'),
            'love' => __('artwork.topics.love'),
            'technologies' => __('artwork.topics.technologies'),
            'other' => __('artwork.topics.other'),
            'space' => __('artwork.topics.space'),
        ];
    }

    public static function getColorsMenu(): array
    {
        return Colors::selectColors();
    }

    private function getTopicHumanValue(): string
    {
        return static::artwork_topics_list()[$this->topic] ?? '';
    }

    /**
     * Берем из даты ширину, высоту и глубины и подготавливаем массив для сохранения
     *
     * @param array $data
     * @return array
     */
    private function prepareSize(array $data): array
    {
        $result = [];

        for($i = 0; $i < 5; $i++) {
            if (!isset($data['width'][$i])) {
                break;
            }

            $result[] = [
                'width' => $data['width'][$i],
                'height' => $data['height'][$i],
                'depth' => $data['depth'][$i] ?? 0,
            ];
        }

        return $result;
    }

    /**
     * Приводит размер работы к строке с разделителем
     *  Например, 25x45x12, 12x54
     *
     * @param  ?int  $depth
     */
    public static function toInlineArtworkSize(int $width, int $height, int $depth = null): string
    {
        $asArray = [$width, $height];
        if (! empty($depth)) {
            $asArray[] = $depth;
        }

        return implode('x', $asArray);
    }

    public function convertSizeToInline(ArtworkSizeDTO $size): string
    {
        $depth = !empty($size->depth) ? 'x' . $size->depth : '';
        return $size->width . 'x' . $size->height . $depth;
    }

    public function getContentMetaInfo(): ContentMetaInfo
    {
        $metaInfo = new ContentMetaInfo();
        $mainInfo = new MainInfo();
        $secondaryInfo = new SecondaryInfo();

        if ($this->created_year) {
            $mainInfo->add(true, [$this->created_year . ' г.']);
        }

        $inlineSize = '';
        foreach ($this->size as $size) {
            if (! empty($inlineSize)) {
                $inlineSize .= '|';
            }
            $inlineSize .= $this->convertSizeToInline(new ArtworkSizeDTO($size['width'], $size['height'], $size['depth']));
        }

        $mainInfo->add(false, [__('artwork.artwork_size') . $inlineSize]);
        if (! empty($this->getTopicHumanValue())) {
            $mainInfo->add(true, [$this->getTopicHumanValue()]);
        }
        $metaInfo[] = $mainInfo;

        $metaInfo[] = $secondaryInfo;

        $tagInfo = new TagInfo();
        $tagInfo->add('text', static::artwork_types_list()[$this->category]);
        $tagInfo->add('url', url('/?topic='.$this->category));
        $metaInfo[] = $tagInfo;

        return $metaInfo;
    }

    /**
     * Получить ссылки на отображение изображений
     */
    public function getImageUrls(): array
    {
        $fs = new FileStorage();

        return $fs->getFilesAsUrl(new FileIdentityDTO('artwork', $this->user_id, $this->id));
    }

    /**
     * @return array{array{artwork: \Source\Entity\Artwork\Models\Artwork, images_url: string}}
     */
    public static function getArtworksByQuantityFromUser(
        int $userId, int $quantity, array $select = ['id', 'user_id']
    ): array {
        $result = [];

        /**
         * @var array<\Source\Entity\Artwork\Models\Artwork> $artworks
         */
        $artworks = static::where('user_id', '=', $userId)->limit($quantity)->orderBy('created_at')
            ->select($select)->get()->all();

        foreach ($artworks as $artwork) {
            $images = $artwork->getImageUrls();
            if (empty($images)) {
                continue;
            }
            $result[] = [
                'artwork' => $artwork,
                'images_url' => $artwork->getImageUrls(),
            ];
        }

        return $result;
    }

    /**
     * Получить все авторские работы с учетом фильтра
     *
     * @param bool $withImages - включать ли изображения
     * @param ?SearchInputs $filter - инпуты с фильтром
     * @return PaginatorModelDTO
     */
    public static function getAllWithPagination(bool $withImages = true, ?SearchInputs $filter = null): PaginatorModelDTO
    {
        $result = [];
        $builder = $filter ? static::filter($filter())->latest() : static::latest();
        $all = $builder->whereIn('status', [ArtworkStatus::DRAFT->value, ArtworkStatus::ACTIVE->value])->simplePaginate(50);

        if ($withImages) {
            foreach ($all as $artwork) {
                $images = $artwork->getImageUrls();

                if (empty($images)) {
                    continue;
                }

                $artwork = $artwork->toArray();
                $artwork['image'] = $images[0];
                $artwork['category'] = Artwork::artwork_types_list()[$artwork['category']];
                $result[] = $artwork;
            }
        }

        return new PaginatorModelDTO($all, $result);
    }

    /**
     * Получить теги для компонента artwork - творческой работы
     *
     * @return array<TagDTO>
     */
    public static function tags(array $query = []): array
    {
        $tags = [];
        $topics = static::artwork_types_list();
        $queryTopic = $query['topic'] ?? '';

        foreach ($topics as $code => $text) {
            $active = false;

            if ($queryTopic == $code) {
                $active = true;
            }

            $tags[] = new TagDTO($text, $code, '?topic', $active);
        }

        return $tags;
    }

    /**
     * Фильтрация записей по параметрам запроса
     *
     * @param Builder $query
     * @param array $requestParams
     * @return void
     */
    public function scopeFilter(Builder $query, array $requestParams = []): void
    {
        $rules = $this->filterRules($query);

        foreach ($requestParams as $param => $value) {
            if (empty($value)) continue;
            if (isset($rules[$param])) {
                $rules[$param]($value);
            }
        }
    }

    /**
     * Определяем правила фильтрации
     *
     * @param Builder $query
     * @return mixed
     */
    protected function filterRules(Builder $query): array
    {
        $sizes = [];
        $maxIndex = count(config('app.artwoo.artwork.component_quantity'));
        foreach (['width', 'height', 'depth'] as $prop) {
            foreach (['_from' => '>=', '_to' => '<='] as $cond => $operator) {
                $sizes[$prop . $cond] = static function($value) use ($query, $prop, $operator, $maxIndex) {
                    $value = (int) $value;
                    $start = '';
                    $end = '';
                    $boolean = 'or';

                    for($i = 0; $i < $maxIndex; $i++) {
                        if ($i === 0) {
                            $start = "(";
                            $boolean = 'and';
                        } else if ($i === $maxIndex - 1) {
                            $end = ")";
                        }

                        $query->whereRaw(
                            "{$start}JSON_UNQUOTE(JSON_EXTRACT(size, '$[{$i}].{$prop}')) $operator ? {$end}", [$value], $boolean
                        );

                        $start = $end = '';
                        $boolean = 'or';
                    }
                };
            }
        }

        return array_merge($sizes, [
            'price_from' => static function($value) use($query) {
                $query->where('price', '>=', $value);
            },
            'price_to' => static function($value) use($query) {
                $query->where('price', '<=', $value);
            },
            'price_no' => static function($value) use($query) {
                $query->whereNull('price');
            },
            'topic' => static function(string $value) use($query) {
                if (in_array($value, array_keys(static::artwork_types_list()))) {
                    $query->where('category', '=', $value);
                }
            },
            'search' => static function($value) use($query) {
                $query->where('name', 'like', '%'.$value.'%');
            },
            'color' => static function($value) use($query) {
                $query->whereIn('color', array_keys($value));
            },
            'component_number'=> static function($value) use($query) {
                $query->where('number_components', '=', $value);
            }
        ]);
    }

    /**
     * Получить работы, которые еще не проходили модерацию
     * В результате также получаем изображения
     *
     * @return PaginatorModelDTO
     */
    public static function getDrafts(): PaginatorModelDTO
    {
        $result = [];
        $artworks = static::where('status', '=', ArtworkStatus::DRAFT->value)->latest()->simplePaginate(50);

        foreach ($artworks as $artwork) {
            $images = $artwork->getImageUrls();
            $result[] = ['artwork' => $artwork, 'images' => $images];
        }

        return new PaginatorModelDTO($artworks, $result);
    }

}
