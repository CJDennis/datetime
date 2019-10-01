<?php
namespace CjDennis\DateTime;

trait AdoptedParent {
  /** @noinspection PhpUnused */
  /**
   * @param null $func_get_args Call `$this->adopt_parent(...func_get_args());` from __construct().
   * @throws \ReflectionException
   */
  protected function adopt_parent($func_get_args = null) {
    $parent = new parent(...func_get_args());
    $this->hidden_value(null, $parent);

    foreach ($parent as $name => $value) {
      $this->$name = $value;
    }

    $reflection_class = new \ReflectionClass($parent);
    $reflection_properties = $reflection_class->getProperties();
    foreach ($reflection_properties as $reflection_property) {
      $reflection_property->setAccessible(true);
      $name = $reflection_property->getName();
      $value = $reflection_property->getValue($parent);
      $this->$name = $value;
    }
  }
}
