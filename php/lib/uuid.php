<?php
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\UuidFactory;
use Ramsey\Uuid\Codec\StringCodec;
/**
 * generates an optimized uuid v4 for efficient MySQL storage and indexing
 *
 * @return UuidInterface resulting uuid
**/

   function generateUuidV4() : UuidInterface