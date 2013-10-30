<?php
/**
 * Simple configuration file
 * config.php
 *
 * @author Vitaly Korzh <vitalykorzh@gmail.com>
 * @version 1.0 2013-09-25
 */

$config = array(
    'Dep' => array(
        'class' => 'lib.Dependency',
        'c' => 'C',
        'b' => 'B',
        '_construct'=>'A'
    ),
    /**
     * can be used like this (->Test)
     */
    'Test' => array(
        'class' => 'lib.Test',
        '_construct'=>array('A','B'),
        'c'=>'@Dep'
    ),
    /**
     * or like that (->TestNew)
     */
    'TestNew' => array(
        'class' => 'lib.Test',
        '_construct'=>array('D','F'),
    ),
);