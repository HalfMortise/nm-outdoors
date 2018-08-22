<?php


namespace HalfMortise\NmOutdoors;
require_once("autoload.php");
require_once(dirname (__DIR__, 1) . "/lib/uuid.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

use GuzzleHttp\Client;


/**
 * This class will download data from  RIDB.Recreation.Gov.
 *
 * @author HalfMortise <https://www.github.com/halfmortise>
 * @author SHeckendorn <https://www.github.com/sheckendorn>
 *
 **/
class DataDownloader {
	/*
	 * @var \SplFixedArray
	 */
	private $activities;
   /**
    * @var Client
    */
   private $guzzle;

   /**
    * @var \PDO $pdo
    */
   private $pdo;

   public function __construct() {
		$config = readConfig("/etc/apache2/capstone-mysql/nmoutdoors.ini");
      $this->guzzle = new Client(["base_uri" => "https://ridb.recreation.gov/api/v1/", "headers" => ["apikey" => $config["recgov"]]]);
      $this->pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nmoutdoors.ini");
      $this->activities = Activity::getAllActivities($this->pdo);
   }


//TODO: use guzzle??? instead of getMetaData function


   public function getRecAreaAndActivities(\stdClass $apiRecArea) : void {
      $recArea = new RecArea(generateUuidV4(), $apiRecArea->RecAreaDescription, $apiRecArea->RecAreaDirections, $apiRecArea->RecAreaLatitude, $apiRecArea->RecAreaLongitude, $apiRecArea->RecAreaMapURL, $apiRecArea->RecAreaName);
      $recArea->insert($this->pdo);
      foreach($apiRecArea->ACTIVITY as $apiActivity) {
      	$currActivity = array_filter($this->activities, function ($mySqlActivity) use ($apiActivity){
      		return $mySqlActivity->getActivityName() === $apiActivity->recAreaActivityDescription;
			});
      	$currActivity = array_shift($currActivity);
      	if ($currActivity !== null){
      		$activityType = new ActivityType($currActivity->getActivityId(), $recArea->getRecAreaId());
      		$activityType->insert($this->pdo);
			}
		}
   }


   /**
    *
    * Decodes Json file, converts to string, sifts through the string and inserts the data into database
    *
    * @param string $url
    * @throws \PDOException for PDO related errors
    * @throws \Exception catch-all exceptions
    * @return \SplFixedArray $allData
    *
    **/
   public function readDataJson($url) {
      $config = readConfig("/etc/apache2/capstone-mysql/nmoutdoors.ini");
      $recDotGov = json_decode($config["recDotGov"]);
      // http://php.net/manual/en/function.stream-context-create.php creates a stream for file input
      $context = stream_context_create(["http" => ["ignore_errors" => true, "method" => "GET", "header" => "apikey:$recDotGov->apiKey"]]);
      try {
         // http://php.net/manual/en/function.file-get-contents.php file-get-contents returns file in string context
         if(($jsonData = file_get_contents($url, null, $context)) === false) {
            throw(new \RuntimeException("cannot connect to RIDB server"));
         }
         //decode the Json file
         $jsonConverted = json_decode($jsonData);
         //container for rec areas
         $jsonConverted = $jsonConverted->RECDATA;
         //format
         $jsonFeatures = $jsonConverted;
         //create array from the converted Json file
         $recData = \SplFixedArray::fromArray($jsonFeatures);
      } catch(\Exception $exception) {
         throw(new \PDOException($exception->getMessage(), 0, $exception));
      }
      return ($recData);
   }
}
try {
   $recData = DataDownloader::compareRecAreaAndDownload();
   DataDownloader::getRecAreaData($recData);
} catch(\Exception $exception) {
   echo $exception->getTraceAsString() . PHP_EOL;
}