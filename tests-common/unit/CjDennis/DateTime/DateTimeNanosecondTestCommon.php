<?php
/** @noinspection PhpUnused */
namespace CjDennis\DateTime;

use DateTime;

trait DateTimeNanosecondTestCommon {
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

  public function testShouldBeAbleToAccessTheMethodsOfAnUnserialisedDateTimeNanosecondObject() {
    /** @var DateTimeNanosecond $date_time_nanosecond */
    $date_time_nanosecond = unserialize('O:36:"CjDennis\DateTime\DateTimeNanosecond":3:{s:4:"date";s:29:"2021-12-23 23:34:45.123456789";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}');
    $this->assertSame('2021-12-23 23:34:45.123456789', $date_time_nanosecond->format('Y-m-d H:i:s.' . DateTimeNanosecond::FORMAT_NANOSECOND));
  }

  public function testShouldFormatADateTimeNanosecondWithMilliseconds() {
    $date_time_nanosecond = new DateTimeNanosecond('12:34:56.123456789');
    $this->assertSame('56.123456', $date_time_nanosecond->format('s.u'));
  }

  public function testShouldFormatADateTimeNanosecondWithNanoseconds() {
    $date_time_nanosecond = new DateTimeNanosecond('12:34:56.123456789');
    $this->assertSame('56.123456789', $date_time_nanosecond->format('s.' . DateTimeNanosecond::FORMAT_NANOSECOND));
  }

  public function testShouldReturnADateTimeNanosecondIntervalWhenGettingTheDifferenceOfTwoDateTimeNanosecondObjects() {
    $date_time_nanosecond_1 = new DateTimeNanosecond();
    $date_time_nanosecond_2 = new DateTimeNanosecond();
    $this->assertInstanceOf(DateTimeNanosecondInterval::class, $date_time_nanosecond_1->diff($date_time_nanosecond_2));
  }

  public function testShouldGetAOneNanosecondDifference() {
    $date_time_nanosecond_1 = new DateTimeNanosecond('2001-01-01 01:01:01.000000001');
    $date_time_nanosecond_2 = new DateTimeNanosecond('2001-01-01 01:01:01.000000002');
    $date_time_nanosecond_interval = $date_time_nanosecond_1->diff($date_time_nanosecond_2);

    $fully_qualified_name = DateTimeNanosecondInterval::class;
    $len = strlen($fully_qualified_name);
    $s = '0';
    $f = '1.0E-9';
    $invert = '0';
    $this->assertSame('O:' . $len . ':"' . $fully_qualified_name . '":16:{s:1:"y";i:0;s:1:"m";i:0;s:1:"d";i:0;s:1:"h";i:0;s:1:"i";i:0;s:1:"s";i:' . $s . ';s:1:"f";d:' . $f . ';s:7:"weekday";i:0;s:16:"weekday_behavior";i:0;s:17:"first_last_day_of";i:0;s:6:"invert";i:' . $invert . ';s:4:"days";i:0;s:12:"special_type";i:0;s:14:"special_amount";i:0;s:21:"have_weekday_relative";i:0;s:21:"have_special_relative";i:0;}', serialize($date_time_nanosecond_interval));
  }

  public function testShouldGetAnInverseOneNanosecondDifference() {
    $date_time_nanosecond_1 = new DateTimeNanosecond('2001-01-01 01:01:01.000000002');
    $date_time_nanosecond_2 = new DateTimeNanosecond('2001-01-01 01:01:01.000000001');
    $date_time_nanosecond_interval = $date_time_nanosecond_1->diff($date_time_nanosecond_2);

    $fully_qualified_name = DateTimeNanosecondInterval::class;
    $len = strlen($fully_qualified_name);
    $s = '0';
    $f = '1.0E-9';
    $invert = '1';
    $this->assertSame('O:' . $len . ':"' . $fully_qualified_name . '":16:{s:1:"y";i:0;s:1:"m";i:0;s:1:"d";i:0;s:1:"h";i:0;s:1:"i";i:0;s:1:"s";i:' . $s . ';s:1:"f";d:' . $f . ';s:7:"weekday";i:0;s:16:"weekday_behavior";i:0;s:17:"first_last_day_of";i:0;s:6:"invert";i:' . $invert . ';s:4:"days";i:0;s:12:"special_type";i:0;s:14:"special_amount";i:0;s:21:"have_weekday_relative";i:0;s:21:"have_special_relative";i:0;}', serialize($date_time_nanosecond_interval));
  }

