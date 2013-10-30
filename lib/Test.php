<?php
/**
 * Test.php
 *
 * @author Vitaly Korzh <vitalykorzh@gmail.com>
 * @version 1.0 2013-10-30
 */

class Test {

    public $c;
    public function __construct($a, $b)
    {
        $this->a = $a;
        $this->b = $b;
    }

    public function run()
    {
        var_dump($this);
    }
}