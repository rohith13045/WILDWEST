<?php
/**
 * The Wild West FrameWork
 * @copyright 2015
 *
 * Class IndexModel
 */

class IndexModel extends MasterDb{
    use DBConfig;
    use GeneralConfig;


    private $error;

    public function __construct($dsn, $user = "", $passwd = ""){
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

    /**  EXAMPLES
     * @return array
     */
    public function show_dbs(){
        $dbs = parent::query_all("SHOW DATABASES");
        return($dbs);
    }

    /**  EXAMPLES
     * @return array
     */
    public function show_db_vars(){
        $dbvars = parent::query_obj("SHOW VARIABLES");
        return($dbvars);
    }
}
