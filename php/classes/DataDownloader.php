<?php


namespace HalfMortise\NmOutdoors;
require_once("autoload.php");
require_once(dirname (__DIR__, 1) . "/lib/uuid.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
require_once("/etc/apache2/capstone-mysql/encrypted-config.php");

/**
 * This class will download data from  RIDB.Recreation.Gov.
 *
 * @author HalfMortise <https://www.github.com/halfmortise>
 * @author SHeckendorn <https://www.github.com/sheckendorn>
 *
 **/
class DataDownloader {


   /**
    * Gets the eTag from a file url
    *
    * @param string $url to grab from
    * @return string $eTag to be compared to previous eTag to determine last download
    * @throws \RuntimeException if stream cant be opened.
    **/
   public static function getMetaData(string $url, string $eTag) {
      if($eTag !== "rec area") {
         throw(new \RuntimeException("not a valid etag", 400));
      }
      $options = [];
      $options['http'] = [];
//TODO: come back to this section
      $options["http"]["method"] = "HEAD";
      $context = stream_context_create($options);
      $fd = fopen($url, "rb", false, $context);
      $metaData = stream_get_meta_data($fd);
      if($fd === false) {
         throw(new \RuntimeException("unable to open HTTP stream"));
      }
      fclose($fd);
      $header = $metaData["wrapper_data"];
      $eTag = null;
      foreach($header as $value) {
         $explodeETag = explode(":", $value);
         $findETag = array_search("ETag", $explodeETag);
         if($findETag !== false) {
            $eTag = $explodeETag[1];
         }
      }
      if($eTag === null) {
         throw(new \RuntimeException("etag cannot be found", 404));
      }
      $config = readConfig("/etc/apache2/capstone-mysql/nmoutdoors.ini");
      $eTags = json_decode($config["etags"]);
      $previousETag = $eTags->recArea;
      if($previousETag < $eTag) {
         return ($eTag);
      } else {
         throw(new \OutOfBoundsException("input a message here", 401));
      }
   }
   public static function compareRecAreaAndDownload() {
      $recAreaUrl = "https://ridb.recreation.gov/api/v1/recareas?state=NM";
      /**
       *run getMetaData and catch exception if the data hasn't changed
       **/
      $features = null;
      try {
//         DataDownloader::getMetaData($recAreaUrl, "rec area");
         $features = DataDownloader::readDataJson($recAreaUrl);
//         $recAreaETag = DataDownloader::getMetaData($recAreaUrl, "rec area");
         $config = readConfig("/etc/apache2/capstone-mysql/nmoutdoors.ini");
//         $eTags = json_decode($config["etags"]);
//         $eTags->recArea = $recAreaETag;
//         $config["etags"] = json_encode($eTags);
//			writeConfig($config, "/etc/apache2/capstone-mysql/nmoutdoors.ini");
      } catch(\OutOfBoundsException $outOfBoundsException) {
         echo("no new rec area data found");
      }
      return ($features);
   }
   /**
    *assigns data from object->features->attributes
    * @param $features
    **/
   public static function getRecAreaData(\SplFixedArray $features) {
      $pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/nmoutdoors.ini");
      foreach($features as $feature) {
         var_dump($feature);
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
//         var_dump($jsonConverted); (print this to view what's being pulled from RIDB)
         //format
         $jsonFeatures = $jsonConverted->features;
         //create array from the converted Json file
         $features = \SplFixedArray::fromArray($jsonFeatures);
      } catch(\Exception $exception) {
         throw(new \PDOException($exception->getMessage(), 0, $exception));
      }
      return ($features);
   }
}
try {
   $features = DataDownloader::compareRecAreaAndDownload();
   DataDownloader::getRecAreaData($features);
} catch(\Exception $exception) {
   echo $exception->getTraceAsString() . PHP_EOL;
}