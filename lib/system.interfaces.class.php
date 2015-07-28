<?php
/**
 * The Wild West FrameWork
 * @copyright 2015
 *
 * Interface PageStruct
 */
interface PageStruct{

    /**
     * @return mixed
     */
    public function __default();

    /**
     * @param $code
     * @return mixed
     */
    public function __error($code,$msg);

}


/**
 * Interface ApiStruct
 */
interface ApiStruct{
    /**
     * @return mixed
     */
    public function __default();
    
    public function __api();

    public function __error($code,$msg);

}


/**
 * Interface AuthStruct
 */
interface AuthStruct{

    /**
     * @return mixed
     */
    public function __default();

    /**
     * @return mixed
     */
    public function __login($params);

    /**
     * @return mixed
     */
    public function security_check($params);
}


