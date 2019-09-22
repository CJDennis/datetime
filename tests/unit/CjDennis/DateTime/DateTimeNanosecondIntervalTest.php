<?php
namespace CjDennis\DateTime;

use Codeception\Test\Unit;
use DateInterval;
use UnitTester;

class DateTimeNanosecondIntervalTest extends Unit {
  /**
   * @var UnitTester
   */
  protected $tester;

  protected function _before() {
  }

  protected function _after() {
  }

  // tests
  public function testShouldCheckThatADateTimeNanosecondIntervalIsAnInstanceOfDateInterval() {
    $this->assertInstanceOf(DateInterval::class, new DateTimeNanosecondInterval('P1D'));
  }

  public function testShouldCheckThatFractionalSecondsCanContainUpToNineDecimalPlaces() {
    $date_time_nanosecond_interval = new DateTimeNanosecondInterval('P1D');
    $date_time_nanosecond_interval->f = 0.123456789;
    $this->assertSame(0.123456789, $date_time_nanosecond_interval->f);
  }
}