  public function testShouldGetTheAbsoluteValueOfAnInverseOneNanosecondDifference() {
    $date_time_nanosecond_1 = new DateTimeNanosecond('2001-01-01 01:01:01.000000002');
    $date_time_nanosecond_2 = new DateTimeNanosecond('2001-01-01 01:01:01.000000001');
    $date_time_nanosecond_interval = $date_time_nanosecond_1->diff($date_time_nanosecond_2, true);

    $fully_qualified_name = DateTimeNanosecondInterval::class;
    $len = strlen($fully_qualified_name);
    $s = '0';
    $f = '1.0E-9';
    $invert = '0';
    $this->assertSame('O:' . $len . ':"' . $fully_qualified_name . '":16:{s:1:"y";i:0;s:1:"m";i:0;s:1:"d";i:0;s:1:"h";i:0;s:1:"i";i:0;s:1:"s";i:' . $s . ';s:1:"f";d:' . $f . ';s:7:"weekday";i:0;s:16:"weekday_behavior";i:0;s:17:"first_last_day_of";i:0;s:6:"invert";i:' . $invert . ';s:4:"days";i:0;s:12:"special_type";i:0;s:14:"special_amount";i:0;s:21:"have_weekday_relative";i:0;s:21:"have_special_relative";i:0;}', serialize($date_time_nanosecond_interval));
  }

  public function testShouldGetAOneSecondOneNanosecondDifference() {
    $date_time_nanosecond_1 = new DateTimeNanosecond('2001-01-01 01:01:01.000000001');
    $date_time_nanosecond_2 = new DateTimeNanosecond('2001-01-01 01:01:02.000000002');
    $date_time_nanosecond_interval = $date_time_nanosecond_1->diff($date_time_nanosecond_2);

    $fully_qualified_name = DateTimeNanosecondInterval::class;
    $len = strlen($fully_qualified_name);
    $s = '1';
    $f = '1.0E-9';
    $invert = '0';
    $this->assertSame('O:' . $len . ':"' . $fully_qualified_name . '":16:{s:1:"y";i:0;s:1:"m";i:0;s:1:"d";i:0;s:1:"h";i:0;s:1:"i";i:0;s:1:"s";i:' . $s . ';s:1:"f";d:' . $f . ';s:7:"weekday";i:0;s:16:"weekday_behavior";i:0;s:17:"first_last_day_of";i:0;s:6:"invert";i:' . $invert . ';s:4:"days";i:0;s:12:"special_type";i:0;s:14:"special_amount";i:0;s:21:"have_weekday_relative";i:0;s:21:"have_special_relative";i:0;}', serialize($date_time_nanosecond_interval));
  }

  public function testShouldGetAOneSecondDifference() {
    $date_time_nanosecond_1 = new DateTimeNanosecond('2001-01-01 01:01:01.000000001');
    $date_time_nanosecond_2 = new DateTimeNanosecond('2001-01-01 01:01:02.000000001');
    $date_time_nanosecond_interval = $date_time_nanosecond_1->diff($date_time_nanosecond_2);

    $fully_qualified_name = DateTimeNanosecondInterval::class;
    $len = strlen($fully_qualified_name);
    $s = '1';
    $f = '0';
    $invert = '0';
    $this->assertSame('O:' . $len . ':"' . $fully_qualified_name . '":16:{s:1:"y";i:0;s:1:"m";i:0;s:1:"d";i:0;s:1:"h";i:0;s:1:"i";i:0;s:1:"s";i:' . $s . ';s:1:"f";d:' . $f . ';s:7:"weekday";i:0;s:16:"weekday_behavior";i:0;s:17:"first_last_day_of";i:0;s:6:"invert";i:' . $invert . ';s:4:"days";i:0;s:12:"special_type";i:0;s:14:"special_amount";i:0;s:21:"have_weekday_relative";i:0;s:21:"have_special_relative";i:0;}', serialize($date_time_nanosecond_interval));
  }

  public function testShouldGetAOneNanosecondLessThanOneSecondDifference() {
    $date_time_nanosecond_1 = new DateTimeNanosecond('2001-01-01 01:01:01.000000002');
    $date_time_nanosecond_2 = new DateTimeNanosecond('2001-01-01 01:01:02.000000001');
    $date_time_nanosecond_interval = $date_time_nanosecond_1->diff($date_time_nanosecond_2);

    $fully_qualified_name = DateTimeNanosecondInterval::class;
    $len = strlen($fully_qualified_name);
    $s = '0';
    $f = '0.999999999';
    $invert = '0';
    $this->assertSame('O:' . $len . ':"' . $fully_qualified_name . '":16:{s:1:"y";i:0;s:1:"m";i:0;s:1:"d";i:0;s:1:"h";i:0;s:1:"i";i:0;s:1:"s";i:' . $s . ';s:1:"f";d:' . $f . ';s:7:"weekday";i:0;s:16:"weekday_behavior";i:0;s:17:"first_last_day_of";i:0;s:6:"invert";i:' . $invert . ';s:4:"days";i:0;s:12:"special_type";i:0;s:14:"special_amount";i:0;s:21:"have_weekday_relative";i:0;s:21:"have_special_relative";i:0;}', serialize($date_time_nanosecond_interval));
  }

