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


    public function __construct(){
        parent::__construct(self::thedsn("mysql"), self::theuser(),self::thepass());
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
