<?php
/**
 * The Wild West FrameWork
 * @copyright 2015
 *
 * Class CHANGEME_CONTROLLER
 *
 */

class __CHANGEME_CONTROLLER  extends SmartyView implements PageStruct {
    /**
     * use trait GeneralConfig
     */
    use GeneralConfig;
    /**
     * use trait DBConfig
     */
    use DBConfig;
    /**
     * @var string
     */
    public $viewpath = '';
    /**
     * @var
     */
    public $smarty;

    /**
     * @var
     */
    private $dbObj;

    /**
     * @var
     */
    public $dateset;

    /**
     * @var Logger
     */
    private $logobj;

    /**
     * @var
     */
    public $sessionObj;

    /**
     * @param string $viewp
     * @param null $cache
     * @param null $debug
     */
    public function __construct($viewp,$cache,$debug){
        parent::__construct($viewp, $cache, $debug);
        $this->dbObj                = new IndexModel();
        $this->logobj       	    = new Logger();
        $this->viewpath             = $viewp;
        $this->cache                = $cache;
        $this->debugging            = $debug;
        $this->dateset              = date('F j, Y, g:i a');
        $this->assign("dateset",$this->dateset);
    }

    /**
     * @return page default
     */
    public function __default(){
        return true;
    }


    /**
     * @return error page
     * @param $code
     */
    public function __error($code,$msg){
        $this->assign("error_code","$code");
        $this->assign("msg","$msg");
        $this->display("errors/$code.tpl");
    }



}


?>