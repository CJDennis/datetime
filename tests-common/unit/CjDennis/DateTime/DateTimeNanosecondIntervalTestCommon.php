<?php
/** @noinspection PhpUnused */
namespace CjDennis\DateTime;

use DateInterval;

trait DateTimeNanosecondIntervalTestCommon {
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

  public function testShouldSerialiseAnUnserialisedDateTimeNanosecondIntervalObject() {
    $date_time_nanosecond_interval = new DateTimeNanosecondInterval('P1D');
    $this->assertSame(
      'O:44:"CjDennis\DateTime\DateTimeNanosecondInterval":16:{s:1:"y";i:0;s:1:"m";i:0;s:1:"d";i:1;s:1:"h";i:0;s:1:"i";i:0;s:1:"s";i:0;s:1:"f";d:0;s:7:"weekday";i:0;s:16:"weekday_behavior";i:0;s:17:"first_last_day_of";i:0;s:6:"invert";i:0;s:4:"days";b:0;s:12:"special_type";i:0;s:14:"special_amount";i:0;s:21:"have_weekday_relative";i:0;s:21:"have_special_relative";i:0;}',
      serialize($date_time_nanosecond_interval)
    );
  }

  public function testShouldSetTheStateOfANewDateTimeNanosecondIntervalObject() {
    $this->assertEquals(
      new DateTimeNanosecondInterval('P1D'),
      DateTimeNanosecondInterval::__set_state([
        'y' => 0,
        'm' => 0,
        'd' => 1,
        'h' => 0,
        'i' => 0,
        's' => 0,
        'f' => 0.0,
        'weekday' => 0,
        'weekday_behavior' => 0,
        'first_last_day_of' => 0,
        'invert' => 0,
        'days' => false,
        'special_type' => 0,
        'special_amount' => 0,
        'have_weekday_relative' => 0,
        'have_special_relative' => 0,
      ])
    );
  }
}
