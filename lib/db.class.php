<?php
/**
 * The Wild West FrameWork
 * @copyright 2015
 *
 * Class MasterDb
 */
class MasterDb extends PDO {
    /**
     * @var string
     */
    private $error;

    /**
     * @var
     */
    private $sql;

    /**
     * @var
     */
    private $bind;

    /**
     * @var
     */
    private $errorCallbackFunction;

    /**
     * @var
     */
    private $msg;

    /**
     * @param $dsn
     * @param string $user
     * @param string $passwd
     */
    public function __construct($dsn, $user = "", $passwd = "") {
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            parent::__construct($dsn, $user, $passwd, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    /**
     * @method debug
     */
    public function debug() {
        $this->msg = "";

        if(!empty($this->errorCallbackFunction)) {

            $error = array("Error" => $this->error);

            if(!empty($this->sql)) {
                $error["SQL Statement"] = $this->sql;
            }

            if(!empty($this->bind)) {
                $error["Bind Parameters"] = trim(print_r($this->bind, true));
            }
            $backtrace = debug_backtrace();
            if(!empty($backtrace)) {
                foreach($backtrace as $info) {
                    if($info["file"] != __FILE__)
                        $error["Backtrace"] = $info["file"] . " at line " . $info["line"];
                }
            }



                if(!empty($error["Bind Parameters"])) {
                    $error["Bind Parameters"] = "" . $error["Bind Parameters"] . "";
                    $this->msg .= "\t\tSQL Error";
                    foreach ($error as $key => $val) {
                        $this->msg .= "\t" . $key . " - " . $val;
                        $this->msg .= "\n\t";
                    }
                }


            $func = $this->errorCallbackFunction;
            $func($this->msg);
        }
    }


    /**
     * @param $conn
     * @return null
     */
    public function close($conn){
        unset($conn);
        return(NULL);
    }


    /**
     * @return array
     */
    public function get_drivers(){
        $driver_avail = parent::getAvailableDrivers();
        return($driver_avail);
    }


    /**
     * @param $query
     * @return mixed
     */
    public function query_single($query){
        $q = parent::query("$query");
        $e  = $q->fetch(PDO::FETCH_ASSOC);
        return($e);
    }

    /**
     * @param $query
     * @return array
     */
    public function query_all($query){
        $q = parent::query($query);
        $e = $q->fetchAll(PDO::FETCH_BOTH);
        return($e);
    }

    /**
     * @param $query
     * @return array
     */
    public function query_obj($query){
        $q = parent::query($query);
        $e = $q->fetchAll(PDO::FETCH_OBJ);
        return ($e);
    }

    /**
     *@return string
     */
    public function pingDb(){
        return(self::query_single("SELECT 1"));
    }


}




