<?php
namespace Source\Helper;

require_once(__DIR__ . "/../Lib/Text.php");

use function Source\Lib\Text\artwooMorphWithSeparator;

function artwooDateToDateTime(string $date): string {
    return \DateTimeImmutable::createFromFormat('Y-m-d', $date)->format('Y-m-d H:i:s');
}

function artwooSimpleDatetimeToHumanDatetime(string $date): string {
    return \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $date)->format('d-m-Y H:i:s');
}

/**
 * Получаем unixtimestamp из формата даты d-m-Y
 *
 * @param string $datetime
 * @return string
 */
function artwooCastToTimestamp(string $datetime): string {
    $extractedtime = \DateTimeImmutable::createFromFormat(FORMAT, $datetime);
    if ($extractedtime) {
        return $extractedtime->format('U');
    }

    return '';
}

/**
 * Возвращаем интервал между двумя датами, которые заданы в формает unix timestamp
 * @todo добавить обратку неверных значений (выбрасывать исключения)
 *
 * @param string $datetimeend
 * @param string $datetimestart
 * @return \DateInterval
 */
function artwooDiffTwoTimestamps(string $datetimeend, string $datetimestart): \DateInterval|false {
    $start = new \DateTimeImmutable($datetimestart);
    $end = new \DateTimeImmutable($datetimeend);
    return $end->diff($start);
}

/**
 * Преобразуем форматы даты Интервал к человекоподобному формату нашего приложения, т.е. указание года и месяца
 * @todo добавить обратку неверных значений (выбрасывать исключения)
 *
 * @param \DateInterval $interval
 * @param string $separator - разделитель
 * @return string
 */
function artwooConvertToHumanDiffDates(
    \DateInterval $interval,
    string $separator = ' ',
    bool $includeMonth = true
): string {
    $result = '';
    if ($interval->y > 0) {
        $years = [__('core.datetime.duration.year_1'), __('core.datetime.duration.year_2'),
            __('core.datetime.duration.year_3')];
        $result .= artwooMorphWithSeparator($interval->y, $years, $separator);
    }

    if ($includeMonth && $interval->m > 0) {
        $months = [__('core.datetime.duration.month_1'), __('core.datetime.duration.month_2'),
            __('core.datetime.duration.month_3')];
        $result .= " " . artwooMorphWithSeparator($interval->m, $months, $separator);
    }

    if (empty($result)) $result = __('core.datetime.duration.less_month');
    return $result;
}

/**
 * Получить человекочитаемый интервал между двумя timestamp's
 * @todo добавить обратку неверных значений (выбрасывать исключения)
 *
 * @param string $datetimeend
 * @param string $datetimestart
 * @param string $separator
 * @return string
 */
function artwooDiffTimestampsToHuman(
    string $datetimeend,
    string $datetimestart,
    string $separator = ' ',
    $includeMonth = true
): string {
    return artwooConvertToHumanDiffDates(
      artwooDiffTwoTimestamps($datetimeend, $datetimestart), $separator, $includeMonth
    );
}

/**
 * Возвращает сумму интервалов
 *
 * @param array $intervals
 *
 * @return \DateInterval|false
 */
function artwooSumIntervals(array $intervals): \DateInterval|false {
    if (empty($intervals)) return false;
    $current = new \DateTime();
    $diff = clone $current;
    foreach ($intervals as $interval) {
        if ($interval instanceof \DateInterval) {
            $current->add($interval);
        }
    }
    return $current->diff($diff);
}

/**
 * Возвращает сумму интервалов для отображения в интерфейсах
 *
 * @param array  $intervals
 * @param string $separator
 * @param bool   $includeMonth
 *
 * @return string
 */
function artwooSumIntervalToHumanFormat(
  array $intervals,
  string $separator = ' ',
  bool $includeMonth = false
): string {
    if ($interval = artwooSumIntervals($intervals))
        return artwooConvertToHumanDiffDates($interval, $separator, $includeMonth);

    return '';
}
