<?php /** @noinspection PhpUnused */
namespace CjDennis\DateTime;

use CjDennis\HiddenValue\HiddenValue;
use DateInterval;

class DateTimeNanosecondInterval extends DateInterval {
  use HiddenValue;

  public $y;  // year
  public $m;  // month
  public $d;  // day
  public $h;  // hour
  public $i;  // minute
  public $s;  // second
  public $f;  // fractional second

  public $weekday;
  public $weekday_behavior;
  public $first_last_day_of;

  public $invert;
  public $days;

  public $special_type;
  public $special_amount;
  public $have_weekday_relative;
  public $have_special_relative;

  /** @noinspection PhpMissingParentConstructorInspection */
  public function __construct($interval_spec) {
    $date_interval = new parent($interval_spec);
    $this->hidden_value(null, $date_interval);
    foreach ((array)$date_interval as $name => $value) {
      $this->$name = $value;
    }
  }

  public static function __set_state($properties) {
    $date_time_nanosecond_interval = new static('P0D');
    foreach ($properties as $name => $value) {
      $date_time_nanosecond_interval->$name = $value;
    }
    return $date_time_nanosecond_interval;
  }
}
