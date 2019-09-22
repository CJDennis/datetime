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
    date_default_timezone_set('UTC');
  }

  protected function _after() {
  }

  // tests
  public function testShouldReturnAnInstanceOfDateTime() {
    $date_time_nanosecond = new DateTimeNanosecond();
    $this->assertInstanceOf(DateTime::class, $date_time_nanosecond);
  }

  public function testShouldExtendMicrosecondsToNanoseconds() {
    $date_time_nanosecond = new DateTimeNanosecond('2021-12-23 23:34:45.123456');
    $this->assertSame(
      'O:36:"CjDennis\DateTime\DateTimeNanosecond":3:{s:4:"date";s:29:"2021-12-23 23:34:45.123456000";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}',
      serialize($date_time_nanosecond)
    );
  }

  public function testShouldCreateADateTimeNanosecondObjectWithNanosecondsSpecified() {
    $date_time_nanosecond = new DateTimeNanosecond('2021-12-23 23:34:45.123456789');
    $this->assertSame(
      'O:36:"CjDennis\DateTime\DateTimeNanosecond":3:{s:4:"date";s:29:"2021-12-23 23:34:45.123456789";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}',
      serialize($date_time_nanosecond)
    );
  }

  public function testShouldUseTheCorrectFormatWhenCreatingADateTimeNanosecondObjectAutomatically() {
    $date_time_nanosecond = new DateTimeNanosecond('now');
    $this->assertRegExp('/^\d{4}-\d\d-\d\d \d\d:\d\d:\d\d\.\d{9}$/', ((array)$date_time_nanosecond)['date']);
  }

  public function testShouldTruncateToNineDecimalPlacesWhenASingleExtraDigitIsSupplied() {
    $date_time_nanosecond = new DateTimeNanosecond('2021-12-23 23:34:45.0123456789');
    $this->assertSame('2021-12-23 23:34:45.012345678', ((array)$date_time_nanosecond)['date']);
  }

  public function testShouldUnserialiseASerialisedDateTimeNanosecondObject() {
    $this->assertSame(
      '2021-12-23 23:34:45.123456789',
      ((array)unserialize('O:36:"CjDennis\DateTime\DateTimeNanosecond":3:{s:4:"date";s:29:"2021-12-23 23:34:45.123456789";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}'))['date']
    );
  }

  public function testShouldFormatADateTimeNanosecondWithMilliseconds() {
    $date_time_nanosecond = new DateTimeNanosecond('12:34:56.123456789');
    $this->assertSame('56.123456', $date_time_nanosecond->format('s.u'));
  }
}
