<?php 
namespace App;
use \Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;
use \Exception;
use Symfony\Component\DomCrawler\Crawler ;

/**
* 			
*/
class UrlAnalyzer
{
	public $status, $errorMessages, $result; 
	private $html, $guzzleClient, $guzzleResponse, $crawler;

	function __construct($url)
	{
		$this->url = $url;
		$this->status = 'ok';
		$this->errorMessages = [];
		$this->result = [];

		// Check url is valid
		if (!$this->urlIsValid($url)) {
			return $this->abort('URL is not valid');
		}

		$this->result['domain'] = $this->getDomain($url);

		// Check url is accessible
		$guzzleClient = new \GuzzleHttp\Client();
        try {    	
	        $guzzleResponse = $guzzleClient->request('GET', $this->url);
        } catch (Exception $e) {
        	return $this->abort('Could not get content of URL. Please try again');
        }

        if ($guzzleResponse->getStatusCode() !== 200) {
        	return $this->abort('Could not get content of URL. Please try again');
        }

        // get title and subtitle
        $this->html = $guzzleResponse->getBody()->getContents();
        $this->crawler = new Crawler($this->html);

		// if any of the below cannot be found, we get status = 'warning' and show the missing items;
		
		$this->getTitleAndDescription();
		$this->getRssFeed();

		// $this->getDescription();
		// $this->getRss();


	}

	private function urlIsValid($url){
		return preg_match('/^(https?:\/\/)?([\da-z\.-]+\.[a-z\.]{2,6}|[\d\.]+)([\/:?=&#]{1}[\da-z\.-]+)*[\/\?]?$/i', $url);
	}

	private function abort($message){
		$this->status = 'error';
		$this->errorMessages[] = $message;
		return;
	}

	private function getTitleAndDescription(){
		$rawTitle = $this->crawler->filter('title')->first()->text();
		
		// some titles come with description, split them;
	    $partsOfTitle = preg_split('#\s*\||–\s*#',$rawTitle);

	    $this->result['title'] = trim($partsOfTitle[0]);
	    if (isset($partsOfTitle[1])) {
		    $this->result['description'] = trim($partsOfTitle[1]);
	    }else{
	    	$this->status = 'warning';
	    	$this->errorMessages[] = 'Could not extract description';
	    }
	}

	private function getRssFeed(){
		try {
			$this->result['feed'] = $this->crawler->filter('link[type="application/rss+xml"]')->first()->attr('href');
		} catch (Exception $e) {
			$this->status = 'warning';
	    	$this->errorMessages[] = 'Could not automatically extract RSS Feed';
		}
	}

	private function getDomain($url)
	{
		# http://www.beirutspring.com -> beirutspring
		# picks longest string in host and returns it

		$parsed = parse_url($url);
		
		if (isset($parsed['host'])) {
			$host = $parsed['host'];
		} else {
			$host = $parsed['path'];
		}

		$candidates = explode('.', $host);

		$recordLength = 0;
		$result = '';

		foreach ($candidates as $candidate) {
			if (strlen($candidate) > $recordLength) {
				$result = $candidate;
				$recordLength = strlen($candidate);
			}
		}

		return $result;

	}

}
?>