<?php
/**
 * The Wild West FrameWork
 * @copyright 2015
 *
 * Class MemcManager
 *
 * this class needs work/debugging
 */
class MemcManager{

    use GeneralConfig;
    use MemcacheConfig;

    /**
     * @var Memcached
     */
    protected $memObj;
    /**
     * @const EXPIRATION_PREFIX
     */
    const EXPIRATION_PREFIX = '_expstamp_';
    /**
     * @var
     */
    protected  $savePath;
    /**
     * @var int
     */
    protected  $lifeTime;

    /**
     * @var string
     */
    protected  $initSessionData;

    /**
     * @var
     */
    public $sessid;

    /**
     * interval for session expiration update in the DB
     * @var int
     */
    protected $_refreshTime = 300; //5 minutes


    public function __construct(){
        $this->memObj       = new Memcached(self::memcache_prefix());
        ini_set('session.save_handler', 'user');
        register_shutdown_function("session_write_close");
        $this->lifeTime = intval(ini_get("session.gc_maxlifetime"));

        session_set_save_handler(
            array($this, "open"),
            array($this, "close"),
            array($this, "read"),
            array($this, "write"),
            array($this, "destroy"),
            array($this, "gc"));
    }


    /**
     * @return bool|Memcached
     */
    public function initMemcached(){
        if($this->memObj->getServerList()) {
            $this->memObj->setOption(Memcached::OPT_RECV_TIMEOUT, 1000);
            $this->memObj->setOption(Memcached::OPT_SEND_TIMEOUT, 3000);
            $this->memObj->setOption(Memcached::OPT_TCP_NODELAY, true);
            $this->memObj->setOption(Memcached::OPT_PREFIX_KEY, self::field_prefix());
            $memcached_servers = explode(',', self::memcache_server_list());
            $this->memObj->addServers($memcached_servers ? : []);
        return($this->memObj);
        }else {
            return(false);
        }
    }

    /**
     * @param string $savePath
     * @param string $sessionName
     * @return bool
     */
    public function open($savePath, $sessionName){

        try  {
            self::initMemcached();
            $sessid = session_id();
            $this->sessid = $sessid;
            if ($sessid !== "") {
                $this->initSessionData = $this->read($sessid);
            }
        }catch(Exception $e){
            print "Error: " . $e->getMessage() . '</br>';
            die();
        }

        return(true);
    }


    /**
     * @return bool
     */
    public function close(){
        $this->lifeTime             = NULL;
        $this->initSessionData      = NULL;
        $this->memObj               = NULL;
        return(true);
    }

    /**
     * @param string $id
     * @return mixed|string
     */
    public function read($id){
        $now = time();

        $data = $this->memObj->get($id);

            $expiration = $this->memObj->get(self::EXPIRATION_PREFIX.$id);
            if($expiration) {
                $this->memObj->set($id, $data, $this->lifeTime + $now);
                return ($data ? $data : '');
            } else {
                $this->memObj->set($id, $data, $this->lifeTime);
                return ($data ? $data : '');
            }



    }

    /**
     * @param string $id
     * @param string $data
     * @return bool
     */
    public function write($id, $data){
        $now = time();

        $expiration = $this->lifeTime + $now;
        $result = $this->memObj->set($id, $data,  $expiration);

        return($result);

    }

    /**
     * @param int $id
     * @return bool
     */
    public function destroy($id){

        $this->memObj->delete($id);
        $result = $this->memObj->delete(self::EXPIRATION_PREFIX.$id);

        return($result);
    }


    /**
     * @param int $maxlifetime
     * @return bool
     */
    public function gc($maxlifetime){
        $this->memObj->delete($this->sessid);
        $result = $this->memObj->delete(self::EXPIRATION_PREFIX.$this->sessid);

        return($result);

    }

}