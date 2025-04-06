<?php

namespace Source\Entity\User\Models;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\JoinClause;

class UserCustomFields extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = [
        'user_id',
        'field_id',
        'data'
    ];

    protected $table = 'user_info_data';

    private $tablestatic = 'user_info_data';

    // таблица, где храним информацию о самом поле
    private static string $metadataTable = 'user_info_field';

    /**
     * Получение полной информации по полю
     *
     * @param array $names
     * @return array
     */
    public static function fieldsMetadata(array $names = []): array {
        $fullMetadata = Cache::rememberForever('custom_fields:info', function() {
            return DB::table(static::$metadataTable)->get()->toArray();
        });

        if (empty($fullMetadata)) return [];

        $result = [];
        if (!empty($names)) {
            foreach ($fullMetadata as $metadata) {
                if (in_array($metadata->shortname, $names)) {
                    $result[$metadata->shortname] = $metadata;
                }
            }

            return $result;
        }

        return $fullMetadata;
    }

    /**
     * Получаем список доступных названий кастомных полей в виде name => id
     *
     * @return array
     */
    public static function allowedFields(): array
    {
        return Cache::rememberForever('custom_fields:allowed', function() {
            return DB::table(static::$metadataTable)->select(['id', 'shortname'])
                ->pluck('id', 'shortname')->toArray();
        });
    }

    /**
     * Получение значений кастомных полей по пользователю
     * @todo записать в сессию
     *
     * @param User $user
     * @return array
     */
    public function getFields(User $user): array {
        return static::rightJoin(static::$metadataTable, function (JoinClause $join) use($user) {
            $join->on(static::$metadataTable.'.id', '=', $this->table.'.field_id')
            ->where($this->table.'.user_id', '=', $user->id);
        })->select(['shortname', 'data'])->get()->toArray();
    }

    /**
     * Обновление кастомных полей пользователя
     *  Метод выполняет также фильтрацию
     *
     * @param User $user - текущий пользователь
     * @param array $attributes - кастомные поля пользователя
     * @return void
     */
    public static function updateCustomFields(User $user, array $attributes = []): void {
        $customEntity = new self();
        $allowedFields = static::allowedFields();
        $fields = array_intersect_key($attributes, $allowedFields);
        foreach ($fields as $name => $fieldValue) {
            DB::table($customEntity->table)
                ->updateOrInsert(
                    ['user_id' => $user->id, 'field_id' => $allowedFields[$name]],
                    ['data' => $fieldValue]
                );
        }
    }
}
