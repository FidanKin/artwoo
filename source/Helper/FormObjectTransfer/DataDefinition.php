<?php

namespace Source\Helper\FormObjectTransfer;

use App\View\Core\FormElementConst;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Source\Helper\Enums\FormElementsFormat;

/**
 * Класс для работы с данными для view, что облегчает работу с полями
 * Данный объект знаем всю информацию о полях, которые будут отображены:
 *  название, описание, значение, тип поля, опции и валидацию
 *
 * Схема для работы с объектом такая:
 *  Model -> Controller (Request) <-> DataDefinition <-> view
 */
class DataDefinition
{
    const MOD_RENDER = 'render';
    const MOD_CHECK = 'check';

    private array $allowedMods = [self::MOD_RENDER, self::MOD_CHECK];
    private array $definition = [];
    public function __construct(
        private string $mod = self::MOD_RENDER,
        private readonly array $object = []
    ) {

    }

    /**
     * Экспортируем только данные для валидации
     *
     * @return array
     */
    private function exportForCheck(): array
    {
        if ($this->mod !== self::MOD_CHECK) {
            throw new \InvalidArgumentException('неверный тип экспорта!!!');
        }

        $rules = [];

        foreach ($this->definition as $key => $definition) {
            if ($definition['type']) {
                if (! empty($definition['options']['item'])) {
                    $rules[$key . '.*'] = $definition['options']['item'];
                }
            }

            $rules[$key] = $definition['validation'];
        }

        return $rules;
    }

    /**
     * Экспортируем данные для отображения во view формы
     *
     * @return array
     */
    private function exportForRender(): array
    {
        return $this->definition;
    }

    /**
     * Обрабатываем значение согласно типу поля (если необходимо)
     *
     * @param FormElementsFormat $format - тип поля
     * @param $value - значение для обработки
     * @return mixed
     */
    private function typeHandler(FormElementsFormat $format, $value) {
        if (empty($value)) return $value;
        $result = $value;
        switch ($format->value) {
            case FormElementsFormat::TEXT->value:
                $result = str_replace('<br />', '', $result);
                break;
//            case FormElementsFormat::FILE:
            default:
                $result;
                break;
        }

        return $result;
    }

    /**
     * Добавить в данные об одном элементе в общий пул
     *
     * @param string $name - название поля
     * @param string $placeholder - описание
     * @param array $options - различные опции
     * @param FormElementsFormat $type - тип элемента
     * @param string $validation - правило валидации
     * @return void
     */
    public function add(string $name, string $placeholder, array $options = [],
                        FormElementsFormat $type = FormElementsFormat::TEXT, string $validation = ''): void {
        $required = \str_contains($validation, 'required');
        // если элемент формы заблокирован, то из правила валидации мы должны убрать, что элемент обязателен
        // для заполнения
        if (!empty($options['state']) && $options['state'] === FormElementConst::STATE_DISABLED) {
            $validation = Str::of($validation)->remove('required');
        }

        $this->definition[$name] = [
            'name' => $name,
            'placeholder' => $this->markNameIfRequired($required, $placeholder),
            'value' => null,
            'options' => $options,
            'type' => $type,
            'validation' => $validation
        ];
    }

    private function markNameIfRequired(bool $required, string $placeholder): string {
        return $required ? $placeholder . ' *' : $placeholder;
    }

    /**
     * Утсанавливаем значения по умолчанию из объекта
     *
     * @param $object
     * @return void
     */
    public function sefDefaults($object): void {
        foreach ($object as $name => $value) {
            if (isset($this->definition[$name])) {
                $definition = $this->definition[$name];
                $this->definition[$name]['value'] = $this->typeHandler($definition['type'], $value);
            }
        }
    }

    /**
     * Получить данные обо всех элементах
     *
     * @return array
     */
    public function extract(): array {
        if ($this->mod === self::MOD_RENDER) return $this->exportForRender();
        if ($this->mod === self::MOD_CHECK) return $this->exportForCheck();
        return [];
    }


}
