<?php
/**
 * The Wild West FrameWork
 * @copyright 2015
 *
 */

 /**
 * Define environment, are we local vagrant, development or production?
 */
define('WILD_WEST_ENV', 'DEVELOPMENT');
define('APP_NAME','WILDWEST');

 /**
 * Trait DBConfig
 */
trait DBConfig{


    /**
     * @return string
     */
    public function thehost(){
        return "127.0.0.1";
    }
 
    /**
     * @return string
     */
    public function theuser(){
        return "root";
    }
   

    /**
     * @return string
     */
    public function thepass(){
        return "CHANGEME";
    }

    /**
     * @return string
     */
    public function thedbname(){
        return "wildwest";
    }

    /**
     * @param $drivertype
     * @return int|string
     */
    public function thedsn($drivertype){
        switch($drivertype){
            case "mysql":
                $dsn = "mysql:host=".self::thehost().";dbname=".self::thedbname().";port=3306";
                return ($dsn);
                break;
            case "pgsql":
                $dsn = "pgsql:host=".self::thehost().";dbname=".self::thedbname().";port=5432";
                return ($dsn);
                break;
            case "mssql":
                $dsn = "dblib:host=".self::thehost().";dbname=".self::thedbname().";port=1433";
                return ($dsn);
                break;
            case "mongodb":
                $dsn = "NOT";
                return($dsn);
            default:
                return 3306;
        }
    }

    public function SessionConnect(){
        return(mysqli_connect(self::thehost(),self::theuser(),self::thepass(),self::thedbname(),3306));
    }


}

/**
 * Trait GeneralConfig
 */
trait GeneralConfig{
    
        /**
     * @return string
     */
    public function log_path(){
        return(dirname( __FILE__ ) . '/../logs/');
    }
    
    /**
     * @return string
     */
    public function get_env(){
        return(WILD_WEST_ENV);
    }

    /**
     * @return string
     */
    public function mycli(){
        return('/usr/bin/mysql');
    }

    public function redirectToHome(){
        return(header("Location: /"));
    }

    public function destroySession(){
        return(session_destroy());
    }

    public function startSession(){
        return(session_start());
    }

    public function setSessionVar($var,$value){
        return($_SESSION["$var"] = "$value");
    }

    public function getSessionVar($varname){
        return($_SESSION["$varname"]);
    }

    /**
     * @return string
     */
    public static function model_path(){
        return(__DIR__.'/../models');
    }

    /**
     * @return string
     */
    public static function controller_path(){
        return(__DIR__.'/../controllers');
    }

    /**
     * @return string
     */
    public static function lib_path(){
        return(__DIR__.'/../lib');
    }

    /**
     * @return string
     */
    public static function vendor_path(){
        return(__DIR__.'/../vendor');
    }

    /**
     * @return string
     */
    public static function view_path(){
        return(__DIR__.'/../views');
    }

    /**
     * @return string
     */
    public static function webview_path(){
        return(__DIR__.'/../webroot');
    }

}

/**
 * Trait MemcacheConfig
 */
trait MemcacheConfig{

    /**
     * @return array
     */
    public function memcache_server_list(){
        $servers = array('localhost:11211','127.0.0.1:11211');
        return ($servers);
    }

    /**
     * @return string
     */
    public function memcache_prefix(){
        return(APP_NAME);
    }

    /**
     * @return string
     */
    public function field_prefix(){
    return(APP_NAME._FIELD_);
    }

    /**
     * @return string
     */
    public function table_prefix(){
        return(APP_NAME._TABLE_);
    }


}
