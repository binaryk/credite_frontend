<?php
namespace App\Models\Helpers;
/**
* 
*/
class Image 
{
	protected $source 	= '';
	protected $default = '';
	protected $file;
	protected static $instance = NULL;
	
	function __construct($source)
	{
		$this->default = 'uploads/default.png';
		$this->source =  public_path() . '\\' . $source;
		$this->file   = $source;
	}

	public function getImage(){

		if(file_exists( $this->source) && strlen($this->file) > 0 ){
			return $this->file;
		}
		return $this->default;
	}

	public static function make($source){
		return self::$instance = new Image($source);
	}


}

