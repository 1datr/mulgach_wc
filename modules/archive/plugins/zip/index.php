<?php

class plg_zip extends mod_plugin 
{
	VAR $ARCMAN;
	// Параметры :
	// controller - контроллер, к которому подключаешь плагин 	
	function __construct($_PARAMS=array())
	{
		
		if(is_object($_PARAMS))
		{
			$this->_controller = $_PARAMS;

			$this->add_js_css($this->_controller);
		}
		elseif(!empty($_PARAMS['controller']))
		{
			$this->_controller = $_PARAMS['controller'];

			$this->add_js_css($this->_controller);
			
		}		
	}
	
	function get_arc_man($params=[])
	{
		$this->ARCMAN = new \ZipArchive;
		return $this;
	}
	
	public function AddFolder($_folder,$exclude_files=[])
	{
		$this->folderToZip($_folder, strlen($_folder),$exclude_files);
	}
	
	private function folderToZip($folder, $exclusiveLength,$exclude_files=[]) 
	{
		$handle = opendir($folder);
		
		while (false !== $f = readdir($handle)) 
		{
			if ($f != '.' && $f != '..') 
			{
				
			//	mul_dbg($f);
				if( substr($f,0,1)=='\\')
				{
					$f = substr($f,1);
				}
				
				$filePath = "$folder/$f";			
				// Remove prefix from file path before add to zip.
				$localPath = substr($filePath, $exclusiveLength);
									
				if( in_array($localPath, $exclude_files) )
					continue;
					
				if (is_file($filePath)) 
				{
					$this->ARCMAN->addFile($filePath, $localPath);
				} 
				elseif (is_dir($filePath)) 
				{
					// Add sub-directory.
					$this->ARCMAN->addEmptyDir($localPath);
					
					$this->folderToZip($filePath, $exclusiveLength,$exclude_files);
				}
			}
		}
		closedir($handle);
	}

}