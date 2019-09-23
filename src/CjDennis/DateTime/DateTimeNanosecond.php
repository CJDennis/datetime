<?php
namespace CjDennis\DateTime;

use CjDennis\HiddenValue\HiddenValue;
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

    $date_time = new parent($time, $timezone);
    $this->hidden_value(null, $date_time);
    foreach ((array)$date_time as $name => $value) {
      $this->$name = $value;
    }

    if (!$matched) {
      preg_match(static::FRACTIONAL_SECONDS_PATTERN, $this->date, $match);
    }

    $fractional_seconds = (float)($match[2] . $match[3]);
    $this->date = sprintf('%s%11.9f%s', $match[1], $this->round($fractional_seconds, 10, 9), $match[4]);
  }

  protected function round($value, int $old_precision = 0, int $new_precision = 0) {
    return floor(round($value * pow(10, $old_precision)) / pow(10, $old_precision - $new_precision)) / pow(10, $new_precision);
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
        $match[0] = (string)$this->nanoseconds();
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
    $invert_result = false;
    if ($this_date < $other_date) {
      ;
    }
    elseif ($this_date > $other_date) {
      ;
    }
    else {
      if ($nano_diff < 0) {
        $nano_diff = -$nano_diff;
        $invert_result = true;
      }
    }
    $date_interval = $this_date->diff($other_date);

    $date_interval_properties = (array)$date_interval;
    /** @var DateTimeNanosecondInterval $date_time_nanosecond_interval */
    $date_time_nanosecond_interval = DateTimeNanosecondInterval::__set_state($date_interval_properties);
    $date_time_nanosecond_interval->f = $nano_diff / static::NANOSECONDS;
    if ($invert_result) {
      $date_time_nanosecond_interval->invert = 1;
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
