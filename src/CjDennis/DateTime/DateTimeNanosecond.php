<?php
namespace CjDennis\DateTime;

use DateTime;
use DateTimeZone;

class DateTimeNanosecond extends DateTime {
  public $date;
  public /** @noinspection PhpUnused */
    $timezone_type;
  public /** @noinspection PhpUnused */
    $timezone;

  /** @noinspection PhpMissingParentConstructorInspection */
  public function __construct($time = 'now', DateTimeZone $timezone = null) {
    static $fractional_seconds_pattern = '/(.*)(\d\.(?>\d{1,7})\d*?)(\d{0,3}(?!\d))(.*)/';
    $match = null;

    $matched = preg_match($fractional_seconds_pattern, $time, $match);
    if ($matched) {
      $time = $match[1] . $match[2] . $match[4];
      $fractional_seconds = (float)($match[2] . $match[3]);
    }

    $date = new parent($time, $timezone);
    $this->hidden_value($date);
    foreach ((array)$date as $name => $value) {
      $this->$name = $value;
    }

    if (!$matched) {
      preg_match($fractional_seconds_pattern, $this->date, $match);
      $fractional_seconds = (float)($match[2] . $match[3]);
    }
    $this->date = sprintf('%s%11.9f%s', $match[1], $this->round($fractional_seconds, 10, 9), $match[4]);
  }

  protected function round($value, int $old_precision = 0, int $new_precision = 0) {
    return floor(round($value * pow(10, $old_precision)) / pow(10, $old_precision - $new_precision)) / pow(10, $new_precision);
  }

  public function hidden_value() {
    static $keys = [];
    static $values = [];

    $key = array_search($this, $keys, true);
    $value = null;
    if (func_num_args() === 0) {
      if ($key !== false) {
        $value = $values[$key];
      }
    }
    else {
      $value = func_get_arg(0);
      if ($key !== false) {
        $values[$key] = func_get_arg(0);
      }
      else {
        $keys[] = $this;
        $values[] = $value;
      }
    }
    return $value;
  }
}
