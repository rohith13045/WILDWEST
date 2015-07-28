<?php
/**
 * The Wild West FrameWork
 * @copyright 2015
 *
 * Class SmartyView
 */
class SmartyView extends Smarty{
    /**
     * @var string
     */
    protected  $docroot;
    /**
     * @var string
     */
    protected  $tpl_path = "";
    /**
     * @var string
     */
    protected  $plugindir  = "../vendor/smarty/smarty/libs/plugins";
    /**
     * @var string
     */
    protected  $value      = "";
    /**
     * @var bool|null
     */
    protected  $cache      = NULL;
    /**
     * @var null
     */
    protected  $debug      = NULL;
    /**
     * @var bool|null
     */
    protected  $debuggin   = NULL;
    /**
     * @var string
     */
    protected  $fullpath   = "";

    /**
     * @var string
     */
    protected $webview     = "";

    /**
     * @var string
     */
    protected  $webviewpath = "";


    /**
     * @param string $tpl_path
     * @param string $webview
     * @param null $cache
     * @param null $debug
     */
     public function __construct($tpl_path = 'views/default',$webview = 'webroot/', $cache = NULL,$debug = NULL) {

         parent::__construct();
        $this->webview       = (string) $webview;
        $this->tpl_path      = (string) $tpl_path;
        $this->docroot       = (string) $_SERVER['DOCUMENT_ROOT'];
        $this->fullpath      = (string) ''.$this->docroot.'/../'.$tpl_path.'/';
        $this->webviewpath   = (string) $this->docroot. '/../'.$webview.'/';
        $this->force_compile = true;

        
        /* enable cache*/
        if($this->cache){
            $this->cache        = true;
            self::setCaching(true);
        }else{  /* disable cache*/
            $this->cache        = false;
            self::setCaching(false);
        }
        /* enable debugging console */
        if($this->debuggin){
            $this->debugging    = true;
            self::setDebugging(true);
        }else{  /* disable debugging console */
            $this->debugging    = false;
            self::setDebugging(false);
        }
        self::setTemplateDir ($this->fullpath);
        self::setCompileDir  ($this->fullpath."templates_c/");
        self::setConfigDir   ($this->fullpath."configs/");
        self::setCacheDir    ($this->fullpath."cache/");
        
       
       /*define default image, css, jspath and webview  */
       $this->assign("load_global_image", "/images");
       $this->assign("load_global_css_file", "/css");
       $this->assign("load_global_js_file", "/js");
       $this->assign("webviewpath", $this->webviewpath);
     
     
     
     }

    /**
     * @param $webview
     * @return string
     */
    public function webview($webview){
        $this->webviewpath = "$webview";
        return($this->webviewpath);
    }

    /**
     * @method global_header()
     * @return global smarty header template
     */
    public function global_header(){
        $header = "../default/header.tpl";
        return($this->display($header));
    }

    /**
     * @method global_footer
     * @Return global smarty footer template
     */
    public function global_footer(){
        $footer = "../default/footer.tpl";
        return($this->display($footer));
    }
    
 
 
     
}     
?>