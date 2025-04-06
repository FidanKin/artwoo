<?php

namespace Source\Entity\User\Models;

use App\Exceptions\BaseFileHandlerException;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Source\Access\Enums\RoleEnum;
use Source\Auth\Dictionaries\AuthType;
use Source\Entity\Artwork\Dictionaries\ArtworkStatus;
use Source\Entity\Artwork\Models\Artwork;
use Source\Entity\Chat\Models\Chat;
use Source\Entity\Chat\Models\ChatMessage;
use Source\Entity\Chat\Models\ChatUser;
use Source\Entity\Reference\Models\Folder;
use Source\Entity\Reference\Models\Reference;
use Source\Entity\Resume\Models\Resume;
use Source\Lib\Abstracts\SearchInputs;
use Source\Lib\Contracts\ModelFilterFromRequest;
use Source\Lib\FileStorage;
use Source\Lib\FileIdentityDTO;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Source\Entity\User\Dictionaries\UserStatus;

use function Source\Helper\artwooDiffTimestampsToHuman;

class User extends Authenticatable implements ModelFilterFromRequest, MustVerifyEmail, CanResetPassword
{
    use HasFactory, Notifiable, SoftDeletes, Prunable;

    protected const PER_PAGE = 50;

    protected $rememberTokenName = '';

    private array $sessionData = [
        'role', 'login'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'login',
        'email',
        'birthday',
        'password',
        'policyagreed',
        'role',
        'status',
        'auth',
        'phone',
        'freelance',
        'creativity_type',
        'about',
        'show_socials',
        'photo',
        'item_id',
    ];

    protected $guarded = ['id', 'created_at', 'updated_at',];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static $hiddenStatic = [
        'password',
        'remember_token',
    ];

