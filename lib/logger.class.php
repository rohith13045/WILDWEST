<?php
/**
 * The Wild West FrameWork
 * @copyright 20015
 *
 * Generic logging class for tracking debug info and execution time.
 *
 * Class Logger
 *
 */
class Logger{

    use GeneralConfig;

    /**
     * @var string
     */
    public $logfile         = "";

    /**
     * @var string
     */
    public $logfilename     = "";

    /**
     * @var string
     */
    public $method         = "";

    /**
     * @var string
     */
    protected  $msgstring       = "";

    /**
     * @var string
     */
    protected  $stringData      = "";

    /**
     * @var string
     */
    private $timestamp       = "";

    /**
     * @var string
     */
    protected  $res          = "";

    /**
     * @var array
     */
    private $files           = array();

    /**
     * @var string
     */
    private $file            = "";

    /**
     * @var string
     */
    protected  $file_handle     = "";

    /**
     * @var string
     */
    protected  $debug_tracer    = "";

    /**
     * @param $msg
     */
    public function logit($msg){
        
        $this->msgstring        = "$msg";
        $this->res              = opendir(self::log_path());
        $this->logfile          = "debug_". date("Y-m-d") . ".log";
        $this->timestamp        = date("Y-m-d H:i:s A");
        $this->debug_tracer     = debug_backtrace();
        $this->method           = self::_debugtrace($this->debug_tracer);
        
        if($this->res  && date('i') < 10) {
            while (false !== ($this->file = readdir($this->res))) {
                if (!preg_match('/^\./', $this->file) && preg_match('/^\d\d\d\d-\d\d-\d\d\.log$/', $this->file)) {
                    $this->files[] = $this->file;
                }
            }
            closedir($this->res);
            rsort($this->files);
        }


        $this->stringData = "------------------------------------------------------------------------------------------------------\n"
            . "log entry date: ". $this->timestamp . "\n"
            . "fullpath->filename.php(line number): method/class used\n"
            . $this->method . "\n"
            . "logged message: " . $this->msgstring  . "\n\n";

        $this->logfilename = self::log_path() . "$this->logfile";
        try {
            $this->file_handle = fopen($this->logfilename, 'a');
            fwrite($this->file_handle, $this->stringData);
            fclose($this->file_handle);
        }catch(Exception $e){
            throw new Exception( "unable to write to log " . $e->getMessage() . $e->getTrace() . $e->getCode() . $e->getFile());
        }
}

    /**
     * @param $debugtrace
     * @return string
     */
    public function _debugtrace($debugtrace){
        
        $i = 0;

        while (isset($debugtrace[$i]) && $i <= 10) {
            
            if (array_key_exists('file', $debugtrace[$i])) {
                $file_name = "File: ". $debugtrace[$i]['file'];
                $func      = $debugtrace[$i]["function"];
                $args      = $debugtrace[$i]["args"][0];
            } else {
                $file_name = "";
            }

            if (array_key_exists('line', $debugtrace[$i])) {
                $file_line = $debugtrace[$i]['line'];
                $func      = $debugtrace[$i]["function"];
                $args      = $debugtrace[$i]["args"][0];
            } else {
                $file_line = "";
            }
            $this->method .= "$file_name($file_line):$func(\"$args\"); \n";
            $i++;

        }
        return ($this->method);

    }


}
