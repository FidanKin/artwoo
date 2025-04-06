<?php

namespace Source\Entity\Artwork\Dictionaries;

use Source\Lib\DTO\ArtworkColorDTO;

enum Colors: string
{
    case Red = 'red';
    case Orange = 'orange';
    case Yellow = 'yellow';
    case Green = 'green';
    case Blue = 'blue';
    case Purple = 'purple';
    case BlackWhite = 'black_white';
    case Brown = 'brown';
    case Gray = 'gray';
    case Pink = 'pink';
    case None = 'none';

    /**
     * получаем список в формате [code => ArtworkColorDTO]
     *
     * @return array
     */
    public static function selectColors(): array
    {
        $colors = [];

        foreach (Colors::cases() as $color) {
            $value = $color->value;
            $colors[$value] = __("artwork.colors.$value");
        }

        return $colors;
    }

    /**
     * Получить объект цвета по его коду
     *
     * @return ArtworkColorDTO
     */
    public function getColor(): ArtworkColorDTO
    {
        $all = Colors::selectColors();
        return $all[$this->value];
    }

    /**
     * Список кода и соответствие его цвету
     *
     * @return array
     */
    private static function listCssColors(): array
    {
        return [
            'red' => 'rgb(187, 57, 45)',
            'orange' => 'rgb(234, 107, 31)',
            'yellow' => 'rgb(226, 185, 41)',
            'green' => 'rgb(0, 103, 74)',
            'blue' => 'rgb(10, 26, 180)',
            'purple' => 'rgb(160, 32, 240)',
            'black_white' => '-',
            'brown' => 'rgb(123, 89, 39)',
            'gray' => 'rgb(194, 194, 194)',
            'pink' => 'rgb(225, 173, 205)',
            'none' => '-'
        ];
    }
}
