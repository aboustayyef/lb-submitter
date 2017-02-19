<?php 

// a simple function API to App\ImageSaver

function saveImageToS3($imageName, $destinationName){
	return (new App\ImageSaver($imageName, $destinationName))->save();
}


 ?>