<?php
namespace CjDennis\DateTime;

use DateInterval;

class DateTimeNanosecondInterval extends DateInterval {
  public $f;

  public function __construct($interval_spec) {
  }
}
