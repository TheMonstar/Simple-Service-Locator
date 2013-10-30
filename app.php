<?php
/**
 * app.php
 *
 * @author Vitaly Korzh <vitalykorzh@gmail.com>
 * @version 1.0 2013-09-26
 */

/**
 * needs to load our configs
 */
require_once realpath(dirname(__FILE__)) . '/config.php';

class App
{
    /**
     * handle config data
     * @var array
     */
    protected static $config;
    /**
     * list of imported classes
     * @var array
     */
    protected static $imported;
    /**
     * list of services
     * @var array
     */
    protected static $service;

    /**
     * Singltone handler
     * @var App
     */
    protected static $inst;

    /**
     * @param $config
     */
    public static function loadConfig($config)
    {
        self::$config = $config;
    }

    /**
     *
     * @param $path
     *
     * @return bool|mixed - importer file name
     */
    public static function import($path)
    {
        if(isset(self::$imported[$path])) return self::$imported[$path];
        $class = end(explode('.', $path));
        $path = self::basePath().'/'.str_replace('.','/',$path);
        if(!file_exists($path.'.php')) return false;
        require_once $path.'.php';
        return self::$imported[$path] = $class;
    }

    /**
     * Singletone
     * @return App
     */
    public static function inst()
    {
        if(!self::$inst)
            self::$inst = new self;
        return self::$inst;
    }

    /**
     * Manage ours services
     * or return config params if there is no class registered
     * @param $name
     *
     * @return stdClass
     */
    public function __get($name)
    {
        $autostart = $class = null;
        /**
         * if already exists
         */
        if(isset(self::$service[$name]))
            return self::$service[$name];

        /**
         * loads class from path
         */
        if (isset(self::$config[$name]) && isset(self::$config[$name]['class'])) {
            if(!$class = self::import(self::$config[$name]['class'])) {
                if(class_exists(self::$config[$name]['class'])) $class = self::$config[$name]['class'];
            }
        }
        /**
         * params for constructor
         */
        if(isset(self::$config[$name]['_construct'])) {
            $autostart = (array)self::$config[$name]['_construct'];
        }
        if($class && class_exists($class)) {
            if($autostart) {
                $t = new ReflectionClass($class);
                $object = $t->newInstanceArgs($autostart);
            }
            else
                $object = new $class;
        } elseif(class_exists($name)) {
            if($autostart) {
                $t = new ReflectionClass($name);
                $object = $t->newInstanceArgs($autostart);
            }
            else
                $object = new $name;
        } elseif (isset(self::$config[$name])) {
            return self::$config[$name];
        } else {
            return false;
        }
        if(isset(self::$config[$name]) && is_array(self::$config[$name])) {
            /** Yii based service locator */
            foreach(self::$config[$name] as $key => $val) {
                $fn = 'set'.$key;
                if(is_string($val) and $val[0]=='@') {
                    $val = $this->__get(substr($val,1));
                }
                if(method_exists($object, $fn))
                    $object->$fn($val);
                else
                    $object->$key = $val;
            }
        }
        return self::$service[$name] = $object;
    }

    /**
     * to know where we placed
     * @return string
     */
    public function basePath()
    {
        return __DIR__;
    }

    protected function __construct(){}
    protected function __clone(){}
}

App::loadConfig($config);