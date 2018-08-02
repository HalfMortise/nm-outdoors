<?php
namespace HalfMortise\NmOutdoors;
require_once("autoload.php");
require_once(dirname(__DIR__, 2). "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

class Review implements \JsonSerializable {
	use ValidateDate;
	use ValidateUuid;

	/*
	 * id for this review; this is the primary key
	 * @var Uuid $reviewId
	 */
	private $reviewId;

	/*
	 * id for the Profile leaving the review: this is a foreign key
	 * @var Uuid $reviewProfileId
	 */
	private $reviewProfileId;

	/*
	 * id for the Rec Area the review is on: this is a foreign key
	 * @var Uuid $reviewRecAreaId
	 */
	private $reviewRecAreaId;

	/*
	 * content of the review
	 * @var string $reviewContent
	 */
	private $reviewContent;

	/*
	 * date and time this review was made, in a PHP DateTime object
	 * @var \DateTime $reviewDateTime
	 */
	private $reviewDateTime;

	/*
	 * rating score of review on Rec Area
	 * @var tinyint $reviewRating
	 */
	private $reviewRating;



}
