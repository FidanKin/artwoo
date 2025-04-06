<?php

namespace Source\Helper\FormObjectTransfer;

/**
 * Абстрактный метод, который получаем данные для элемента формы
 * Здесь элементы формы задаются в методах, методы должны быть названы по следующему правилу:
 *  form_{name}, где name - определенное название формы (абстракция)
 *
 * Конструктор можно переопределять, если требуется использовать сущность (Model), в который хранятся данные
 *
 */
abstract class FormInstance
{
    protected array $defaults = [];
    public function __construct(
        protected DataDefinition $definition
    ) {

    }

    /**
     * Получения определения для формы
     *
     * @param string $name - название формы для экспорта
     * @return array
     */
    public function export(string $name): array
    {
        $templateName = "form_{$name}";
        if (!method_exists(get_called_class(), $templateName)) {
            throw new \InvalidArgumentException("In " . (get_called_class()) . "  method $templateName not exist");
        }

        $this->{$templateName}();
        $this->definition->sefDefaults($this->defaults);
        $formdata = $this->definition->extract();
        $this->validation($formdata);
        return $formdata;
    }

    /**
     * Утсановка значений по умолчанию для элеметов формы
     *
     * @param array $attributes
     * @return $this
     */
    public function setDefaultAttributes(array $attributes): self {
        $this->defaults = $attributes;
        return $this;
    }

    /**
     * Валидация полей
     *
     * @param array $data
     * @return void
     */
    protected abstract function validation(array &$data): void;

}
