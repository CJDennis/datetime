<?php
namespace CjDennis\DateTime;

use PHPUnit\Framework\TestCase;

/** @covers \CjDennis\DateTime\AdoptedParent */
class AdoptedParentTest extends TestCase {
  protected function setUp(): void {
    $this->_before();
  }

  protected function tearDown(): void {
    $this->_after();
  }

  use AdoptedParentTestCommon;
}
