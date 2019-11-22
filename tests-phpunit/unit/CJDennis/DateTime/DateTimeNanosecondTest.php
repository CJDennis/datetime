<?php
namespace CJDennis\DateTime;

use PHPUnit\Framework\TestCase;

/**
 * @covers \CJDennis\DateTime\DateTimeNanosecond
 * @uses \CJDennis\DateTime\DateTimeNanosecondInterval
 */
class DateTimeNanosecondTest extends TestCase {
  protected function setUp(): void {
    $this->_before();
  }

  protected function tearDown(): void {
    $this->_after();
  }

  use DateTimeNanosecondTestCommon;
}
