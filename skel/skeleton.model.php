<?php
/**
 * The Wild West FrameWork
 * @copyright 2015
 *
 * CHANGEME_MODEL model for CHANGEME_CONTROLLER controller
 *
 *
 * Class CHANGEME_MODEL
 * Extends MasterDb
 */

class CHANGEME_MODEL  extends MasterDb{
    use DBConfig;
    use GeneralConfig;


    public function __construct(){
        parent::__construct(self::thedsn("mysql"), self::theuser(),self::thepass());
    }

    /**
     * @return array
     */
    public function show_db_status(){
        $status = parent::query_all("SHOW STATUS");
        return($status);
    }


}
