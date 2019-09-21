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
    $date = new parent($time, $timezone);
    $this->hidden_value($date);
    foreach ((array)$date as $name => $value) {
      $this->$name = $value;
    }
    $this->date .= '000';
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
