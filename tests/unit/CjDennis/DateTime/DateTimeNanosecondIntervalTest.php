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
}