    // поля, которые пользователь может редактировать
    public $userCanEdit = [
        'login',
        'email',
        'birthday',
        'password',
        'policyagreed',
        'phone',
        'freelance',
        'creativity_type',
        'about'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $table = 'users';

    protected function birthday(): Attribute
    {
        return Attribute::make(
            get: function(?string $value) {
                if ($value) {
                    return \DateTime::createFromFormat(config('app.artwoo.date.mysql_format'), $value)->
                        format(config('app.artwoo.date.format'));
                }

                return null;
            },
            set: function(?string $value) {
                if ($value) {
                    $format = \DateTime::createFromFormat(config('app.artwoo.date.format'), $value);

                    if ($format) {
                        return $format->format(config('app.artwoo.date.mysql_format'));
                    }
                    return null;
                }
            }
        );
    }

    protected function serializeDate(\DateTimeInterface $date): string
    {
        return $date->format('d-m-Y');
    }

    public function artworks(): HasMany
    {
        return $this->hasMany(Artwork::class)->whereIn('status', [ArtworkStatus::ACTIVE->value, ArtworkStatus::DRAFT->value]);
    }

    public function resume(): HasOne
    {
        return $this->hasOne(Resume::class);
    }

    public function folder(): HasMany
    {
        return $this->hasMany(Folder::class);
    }

    public function reference(): HasManyThrough
    {
        return $this->hasManyThrough(Reference::class, Folder::class);
    }

    /**
     * Получить модель сообщений пользователя
     */
    public function chatMessage(): HasMany
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function chatUsers(): HasMany
    {
        return $this->hasMany(ChatUser::class);
    }

    /**
     * Создание пользователя в БД
     *
     * @return bool|self
     */
    public function createUser() : self|false
    {
        $fields = $this->getAttributes();
        if (empty($fields)) {
            return false;
        }
        $this->setAttribute('role', RoleEnum::author->value);
        $this->setAttribute('policyagreed', $fields['policyagreed'] === 'on' ? 1 : 0);
        $this->setDefaultAttributes();

        if ($this->save()) {
            return $this->refresh();
        }

        return false;
    }

    /**
     * Обновить запись пользователя
     *
     * @param array $userAttributes - обработанные поля из формы (обработанные чекбоксы, даты и т.п.)
     * @param $enableCustom - обновить ли кастомные поля пользователя
     * @return bool
     */
    public function updateUser(array $userAttributes, bool $enableCustom = false): bool
    {
        $filtered = $this->filterAttributes($userAttributes);
        $result = $this->update($filtered);

        if (! empty($userAttributes['user_picture'])) {
            $fs = new FileStorage();

            if (! empty($fs->getFiles(new FileIdentityDTO('user', $this->id, $this->id, 'user_picture')))) {
                $fs->delete(new FileIdentityDTO('user', $this->id, $this->id, 'user_picture'));
            }

            try {
                $fs->saveOne($userAttributes['user_picture'], new FileIdentityDTO('user', $this->id, $this->id, 'user_picture'));
            } catch (BaseFileHandlerException $exception) {
                //
            }

        }

        if ($enableCustom) {
            $potentialCustoms = array_diff_key($userAttributes, $filtered);
            UserCustomFields::updateCustomFields($this, $potentialCustoms);
        }

        return $result;
    }

    private function filterAttributes(array $attributes): array
    {
        return array_filter($attributes, fn($key) => in_array($key, $this->fillable), ARRAY_FILTER_USE_KEY);
    }

    /**
     * Устанавливаем значения по умолчания при регистрации пользователя: status and auth
     *
     * @return void
     */
    private function setDefaultAttributes(): void
    {
        $this->setAttribute('status', UserStatus::DRAFT->value);
        $this->setAttribute('auth', AuthType::MANUAL->value);
    }

    /**
     * Получение полей, которых нельзя отображать их прямое значение
     *
     * @return string[]
     */
    public static function fillableAttributes(): array
    {
        return static::$hiddenStatic;
    }

    /**
     * Получаем отфильтрованный массив, исключая из него поля, которые не должны использоваться в первоначальном виде
     *
     * @param array $userAttributes - массив в виде ключ => значение
     * @return array - результирующий массив
     */
    public static function filterUserAttributes(array $userAttributes): array {
        return array_filter($userAttributes, fn($attr) => !in_array($attr, static::fillableAttributes()), ARRAY_FILTER_USE_KEY);
    }

    public function customFields(): array
    {
        $customFields = new UserCustomFields();
        $fields = $customFields->getFields($this);
        $result = [];
        foreach ($fields as $rawRecord) {
            $result[$rawRecord['shortname']] = $rawRecord['data'];
        }

        return $result;
    }

    public function getCreativityLangString(): string {
        $langString = '';
        try {
            $creativity = new CreativityType(\Source\Entity\User\Dictionaries\CreativityType::from($this->creativity_type));
            $langString = $creativity->getAuthorName();
        } catch (\ValueError $exception) {
            // у пользователя не задан тип крективности - это норм
        };
        return $langString;
    }

    /**
     * Получить Enum объект тип творчества пользователя
     *
     * @return \Source\Entity\User\Dictionaries\CreativityType|null
     */
    public function getCreativityEnum(): \Source\Entity\User\Dictionaries\CreativityType|null {
        return \Source\Entity\User\Dictionaries\CreativityType::tryFrom($this->creativity_type);
    }

    /**
     * Получить возраст пользователя
     */
    public function getAge(): string {
        if (! $this->birthday) {
            return '';
        }
        return artwooDiffTimestampsToHuman(
          date('Y-m-d H:i:s'), $this->birthday, ' ', false
        );
    }

    /**
     * Получить ссылку на аватар пользователя
     *
     * @return string|bool - ссылка на иконку или false
     */
    public function getIconUrl(): string|bool {
        if (!isset($this->id)) return false;
        $fs = new FileStorage();
        $icon = $fs->getFilesAsUrl(new FileIdentityDTO('user', $this->id, $this->id, 'user_picture'));
        if (empty($icon)) return $this->defaultUserIconUrl();
        return $icon[0];
    }

    private function defaultUserIconUrl(): string {
        return url("/icons/user/default_user_icon.svg");
    }

    private function deleteIcon(): bool
    {
        $fs = new FileStorage();
        return $fs->delete(new FileIdentityDTO('user', $this->id, $this->id, 'user_picture'));
    }

    /**
     * Получить пользователей только с ролью автор
     *
     * @param array $filter
     *
     * @return \Source\Entity\User\Models\User[]
     */
    public static function getAuthors(array $filter = []): array
    {
        $authorRole = RoleEnum::author->value;
        return static::where("role", "=", $authorRole)->get()->all();
    }

    /**
     * Получить авторов с учетом пагинации (по умолчанию, 50 единиц на страницу)
     *
     * @return Paginator
     */
    public static function getAuthorsWithPagination(?SearchInputs $searches = null): Paginator
    {
        $authorRole = RoleEnum::author->value;

        $builder = $searches ? static::filter($searches()) : static::latest();

        return $builder->where("role", "=", $authorRole)->whereIn('status', [UserStatus::DRAFT->value, UserStatus::ACTIVE->value])
            ->simplePaginate(static::PER_PAGE);
    }

    public function scopeFilter(Builder $query, array $requestParams): void
    {
        $rules = $this->filterRules($query);

        foreach ($requestParams as $param => $value) {
            if (empty($value)) continue;
            if (isset($rules[$param])) {
                $rules[$param]($value);
            }
        }
    }

    protected function filterRules(Builder $builder): array
    {
        return ['search' => static function ($value) use ($builder) {
                $builder->where('login', 'like', '%' . $value . '%');
            }
        ];
    }

    /**
     * Получить количество авторов. Значение записывается в кеш, чтобы каждый раз не обходить всю таблицу
     * @param bool $rebuildCache - нужно ли обновлять кеш
     *
     * @return int
     */
    public static function getCountedAuthors(bool $rebuildCache = false): int
    {
        $cacheName = 'count_authors';
        $fromCache = Cache::get($cacheName);
        if ($rebuildCache || empty($fromCache)) {
            $result = static::where("role", "=", RoleEnum::author->value)->whereIn('status', [UserStatus::DRAFT->value,
                UserStatus::ACTIVE->value])->count();
            Cache::put($cacheName, $result);
            return $result;
        }

        return $fromCache;
    }

    /**
     * Получить ссылки на социальные сети в виде: краткое_название => ссылка_на_профиль
     *
     * @return array
     */
    public function getSocialsLink(): array
    {
        $links = [];

        if (empty($this->show_socials)) {
            return $links;
        }

        $services = $this->socialServices();
        $custom = $this->customFields();

        foreach ($custom as $name => $value) {
            if (empty($value)) {
                continue;
            }

            $userName = strtolower($value);

            // логин может начинаться с @
            if (str_starts_with($value, '@')) {
                $userName = substr($value, 1);
            }

            // проверяем, что юзернейм содержит только английские буквы и цифры
            if (preg_match('/[^a-z0-9]/', $userName)) {
                continue;
            }

            $socialName = substr($name, 0, strpos($name, '_username'));

            if (array_key_exists($socialName, $services)) {
                $links[$socialName] = $services[$socialName] . $userName;
            }
        }

        return $links;
    }

    /**
     * Получить социальные сервисы в форме: короткое название => хост
     * example: ['vk' => 'https://vk.com/']
     *
     * @return string[]
     */
    private function socialServices(): array
    {
        return [
            'vk' => 'https://vk.com/',
            'telegram' => 'https://t.me/',
        ];
    }

    /**
     * Получить пользователей, которых еще не проверили
     *
     * @return Paginator
     */
    public static function getDraftUsers(): Paginator
    {
        $users = static::where('status', '=', UserStatus::DRAFT->value)->latest();
        return $users->simplePaginate(static::PER_PAGE);
    }

    public function prunable(): Builder
    {
        return static::whereNotNull('deleted_at');
    }

    /**
     * Удалить данные, связанные с моделью
     *
     * @return void
     */
    protected function pruning(): void
    {
        // удалить все изображения пользователя
        $ok = $this->deleteIcon();
        // удалить резюме
        if (! empty($this->resume)) {
            $ok = $this->resume->delete() && $ok;
        }
        // удалить творческие работы
        foreach ($this?->artworks ?? [] as $artwork) {
            $ok = $artwork->delete() && $ok;
        }
        // удалить референсы
        foreach ($this->folder ?? [] as $folder) {
            $ok = $folder->delete() && $ok;
        }
        // удалить чаты
        foreach ($this->chatUsers as $chatUser) {
            $chatUserId = $chatUser->chat_id;
            if (Chat::where('id', '=', $chatUserId)->delete()) {
                $ok = $chatUser->delete() && $ok;
            };
        }

        // удалить кастомные поля
        $ok = UserCustomFields::where('user_id', '=', $this->id)->delete() && $ok;
        $ok = (string) $ok;

        Log::info("Task: delete_user; ID -> {$this->id}; OK: {$ok}");
    }
}
