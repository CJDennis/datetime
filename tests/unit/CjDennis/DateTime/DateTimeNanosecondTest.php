<?php
namespace CjDennis\DateTime;

use Codeception\Test\Unit;
use DateTime;
use UnitTester;

class DateTimeNanosecondTest extends Unit {
  /**
   * @var UnitTester
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

  public function testShouldExtendMicrosecondsToNanoseconds() {
    $this->assertSame('UTC', date_default_timezone_get());
    $date_time_nanosecond = new DateTimeNanosecond('2021-12-23 23:34:45.123456');
    $this->assertSame(
      'O:36:"CjDennis\DateTime\DateTimeNanosecond":3:{s:4:"date";s:29:"2021-12-23 23:34:45.123456000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}',
      serialize($date_time_nanosecond)
    );
  }

  public function testShouldCreateADateTimeNanosecondObjectWithNanosecondsSpecified() {
    $this->assertSame('UTC', date_default_timezone_get());
    $date_time_nanosecond = new DateTimeNanosecond('2021-12-23 23:34:45.123456789');
    $this->assertSame(
      'O:36:"CjDennis\DateTime\DateTimeNanosecond":3:{s:4:"date";s:29:"2021-12-23 23:34:45.123456789";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}',
      serialize($date_time_nanosecond)
    );
  }
}
