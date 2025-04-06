<?php

namespace Source\Event;

use Source\Event\Exceptions\EventInvalidArgumentException;
use Source\Event\Interfaces\EventInterface;
use Source\Helper\Enums\Crud;

/**
 * Абстрактный класс для формирования данных события для последующего их логирования
 * Все созданные события должны наследоваться от этого класса
 */
abstract class AbstractEvent implements EventInterface
{
    private EventDTO $eventDTO;
    private string $eventName;

    /**
     * Event instance
     *
     * @param Crud $crud - произведенное действие над сущностью
     * @param string|null $component - название компонента
     * @param int|null $userId - идентификатор текущего пользователя
     * @param string|null $objectTable - связанная таблица с объектом, над которым произвели действие
     * @param int|null $objectId - идентификатор записи из таблицы
     * @param int|null $relatedUserId - затронутый пользователь (над которым выполнялось действие)
     * @param array|null $other - дополнительные параметры
     * @param string|null $ip - текущий адрес
     */
    public function __construct(
        Crud $crud,
        private readonly ?string $component = null,
        int $userId = null,
        string $objectTable = null,
        int $objectId = null,
        int $relatedUserId = null,
        private readonly ?array $other = null,
        private readonly ?string $ip = null
    ) {
        $this->eventDTO = new EventDTO(
            $this->getEventName(),
            $this->getComponent(),
            $this->getAction(),
            $crud->value,
            $userId,
            $this->getCreatedTime(),
            $objectTable,
            $objectId,
            $relatedUserId,
            $this->getOtherData(),
            $this->getIp()
        );
    }

    private function validate(): bool {
        foreach ($this->rules() as $rulename => $ruleprops) {
            if (isset($this->eventData[$rulename])) {
                if (!$this->checkRuleItem($this->eventData[$rulename], $ruleprops)) return false;
            } else {
                // устанавливаем значение по умолчанию
                $this->eventData[$rulename] = null;
            }
        }
        return true;
    }

    /**
     * Правила для валидации
     *
     * @return array[]
     */
    private function rules(): array {
        return [
            'crud' => ['required' => true, 'type' => Crud::class],
            'component' => ['required' => false, 'type' => 'string'],
            'user_id' => ['required' => true, 'type' => 'int'],
            'object_table' => ['required' => false, 'type' => 'string'],
            'object_id' => ['required' => false, 'type' => 'int'],
            'related_user_id' => ['required' => false, 'type' => 'int'],
            'other' => ['required' => false, 'type' => 'array'],
            'ip' => ['required' => false, 'type' => 'string']
        ];
    }

    /**
     * Проверяем значение на соотвествие определенному правилу
     *
     * @param $data - значение, которое нужно проверить
     * @param array $rule - массив правил
     * @return bool
     */
    private function checkRuleItem($data, array $rule): bool {
        $dataType = gettype($data);
        if ($rule['required'] && is_null($data)) return false;
        if (((is_null($data)) || $dataType === $rule['type'])) {
            if ($dataType !== 'object') return true;
            if ($data instanceof $rule['type']) return true;
        }
        return false;
    }

    private function getEventName(): string {
        $this->eventName = (new \ReflectionClass(static::class))->getName();
        return $this->eventName;
    }

    /**
     * Получаем название компонента по его классу (или же если название компонента передано)
     * Если компонент не передан в конструкторе, то берем его из полного названия класса:
     *   Компонентом явялется папке, на два уровня выше файла события
     *
     * @return string|EventInvalidArgumentException
     */
    private function getComponent(): string|EventInvalidArgumentException {
        if (!empty($this->component)) {
            return mb_strtolower($this->component);
        }
        $component = array_slice($this->explodeEventName(), -3, 1);
        if (!empty($component)) return mb_strtolower($component[0]);
        throw new EventInvalidArgumentException($this->eventName);
    }

    private function getAction(): string {
        $splitToArr = $this->explodeEventName();
        return array_pop($splitToArr);
    }

    private function explodeEventName(): array {
        return \explode('\\', $this->eventName);
    }

    private function getCreatedTime(): string {
        return date('Y-m-d H:i:s');
    }

    private function getOtherData(): ?string {
        if (empty($this->other)) return null;
        return json_encode($this->other, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_SLASHES);
    }

    private function getIp(): ?string {
        if (filter_var($this->ip, FILTER_VALIDATE_IP)) {
            return $this->ip;
        }
        return null;
    }

    public function getEventData(): array
    {
        return [
            'event_name' => $this->eventDTO->eventName,
            'component' => $this->eventDTO->component,
            'action' => $this->eventDTO->action,
            'object_table' => $this->eventDTO->objectTable,
            'object_id' => $this->eventDTO->objectId,
            'crud' => $this->eventDTO->crud,
            'user_id' => $this->eventDTO->userId,
            'related_user_id' => $this->eventDTO->relatedUserId,
            'other' => $this->eventDTO->other,
            'ip' => $this->eventDTO->ip,
            'created_at' => $this->eventDTO->createdAt
        ];
    }
}
