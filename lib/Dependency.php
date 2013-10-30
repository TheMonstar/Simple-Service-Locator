<?php
/**
 * Dependency.php
 *
 * @author Vitaly Korzh <vitalykorzh@gmail.com>
 * @version 1.0 2013-10-30
 */

class Dependency {

    public $c;
    public function __construct($a)
    {
        $this->a = $a;
    }

    public function setB($b)
    {
        $this->b = $b;
    }
}