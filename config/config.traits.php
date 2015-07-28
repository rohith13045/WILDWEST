<?php
/**
 * The Wild West FrameWork
 * @copyright 2015
 *
 *
 * Trait DBConfig
 */
trait DBConfig{

   /* DB_HOST is inherited from cake factory config.php */
    /**
     * @return string
     */
    public function thehost(){
        return WW_HOST;
    }
    /* DB_LOG is inherited from cake factory config.php */
    /**
     * @return string
     */
    public function theuser(){
        return WW_LOGIN;
    }
    /* DB_PSDD is inherited from cake factory config.php */

    /**
     * @return string
     */
    public function thepass(){
        return WW_PASS;
    }
    /* DB_DB is inherited from cake factory config.php */
    /**
     * @return string
     */
    public function thedbname(){
        return WW_DB;
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


}

/**
 * Trait GeneralConfig
 */
trait GeneralConfig{
    /**
     * @return string
     */
    public function get_env(){
        return(ENV);
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
        return(CACHE_PREFIX);
    }

    /**
     * @return string
     */
    public function field_prefix(){
    return(FIELD_PREFIX);
    }

    /**
     * @return string
     */
    public function table_prefix(){
        return(TABLE_PREFIX);
    }


}
