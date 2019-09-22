<?php
namespace CjDennis\DateTime;

use DateInterval;

class DateTimeNanosecondInterval extends DateInterval {
  public function __construct($interval_spec) {
    parent::__construct($interval_spec);
  }
}
