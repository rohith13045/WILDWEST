<?php
/**
* The Wild West FrameWork
* @copyright 2015
*
*/

$viewpath = "default";
require_once(dirname(__FILE__).'/../config/config.common.php');
Load::model("index");
Load::controller("index");

/**
 * Entry Point
 */
$ViewObj = new __index("views/$viewpath",$_REQUEST['cache'],$_REQUEST['debug']);
if(isset($_REQUEST['page'])){
   
    $pagereq = "__" . $_REQUEST['page'];
    $params   = $_REQUEST;
    /**
     * Check if method exists for page called, else notify
     */
    if (method_exists( $ViewObj, "$pagereq")) {
        $thepage =  $ViewObj->$pagereq($params);
    }else{
        /**
         * Show them the page not found
         */
        $ViewObj->__error(300,"Page not found");
        exit;
    }


    }else{
    $ViewObj->__default();
 
}

?>
