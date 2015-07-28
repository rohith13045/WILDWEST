<?php
/**
 * The Wild West FrameWork
 * @copyright 2015
 *
 *
 *

 * Class TheWildWest
 */
class TheWildWest{
    /**
     * Use trait GeneralConfig;
     */
    Use GeneralConfig;


    /**
     * @return string
     */
    public static function init(){
        /**
         * this is redundant and can be replaced, else you can customize how you see fit.
         * 
         */
        
        /* cheap concat php.ini settings*/
        return(
        ini_set( 'include_path','
        .:'.__DIR__.'/../vendor/twig/twig/lib.:
        .:'.__DIR__.'/../vendor/smarty/smarty/libs.:
        .:'.__DIR__.'/../vendor/zend/gdata/library.:
        .:'.__DIR__.'/../vendor/codeception/codeception/src.:
        .:'.__DIR__.'/../lib.:
        ')
               /* manual error reporting override */
        .     error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING)
        .     ini_set("memory_limit", "512M")
        .     session_start()
        );

    }





}


/**
 * Class Load
 */
class Load{
    /**
     * Use trait GeneralConfig;
     */
    Use GeneralConfig;

    /**
     * @param $model
     * @return mixed
     */
    public static function model($model){
        $model_dir = self::model_path();

        try {
            if (is_readable('' . $model_dir . '/' . $model . '.model.php')) {
                return (require_once($model_dir . '/' . $model . '.model.php'));
            } else {
                throw new Exception("Unable to read model file", 301);
            }
        }catch (Exception $e){
            $l = new Logger();
            $l->logit('Caught exception: '.  $e->getMessage(). '<br>Code returned: ' .$e->getCode() . '<br>'.$e->getTrace().'');
            exit;
        }
    }


    /**
     * @param $controller
     * @return mixed
     */
    public static function controller($controller){
        $controller_dir = self::controller_path();

        try {
            if (is_readable($controller_dir.'/'.$controller.'.controller.php')) {
                return (require_once($controller_dir.'/'.$controller.'.controller.php'));
            } else {
                throw new Exception("Unable to read controller file", 301);
            }
        }catch(Exception $e){
             $l = new Logger();
             $l->logit('Caught exception: '.  $e->getMessage(). '<br>Code returned: ' .$e->getCode() . '<br>'.$e->getTrace().'');
            exit;
        }
    }

    /**
     * @param $library
     * @return mixed
     */
    public static function library($library){
        $library_dir = self::lib_path();

        try {
            if (is_readable($library_dir.'/'.$library.'.class.php')) {
                return (require_once($library_dir.'/'.$library.'.class.php'));
            } else {
                throw new Exception("Unable to read library file", 301);

            }
        }catch(Exception $e){
            $l = new Logger();
            $l->logit('Caught exception: '.  $e->getMessage(). '<br>Code returned: ' .$e->getCode() . '<br>'.$e->getTrace().'');
            exit;
        }
    }

    /**
     * @param $vendor_plugin
     * @return mixed
     */
    public static function vendor_plugin($vendor_plugin){
        $vendor_dir = self::vendor_path();

        try {
            if (is_readable($vendor_dir.'/'.$vendor_plugin.'')) {
                return (require_once($vendor_dir.'/'.$vendor_plugin.''));
            } else {
                throw new Exception("Unable to read library file", 301);
            }
        }catch(Exception $e){
            $l = new Logger();
            $l->logit('Caught exception: '.  $e->getMessage(). '<br>Code returned: ' .$e->getCode() . '<br>'.$e->getTrace().'');
            exit;
        }
    }
}

