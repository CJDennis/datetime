<?php
namespace CjDennis\DateTime;

use DateTime;
use DateTimeZone;

class DateTimeNanosecond extends DateTime implements DateTimeNanosecondInterface {
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

    $date_time = new parent($time, $timezone);
    $this->hidden_value($date_time);
    foreach ((array)$date_time as $name => $value) {
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

  public function __wakeup() {
    $date_time_properties = (array)$this;
    $date_time_properties['date'] = preg_replace('/(?<=\d\.\d{6})\d*/', '', $date_time_properties['date']);
    $date_time = parent::__set_state($date_time_properties);
    $this->hidden_value($date_time);
  }

  public function format($format) {
    $format = preg_replace_callback('/\G(?:\\\\[\s\S]|[^\\\\])/u', function ($match) {
      if ($match[0] === static::FORMAT_NANOSECOND) {
        $match[0] = (string)(preg_replace('/^.*(\.\d{1,9})/', '$1', $this->date) * 1000000000);
      }
      return $match[0];
    }, $format);
    $date_time = $this->hidden_value();
    return $date_time->format($format);
  }

  protected function hidden_value() {
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
