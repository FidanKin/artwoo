<?php

namespace Source\Lib\Text;

/**
 * Склонение слова в зависимости от числа
 *
 * @param  int  $value - количество
 * @param  array  $words - слова, идущие в порядке, в котором происходит изменение окончания. Только 3 элемента!!!
 * @return string - слово
 */
function artwooMorph(int $value, array $words): string
{
    //Случаи - какое склонение использовать, в зависимости от последней цифры числа
    // 0 - 3 склонение
    // 1 - 1 склонение
    // 2 - 2 склонение
    // 3 - 3 склонение
    // 4 - 2 склонение
    // От 5 до 9 - всегда 3 склонение
    $cases = [2, 0, 1, 1, 1, 2];

    //Для чисел, заканчивающихся от 5 до 19 - всегда 3 склонение
    return $words[($value % 100 > 4 && $value % 100 < 20) ? 2 : $cases[min($value % 10, 5)]];
}

/**
 * Возвращаем слово с указанным числом и разделителем (пробел по умолчанию)
 *
 * @param  int  $value - число элемента
 * @param  array  $words - слова (только 3!!!)
 * @param $separator - разделитель
 * @return string - слово с числом и разделителем
 */
function artwooMorphWithSeparator(int $value, array $words, string $separator = ' '): string
{
    $word = artwooMorph($value, $words);

    return "{$value}{$separator}{$word}";
}

/**
 * Сократить текст до указанной длины и в конце приписать троеточие
 */
function artwooShortText(string $text, int $len = 32): string
{
    return mb_strlen($text) <= $len ? $text : mb_substr($text, 0, $len - 4).' ...';
}
