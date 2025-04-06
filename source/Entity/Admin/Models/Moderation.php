<?php

namespace Source\Entity\Admin\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Source\Event\ItemModerated;

class Moderation extends Model
{
    protected $fillable = ['component', 'object_id', 'target_user', 'moderator', 'other', 'comment'];
    protected $table = 'content_moderation';

    protected function other(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => json_decode($value),
            set: fn($value) => json_encode($value),
        );
    }

    /**
     * Events
     * Другие компоненты слушают это событие и для актуализации статуса используют данные из сессии
     * То есть здесь происходит лишь модерация, в самой сущености статус меняется при отлове события
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => ItemModerated::class,
    ];
}
