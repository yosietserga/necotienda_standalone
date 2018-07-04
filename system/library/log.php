<?php
final class Log {
	private $filename;
	private $time_start;
	private $time_end;

	public function __construct($filename) {
		$this->filename = $filename;
		$this->time_start = microtime(true);
	}
	
	public function write($message) {
	    if (!is_dir(DIR_LOGS)) mkdir(DIR_LOGS, 0755);
		$file = DIR_LOGS . $this->filename;
		$handle = fopen($file, 'a+');
		fwrite($handle, date('Y-m-d G:i:s') . ' - ' . $message . "\n");
		fclose($handle); 
	}

	public function trace($info = null) {
        $trace = debug_backtrace();
        if (isset($trace[1])) {
            $msg = "\r\n";
            $msg .= str_repeat("-", 20);
            $msg .= "\r\n";

            $msg .= "File: {$trace[1]['file']} \n";
            $msg .= "Line: {$trace[1]['line']} \n";
            if (isset($trace[1]['class'])) $msg .= "Class: {$trace[1]['class']} \n";
            if (isset($trace[1]['function'])) $msg .= "Function: {$trace[1]['function']} \n";
            //if (isset($trace[1]['args'])) $msg .= "Args:\n". (print_r($trace[1]['args'], true)) ."\n";
            //if (isset($trace[1]['object'])) $msg .= "Object:\n". (print_r($trace[1]['object'], true)) ."\n";

            if (isset($info)) $msg .= "DATA:\n". (print_r($info, true)) ."\n";

            $this->time_end = microtime(true);
            $msg .= "IP: {$_SERVER['REMOTE_ADDR']} - Time Exec: ". ($this->time_end - $this->time_start) . " seconds - Memory Usage: ". (memory_get_peak_usage(true)/1024/1024) ."MB\n";
            $this->time_start = $this->time_end;

            $msg .= "\r\n";
            $msg .= str_repeat("-", 20);
            $msg .= "\r\n";

            $this->write($msg);
        }
    }
}
