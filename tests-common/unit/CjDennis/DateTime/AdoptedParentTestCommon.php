<?php
namespace CjDennis\DateTime;

trait AdoptedParentTestCommon {
  protected function _before() {
  }

  protected function _after() {
  }

  // tests
  public function testShouldCopyThePropertiesOfAParentIntoItsChildClass() {
    $extended_example_child = new ExtendedExampleChild();
    $this->assertSame(
      "O:38:\"CjDennis\\DateTime\\ExtendedExampleChild\":4:{s:1:\"a\";i:1;s:4:\"\x00*\x00b\";i:2;s:33:\"\x00CjDennis\\DateTime\\ExampleChild\x00c\";i:3;s:34:\"\x00CjDennis\\DateTime\\ExampleParent\x00c\";i:3;}",
      serialize($extended_example_child)
    );
  }
}
