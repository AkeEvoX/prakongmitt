<?php
/*logging for tracking 
type : info , debug , error ,warning 
*/
	function log_info($msg)
	{
		$msg = date("j.n.Y") ." [INFO] " . $msg;
		$filename = "logs/info_".date('Y-m-d H:i:s').".log";
		log_file($msg,$filename);
	}

	function log_debug($msg)
	{
		$msg = date("j.n.Y") ." [DEBUG] " . $msg;
		$filename = "./logs/debug_".date('Y-m-d H:i:s').".log";
		log_file($msg,$filename);
	}

	function log_error($msg)
	{
		$msg = date("j.n.Y") ." [ERROR] " . $msg;
		$filename = "./logs/error_".date('Y-m-d H:i:s').".log";
		log_file($msg,$filename);
	}

	function log_warning($msg)
	{
		$msg = date("j.n.Y") ." [WARN] " . $msg;
		$filename = "./logs/warning_".date('Y-m-d H:i:s').".log";
		log_file($msg,$filename);
		
	}

	function log_file($msg,$filename)
	{
		
		$parts = explode('/', $filename);
        $file = array_pop($parts);
        $dir = '';
        foreach($parts as $part)
            if(!is_dir($dir .= "/$part")) mkdir($dir);
        
		//file_put_contents($filename,$msg,FILE_USE_INCLUDE_PATH | FILE_APPEND);
		
		if(!file_exists($filename))
		{
			$newfile = fopen($filename,"w") or die("Unable to open file!!!.");
			fclose($newfile);
		}
		
		$file =fopen($filename,"a");
		
		fwrite($file,$msg."\n");
		
		fclode($file);
		
	}


?>