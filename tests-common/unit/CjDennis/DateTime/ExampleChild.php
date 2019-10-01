<?php
namespace CjDennis\DateTime;

use CjDennis\HiddenValue\HiddenValue;

class ExampleChild extends ExampleParent {
  use HiddenValue;
  use AdoptedParent;

  public $a;
  protected $b;
  private $c;

  public function __construct() {
    /** @noinspection PhpUnhandledExceptionInspection */
    $this->adopt_parent(...func_get_args());
  }
}
