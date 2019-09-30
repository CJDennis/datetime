<?php
namespace CjDennis\DateTime;

use DateInterval;

trait DateTimeNanosecondIntervalTestCommon {
  public function testShouldCheckThatADateTimeNanosecondIntervalIsAnInstanceOfDateInterval() {
    $this->assertInstanceOf(DateInterval::class, new DateTimeNanosecondInterval('P1D'));
  }

  public function testShouldCheckThatFractionalSecondsCanContainUpToNineDecimalPlaces() {
    $date_time_nanosecond_interval = new DateTimeNanosecondInterval('P1D');
    $date_time_nanosecond_interval->f = 0.123456789;
    $this->assertSame(0.123456789, $date_time_nanosecond_interval->f);
  }
}
