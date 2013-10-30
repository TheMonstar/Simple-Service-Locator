<?php

/**
 * the only string to start our application
 */
require_once 'app.php';

/*
 * You can skip this line if declares path to file in config
 */
app::import('lib.Test');

/**
 * runs our service
 */
app::inst()->Test->run();