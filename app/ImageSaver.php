<?php 
namespace App;
use \Image;
use \Storage;

/**
*	Saves Image to Amazon S3 			
*/

class ImageSaver
{
	private $image, $destinationName;

	public function __construct($image, $destinationName)
	{
		$this->image = $image;
		$this->destinationName = $destinationName;
	}

	public function save(){
		$i = Image::make($this->image);
		try {
	        $result = Storage::disk('s3')->put( $this->destinationName, $i->encode('jpg')->stream()->__toString());
	        return true;
		} catch (\Exception $e) {
			return false;
		}
	}
}
?>