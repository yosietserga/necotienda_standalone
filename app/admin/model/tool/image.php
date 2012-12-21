<?php
class ModelToolImage extends Model {
	function resize($filename, $width, $height,$path=null) {
		if (isset($path)) {
		  $folder = $path;
		} else {
		  $folder = DIR_IMAGE ;
		}
        
        if (!file_exists($folder.$filename) || !is_file($folder.$filename)) {
			return;
		} 
		
		$old_image = $filename;
		$new_image = 'cache/' . substr($filename, 0, strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.jpg';
		
		if (!file_exists($folder . $new_image) || (filemtime($folder . $old_image) > filemtime($folder . $new_image))) {
			$path = '';
			
			$directories = explode('/', dirname(str_replace('../', '', $new_image)));
			
			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;
				
				if (!file_exists($folder . $path)) {
					@mkdir($folder . $path, 0777);
				}
			}
			
			$image = new Image($folder . $old_image);
			$image->resize($width, $height);
			$image->save($folder . $new_image);
		}
	
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			return HTTPS_IMAGE . $new_image;
		} else {
			return HTTP_IMAGE . $new_image;
		}	
	}
}
