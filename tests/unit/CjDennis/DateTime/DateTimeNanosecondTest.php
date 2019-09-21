<?php
namespace CjDennis\DateTime;

use Codeception\Test\Unit;
use DateTime;

class DateTimeNanosecondTest extends Unit {
  /**
   * @var \UnitTester
   */
  protected $tester;

  protected function _before() {
  }

  protected function _after() {
  }

  // tests
  public function testShouldReturnAnInstanceOfDateTime() {
    $date_time_nanosecond = new DateTimeNanosecond();
    $this->assertInstanceOf(DateTime::class, $date_time_nanosecond);
  }
}
