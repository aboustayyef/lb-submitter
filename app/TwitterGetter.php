<?php 
namespace App;
use \Illuminate\Support\Collection;
use \Twitter;
/**
* 			
*/
class TwitterGetter
{
	public $status, $result; 
	private $username;

	function __construct($username)
	{
		$this->username = $username;
		
		try {
			$twitterDetails = Twitter::getUsers(['screen_name' => $username, 'format'=>'json']);
			$twitterDetails = json_decode($twitterDetails);
			$this->status = 'ok';
		} catch (\Exception $e) {
			$this->status = 'error';
			$twitterDetails = null;
		}

		$this->result = $twitterDetails ;

	}
}