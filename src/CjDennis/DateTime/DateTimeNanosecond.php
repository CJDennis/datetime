<?php
namespace CJDennis\DateTime;

use CJDennis\HiddenValue\HiddenValue;
use DateTime;
use DateTimeZone;

class DateTimeNanosecond extends DateTime implements DateTimeNanosecondInterface {
  use HiddenValue;

  protected const FRACTIONAL_SECONDS_PATTERN = '/(.*)(\d\.(?>\d{1,7})\d*?)(\d{0,3}(?!\d))(.*)/';
  protected const NANOSECONDS = 1000000000;

  public $date;
  public /** @noinspection PhpUnused */
    $timezone_type;
  public /** @noinspection PhpUnused */
    $timezone;

  /** @noinspection PhpMissingParentConstructorInspection */
  public function __construct($time = 'now', DateTimeZone $timezone = null) {
    $match = null;

    $matched = preg_match(static::FRACTIONAL_SECONDS_PATTERN, $time, $match);
    if ($matched) {
      $time = $match[1] . $match[2] . $match[4];
    }

    $this->adopt_parent(...func_get_args());

    if (!$matched) {
      preg_match(static::FRACTIONAL_SECONDS_PATTERN, $this->date, $match);
    }

    $fractional_seconds = $match[2] . $match[3];
    $this->date = sprintf('%s%11.9f%s', $match[1], $this->truncate_to_thousand_millionths($fractional_seconds), $match[4]);
  }

  protected function truncate_to_thousand_millionths(string $fractional_seconds) {
    return $this->round($fractional_seconds, 9, 10);
  }

  protected function round($value, int $new_precision = 0, int $old_precision = null) {
    $old_precision = $old_precision ?? $new_precision;
    $rounded_to_old_precision_int = round($value * pow(10, $old_precision));
    $floored_to_new_precision_int = floor($rounded_to_old_precision_int * pow(10, $new_precision - $old_precision));
    return $floored_to_new_precision_int / pow(10, $new_precision);
  }

  public function __wakeup() {
    $date_time_properties = (array)$this;
    $date_time_properties['date'] = preg_replace('/(?<=\d\.\d{6})\d*/', '', $date_time_properties['date']);
    $date_time = parent::__set_state($date_time_properties);
    $this->hidden_value(null, $date_time);
  }

  public function format($format) {
    $format = preg_replace_callback('/\G(?:\\\\[\s\S]|[^\\\\])/u', function ($match) {
      if ($match[0] === static::FORMAT_NANOSECOND) {
        $match[0] = $this->nanoseconds();
      }
      return $match[0];
    }, $format);
    /** @var parent $date_time */
    /** @var DateTime $date_time */
    $date_time = $this->hidden_value();
    return $date_time->format($format);
  }

  public function diff($datetime2, $absolute = false) {
    $nano_1 = $this->nanoseconds();
    /** @var DateTimeNanosecond $datetime2 */
    $nano_2 = $datetime2->nanoseconds();
    $nano_diff = $nano_2 - $nano_1;

    /** @noinspection PhpUnhandledExceptionInspection */
    $this_date = new DateTime($this->whole_second_date_time());
    /** @noinspection PhpUnhandledExceptionInspection */
    $other_date = new DateTime($datetime2->whole_second_date_time());
    $invert_result = null;
    if ($nano_diff < 0) {
      if ($this_date < $other_date) {
        $this_date->modify('+1 second');
        $nano_diff += static::NANOSECONDS;
      }
      else {
        $nano_diff = -$nano_diff;
        if ($this_date == $other_date) {
          $invert_result = 1;
        }
      }
    }
    elseif ($this_date > $other_date) {
      $other_date->modify('+1 second');
      $nano_diff = static::NANOSECONDS - $nano_diff;
      $invert_result = 1;
    }
    $date_interval = $this_date->diff($other_date, $absolute);

    /** @var DateTimeNanosecondInterval $date_time_nanosecond_interval */
    $date_time_nanosecond_interval = DateTimeNanosecondInterval::__set_state($date_interval);
    $date_time_nanosecond_interval->f = $nano_diff / static::NANOSECONDS;
    if ($invert_result !== null && !$absolute) {
      $date_time_nanosecond_interval->invert = $invert_result;
    }

    return $date_time_nanosecond_interval;
  }

  protected function nanoseconds() {
    return preg_replace('/^.*(\.\d{1,9})/', '$1', $this->date) * static::NANOSECONDS;
  }

  protected function whole_second_date_time() {
    return preg_replace('/^(.*)\.\d{1,9}/', '$1', $this->date) . " {$this->timezone}";
  }
}
