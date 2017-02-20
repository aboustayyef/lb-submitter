<?php 

// a simple function API to App\ImageSaver

function saveImage($imageName, $destinationName){
	return (new App\ImageSaver($imageName, $destinationName))->save();
}


?>