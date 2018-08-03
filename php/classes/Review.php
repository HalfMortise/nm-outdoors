<?php
namespace HalfMortise\NmOutdoors;
require_once("autoload.php");
require_once(dirname(__DIR__, 2). "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;

class review implements \JsonSerializable {
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
	 * @var int $reviewRating
	 */
	private $reviewRating;

	/**
	 * constructor for this review
	 *
	 * @param string|Uuid $newReviewId id of this review or null if a new review
	 * @param string|Uuid $newReviewProfileId id of the Profile that made the review
	 * @param string|Uuid $newReviewRecAreaId id of the rec area the review was made on
	 * @param string $newReviewContent string containing actual review data
	 * @param \DateTime|string|null $newReviewDateTime date and time when review was sent or null if set to current date and time
	 * @param int $newReviewRating int rating score of the rec area being reviewed
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/
	public function __construct($newReviewId, $newReviewProfileId, $newReviewRecAreaId, string $newReviewContent, $newReviewDateTime = null, int $newReviewRating) {
		try {
			$this->setReviewId($newReviewId);
			$this->setReviewProfileId($newReviewProfileId);
			$this->setReviewRecAreaId($newReviewRecAreaId);
			$this->setReviewContent($newReviewContent);
			$this->setReviewDateTime($newReviewDateTime);
			$this->setReviewRating($newReviewRating);
		} //determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for review id
	 *
	 * @return Uuid value of review id
	 **/
	public function getReviewId(): Uuid {
		return ($this->reviewId);
	}
	/**
	 * mutator method for the review id
	 *
	 * @param Uuid | string $newReviewId new value of review id
	 * @throws \RangeException if $newReviewId is not positive
	 * @throws \TypeError if $newReviewId is not a uuid or string
	 **/
	public function setReviewId($newReviewId): void {
		try {
			$uuid = self::validateUuid($newReviewId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the review id
		$this->reviewId = $uuid;
	}
	/**
	 * accessor method for review profile id
	 *
	 * @return Uuid value of review profile id
	 **/
	public function getReviewProfileId(): Uuid {
		return ($this->reviewProfileId);
	}
	/**
	 * mutator method for review profile id
	 *
	 * @param string | Uuid $newReviewProfileId new value of review profile id
	 * @throws \RangeException if $newReviewProfileId is not positive
	 * @throws \TypeError if $newReviewProfileId is not an integer
	 **/
	public function setReviewProfileId($newReviewProfileId): void {
		try {
			$uuid = self::validateUuid($newReviewProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->reviewProfileId = $uuid;
	}
	/**
	 * accessor method for review rec area id
	 *
	 * @return Uuid value of review rec area id
	 **/
	public function getReviewRecAreaId(): Uuid {
		return ($this->reviewRecAreaId);
	}
	/**
	 * mutator method for review rec area id
	 *
	 * @param string | Uuid $newReviewRecAreaId new value of review rec area id
	 * @throws \RangeException if $newReviewRecAreaId is not positive
	 * @throws \TypeError if $newReviewRecAreaId is not an integer
	 **/
	public function setReviewRecAreaId($newReviewRecAreaId): void {
		try {
			$uuid = self::validateUuid($newReviewRecAreaId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the profile id
		$this->reviewRecAreaId = $uuid;
	}
	/**
	 * accessor method for review content
	 *
	 * @return string value of review content
	 **/
	public function getReviewContent(): string {
		return ($this->reviewContent);
	}
	/**
	 * mutator method for review content
	 *
	 * @param string $newReviewContent new value of the review content
	 * @throws \InvalidArgumentException if $newReviewContent is not a string or insecure
	 * @throws \RangeException if $newReviewContent is > 4096 characters
	 * @throws \TypeError if $newReviewContent is not a string
	 **/
	public function setReviewContent(string $newReviewContent): void {
		// verify the review content is secure
		$newReviewContent = trim($newReviewContent);
		$newReviewContent = filter_var($newReviewContent, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newReviewContent) === true) {
			throw(new \InvalidArgumentException("review content is empty or insecure"));
		}
		// verify the review content will fit in the database
		if(strlen($newReviewContent) > 512) {
			throw(new \RangeException("review content too large"));
		}
		// store the review content
		$this->reviewContent = $newReviewContent;
	}
	/**
	 * accessor method for review date time
	 *
	 * @return \DateTime value of review date
	 **/
	public function getReviewDateTime(): \DateTime {
		return ($this->reviewDateTime);
	}
	/**
	 * mutator method for the review date time
	 *
	 * @param \DateTime|string|null $newReviewDateTime review date as a DateTime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newReviewDateTime is not a valid object or string
	 * @throws \RangeException if $newReviewDateTime is a date that does not exist
	 * @throw \TypeError if returned type does not match
	 **/
	public function setReviewDateTime($newReviewDateTime = null): void {
		// base case: if the date is null, use the current date and time
		if($newReviewDateTime === null) {
			$this->reviewDateTime = new \DateTime();
			return;
		}
		// store the review date using the ValidateDate trait
		try {
			$newReviewDateTime = self::validateDateTime($newReviewDateTime);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->reviewDateTime = $newReviewDateTime;
	}

	/**
	 * accessor method for clap Number
	 *
	 * @return int value of clap Number
	 **/
	public function getReviewRating(): int {
		return ($this->reviewRating);
	}

	/**
	 * mutator method for clap Number
	 *
	 * @param int $newReviewRating new value of clap Number
	 * @throws \InvalidArgumentException if $newreviewRating is not an int or insecure
	 * @throws \RangeException if $newreviewRating is > 51 claps
	 * @throws \TypeError if $newreviewRating is not an int
	 **/
	public function setReviewRating(int $newReviewRating): void {
// verify the clap Number is secure
		$newReviewRating = trim($newReviewRating);
		$newReviewRating = filter_var($newReviewRating, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newreviewRating) === true) {
			throw(new \InvalidArgumentException("clap Number is empty or insecure"));
		}

// verify the review rating will fit in the database
		if($newReviewRating > 6) {
			throw(new \RangeException("review rating is too large"));
		}

// store the review rating
		$this->reviewRating = $newReviewRating;
	}

	/**
	 * inserts this review into mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo): void {
		// create query template
		$query = "INSERT INTO review(reviewId, reviewProfileId, reviewRecAreaId, reviewContent, reviewDateTime, reviewRating) VALUES(:reviewId, :reviewProfileId, :reviewRecAreaId, :reviewContent, :reviewDateTime, :reviewRating)";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holders in the template
		$formattedDate = $this->reviewDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["reviewId" => $this->reviewId->getBytes(), "reviewRecAreaId" => $this->reviewRecAreaId->getBytes(), "reviewProfileId" => $this->reviewProfileId->getBytes(), "reviewContent" => $this->reviewContent, "reviewDateTime" => $formattedDate];
		$statement->execute($parameters);
	}
	/**
	 * deletes this review from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo): void {
		// create query template
		$query = "DELETE FROM review WHERE reviewId = :reviewId";
		$statement = $pdo->prepare($query);
		// bind the member variables to the place holder in the template
		$parameters = ["reviewId" => $this->reviewId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this review in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related error occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo): void {
		//create a query template
		$query = "UPDATE review SET reviewRecAreaId = :reviewRecAreaId, reviewProfileId = :reviewProfileId, reviewContent = :reviewContent, reviewDateTime = :reviewDateTime WHERE reviewId = :reviewId";
		$statement = $pdo->prepare($query);
		$formattedDate = $this->reviewDateTime->format("Y-m-d H:i:s.u");
		$parameters = ["reviewId" => $this->reviewId->getBytes(), "reviewRecAreaId" => $this->reviewRecAreaId->getBytes(), "reviewProfileId" => $this->reviewProfileId->getBytes(), "reviewContent" => $this->reviewContent, "reviewDateTime" => $formattedDate];
		$statement->execute($parameters);
	}
	/**
	 * gets the review by reviewId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $reviewId review id to search for
	 * @return review|null review found or null if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable is not the correct data type
	 **/
	public static function getReviewByReviewId(\PDO $pdo, $reviewId): ?review {
		// sanitize the reviewId before searching
		try {
			$reviewId = self::validateUuid($reviewId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT reviewId, reviewRecAreaId, reviewProfileId, reviewContent, reviewDateTime FROM review WHERE reviewId = :reviewId";
		$statement = $pdo->prepare($query);
		//bind the review id to the place holder in the template
		$parameters = ["reviewId" => $reviewId->getBytes()];
		$statement->execute($parameters);
		//grab the review from mySQL
		try {
			$review = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$review = new review($row["reviewId"], $row["reviewProfileId"],  $row["reviewRecAreaId"], $row["reviewContent"], $row["reviewDateTime"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return ($review);
	}
	/**
	 * gets the review by reviewRecAreaId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $reviewRecAreaId review rec area id to search for
	 * @return \SplFixedArray array of reviews found or empty if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable is not the correct data type
	 **/
	public static function getReviewByreviewRecAreaId(\PDO $pdo, $reviewRecAreaId): \SplFixedArray {
		// sanitize the reviewRecAreaId before searching
		try {
			$reviewRecAreaId = self::validateUuid($reviewRecAreaId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT reviewId, reviewRecAreaId, reviewProfileId, reviewContent, reviewDateTime FROM review WHERE reviewRecAreaId = :reviewRecAreaId";
		$statement = $pdo->prepare($query);
		//bind the review id to the place holder in the template
		$parameters = ["reviewRecAreaId" => $reviewRecAreaId->getBytes()];
		$statement->execute($parameters);
//		//build and array of reviews
		$reviews = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while (($row = $statement->fetch()) !== false) {
			try {
				$review = new review($row["reviewId"], $row["reviewRecAreaId"], $row["reviewProfileId"], $row["reviewContent"], $row["reviewDateTime"]);
				$reviews[$reviews->key()] = $review;
				$reviews->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($reviews);
	}
	/**
	 * gets the review by reviewProfileId
	 *
	 * @param \PDO $pdo PDO connection object
	 * @param Uuid|string $reviewProfileId review profile id to search for
	 * @return \SplFixedArray array of reviews found or empty if not found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when a variable is not the correct data type
	 **/
	public static function getReviewByReviewProfileId(\PDO $pdo, $reviewProfileId): \SplFixedArray {
		// sanitize the reviewProfileId before searching
		try {
			$reviewProfileId = self::validateUuid($reviewProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT reviewId, reviewRecAreaId, reviewProfileId, reviewContent, reviewDateTime FROM review WHERE reviewProfileId = :reviewProfileId";
		$statement = $pdo->prepare($query);
		//bind the review id to the place holder in the template
		$parameters = ["reviewProfileId" => $reviewProfileId->getBytes()];
		$statement->execute($parameters);
		//build and array of reviews
		$reviews = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while (($row = $statement->fetch()) !== false) {
			try {
				$review = new review($row["reviewId"], $row["reviewRecAreaId"], $row["reviewProfileId"], $row["reviewContent"], $row["reviewDateTime"]);
				$reviews[$reviews->key()] = $review;
				$reviews->next();
			} catch(\Exception $exception) {
				// if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return ($reviews);
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize(): array {
		$fields = get_object_vars($this);
		$fields["reviewId"] = $this->reviewId->toString();
		$fields["reviewProfileId"] = $this->reviewProfileId->toString();
		$fields["reviewRecAreaId"] = $this->reviewRecAreaId->toString();
		//format the date so that the front end can consume it
		$fields["reviewDateTime"] = round(floatval($this->reviewDateTime->format("U.u")) * 1000);
		return ($fields);
	}
}