  public function testShouldGetAnInverseOneNanosecondLessThanOneSecondDifference() {
    $date_time_nanosecond_1 = new DateTimeNanosecond('2001-01-01 01:01:02.000000001');
    $date_time_nanosecond_2 = new DateTimeNanosecond('2001-01-01 01:01:01.000000002');
    $date_time_nanosecond_interval = $date_time_nanosecond_1->diff($date_time_nanosecond_2);

    $fully_qualified_name = DateTimeNanosecondInterval::class;
    $len = strlen($fully_qualified_name);
    $s = '0';
    $f = '0.999999999';
    $invert = '1';
    $this->assertSame('O:' . $len . ':"' . $fully_qualified_name . '":16:{s:1:"y";i:0;s:1:"m";i:0;s:1:"d";i:0;s:1:"h";i:0;s:1:"i";i:0;s:1:"s";i:' . $s . ';s:1:"f";d:' . $f . ';s:7:"weekday";i:0;s:16:"weekday_behavior";i:0;s:17:"first_last_day_of";i:0;s:6:"invert";i:' . $invert . ';s:4:"days";i:0;s:12:"special_type";i:0;s:14:"special_amount";i:0;s:21:"have_weekday_relative";i:0;s:21:"have_special_relative";i:0;}', serialize($date_time_nanosecond_interval));
  }

  public function testShouldGetAnInverseOneSecondOneNanosecondDifference() {
    $date_time_nanosecond_1 = new DateTimeNanosecond('2001-01-01 01:01:02.000000002');
    $date_time_nanosecond_2 = new DateTimeNanosecond('2001-01-01 01:01:01.000000001');
    $date_time_nanosecond_interval = $date_time_nanosecond_1->diff($date_time_nanosecond_2);

    $fully_qualified_name = DateTimeNanosecondInterval::class;
    $len = strlen($fully_qualified_name);
    $s = '1';
    $f = '1.0E-9';
    $invert = '1';
    $this->assertSame('O:' . $len . ':"' . $fully_qualified_name . '":16:{s:1:"y";i:0;s:1:"m";i:0;s:1:"d";i:0;s:1:"h";i:0;s:1:"i";i:0;s:1:"s";i:' . $s . ';s:1:"f";d:' . $f . ';s:7:"weekday";i:0;s:16:"weekday_behavior";i:0;s:17:"first_last_day_of";i:0;s:6:"invert";i:' . $invert . ';s:4:"days";i:0;s:12:"special_type";i:0;s:14:"special_amount";i:0;s:21:"have_weekday_relative";i:0;s:21:"have_special_relative";i:0;}', serialize($date_time_nanosecond_interval));
  }

  public function testShouldRoundExactlyHalfUpToTheNextWholeNumber() {
    $date_time_nanosecond_seam = new DateTimeNanosecondSeam();
    $this->assertSame(2.0, $date_time_nanosecond_seam->round_seam(1.5));
  }

  public function testShouldRoundBelowHalfDownToTheNextWholeNumber() {
    $date_time_nanosecond_seam = new DateTimeNanosecondSeam();
    $this->assertSame(1.0, $date_time_nanosecond_seam->round_seam(1.499999));
  }

  public function testShouldGetTheNanosecondsFromADateTimeNanosecondObject() {
    $date_time_nanosecond_seam = new DateTimeNanosecondSeam('2021-12-23 23:34:45.123456789');
    $this->assertSame(123456789.0, $date_time_nanosecond_seam->nanoseconds_seam());
  }

  public function testShouldTruncateTheNanosecondsToNineDecimalPlacesWhenCreatingADateTimeNanosecondObject() {
    $date_time_nanosecond_seam = new DateTimeNanosecondSeam('2021-12-23 23:34:45.1234567899');
    $this->assertSame(123456789.0, $date_time_nanosecond_seam->nanoseconds_seam());
  }

  public function testShouldSerialiseAnUnserialisedDateTimeNanosecondObject() {
    $date_time_nanosecond = new DateTimeNanosecond('2021-12-23 23:34:45.123456789');
    $this->assertSame(
      'O:36:"CjDennis\DateTime\DateTimeNanosecond":3:{s:4:"date";s:29:"2021-12-23 23:34:45.123456789";s:13:"timezone_type";i:3;s:8:"timezone";s:3:"UTC";}',
      serialize($date_time_nanosecond)
    );
  }

  public function testShouldReturnAFormattedTimeWithWholeSeconds() {
    $date_time_nanosecond_seam = new DateTimeNanosecondSeam('2021-12-23 23:34:45.1234567899');
    $this->assertSame('2021-12-23 23:34:45 UTC', $date_time_nanosecond_seam->whole_second_date_time_seam());
  }

  public function testShouldRoundANumberDownToThousandMillionths() {
    $date_time_nanosecond_seam = new DateTimeNanosecondSeam();
    $this->assertSame(0.012345678, $date_time_nanosecond_seam->truncate_to_thousand_millionths_seam(0.01234567891));
  }

  public function testShouldRoundANumberUpToThousandMillionths() {
    $date_time_nanosecond_seam = new DateTimeNanosecondSeam();
    $this->assertSame(0.012345679, $date_time_nanosecond_seam->truncate_to_thousand_millionths_seam(0.01234567899));
  }
}
