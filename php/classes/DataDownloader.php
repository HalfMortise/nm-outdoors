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
   /**
    * @var GuzzleHttp\Client
    */
   private $guzzle;

   /**
    * @var \PDO $pdo
    */
   private $pdo;

   public function __construct() {
      $this->guzzle = new GuzzleHttp\Client();
      $this->pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nmoutdoors.ini");
   }



   /**
    * Gets the eTag from a file url
    *
    * @param string $url to grab from
    * @return string $eTag to be compared to previous eTag to determine last download
    * @throws \RuntimeException if stream cant be opened.
    **/

//TODO: use guzzle??? instead of getMetaData function

   public static function compareRecAreaAndDownload() {
      $recAreaUrl = "https://ridb.recreation.gov/api/v1/recareas?state=NM";
      /**
       *run getMetaData and catch exception if the data hasn't changed
       **/
      $recData = null;
      try {
//         DataDownloader::getMetaData($recAreaUrl, "rec area");
         $recData = DataDownloader::readDataJson($recAreaUrl);
//         $recAreaETag = DataDownloader::getMetaData($recAreaUrl, "rec area");
         $config = readConfig("/etc/apache2/capstone-mysql/nmoutdoors.ini");
//         $eTags = json_decode($config["etags"]);
//         $eTags->recArea = $recAreaETag;
//         $config["etags"] = json_encode($eTags);
//			writeConfig($config, "/etc/apache2/capstone-mysql/nmoutdoors.ini");
      } catch(\OutOfBoundsException $outOfBoundsException) {
         echo("no new rec area data found");
      }
      return ($recData);
   }
   /**
    *assigns data from object->features->attributes
    * @param $recData
    * @throws \TypeError RecArea
    **/
   public static function getRecAreaData(\SplFixedArray $recData) {
      $pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nmoutdoors.ini");
      foreach($recData as $feature) {
//         var_dump($feature);
         $recAreaId = generateUuidV4();
         $recAreaDescription = $feature->attributes->DESCRIPTION;
         $recAreaDirections = $feature->attributes->DIRECTIONS;
         $recAreaImageUrl = $feature->attributes->IMAGE_URL;
         $recAreaLat = $feature->attributes->Y;
         $recAreaLong = $feature->attributes->X;
         $recAreaMapUrl = $feature->attributes->MAPURL;
         $recAreaName = $feature->attributes->NAME;
         try {
            $recArea = new RecArea($recAreaId, $recAreaDescription, $recAreaDirections, $recAreaImageUrl, $recAreaLat, $recAreaLong, $recAreaMapUrl, $recAreaName);
            $recArea->insert($pdo);
         }
         catch (\TypeError $typeError) {
            echo ("input a message here");
         }}

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