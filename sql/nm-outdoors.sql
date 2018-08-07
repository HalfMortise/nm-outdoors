ALTER DATABASE nmoutdoors CHARACTER SET  utf8 COLLATE  utf8_unicode_ci;
--
-- DROP TABLE IF EXISTS activityType;
-- DROP TABLE IF EXISTS activity;
-- DROP TABLE IF EXISTS review;
-- DROP TABLE IF EXISTS profile;
-- DROP TABLE IF EXISTS recArea;
--
-- CREATE TABLE recArea (
--    recAreaId BINARY(16) NOT NULL,
-- 	recAreaDescription VARCHAR (2048),
-- 	recAreaDirections VARCHAR(512),
-- 	recAreaImageUrl VARCHAR(255),
-- 	recAreaLat DECIMAL (9, 6),
-- 	recAreaLong DECIMAL (9, 6),
-- 	recAreaMapUrl VARCHAR (255),
-- 	recAreaName VARCHAR (255),
--
-- 	PRIMARY KEY(recAreaId)
-- );
--
--
-- CREATE TABLE profile (
--
--    profileId BINARY(16) NOT NULL,
-- 	profileActivationToken CHAR(32),
-- 	profileAtHandle VARCHAR(32) NOT NULL,
-- 	profileEmail VARCHAR(128) NOT NULL,
-- 	profileHash CHAR(97) NOT NULL,
-- 	profileImageUrl VARCHAR(255),
--
-- 	PRIMARY KEY(profileId)
-- );
--
-- CREATE TABLE review (
-- 	reviewId BINARY(16) NOT NULL,
-- 	reviewProfileId BINARY(16) NOT NULL,
-- 	reviewRecAreaId BINARY(16) NOT NULL,
-- 	reviewContent VARCHAR(512),
-- 	reviewDateTime DATETIME(6) NOT NULL,
-- 	reviewRating TINYINT UNSIGNED NOT NULL,
-- 	INDEX(reviewProfileId),
-- 	INDEX(reviewRecAreaId),
-- 	FOREIGN KEY (reviewProfileId) REFERENCES profile(profileId),
-- 	FOREIGN KEY (reviewRecAreaId) REFERENCES recArea(recAreaId),
-- 	PRIMARY KEY (reviewId)
-- );
--
-- CREATE TABLE activity (
-- 	activityId BINARY(16) NOT NULL,
-- 	activityName VARCHAR(60),
-- 	PRIMARY KEY (activityId)
-- );
--
-- CREATE TABLE activityType (
-- 	activityTypeActivityId BINARY(16) NOT NULL,
-- 	activityTypeRecAreaId BINARY(16) NOT NULL,
-- 	INDEX (activityTypeActivityId),
-- 	INDEX (activityTypeRecAreaId),
-- 	FOREIGN KEY (activityTypeActivityId) REFERENCES activity(activityId),
-- 	FOREIGN KEY (activityTypeRecAreaId) REFERENCES recArea(recAreaId),
-- 	PRIMARY KEY (activityTypeActivityId, activityTypeRecAreaId)
-- );

-- @author Dylan McDonald <dmcdonald21@cnm.edu>

-- drop the procedure if already defined
DROP FUNCTION IF EXISTS haversine;

-- procedure to calculate the distance between two points
-- @param FLOAT $originX point of origin, x coordinate
-- @param FLOAT $originY point of origin, y coordinate
-- @param FLOAT $destinationX point heading out, x coordinate
-- @param FLOAT $destinationY point heading out, y coordinate
-- @return FLOAT distance between the points, in miles
CREATE FUNCTION haversine(originX FLOAT, originY FLOAT, destinationX FLOAT, destinationY FLOAT) RETURNS FLOAT
	BEGIN
		-- first, declare all variables; I don't think you can declare later
		DECLARE radius FLOAT;
		DECLARE latitudeAngle1 FLOAT;
		DECLARE latitudeAngle2 FLOAT;
		DECLARE latitudePhase FLOAT;
		DECLARE longitudePhase FLOAT;
		DECLARE alpha FLOAT;
		DECLARE corner FLOAT;
		DECLARE distance FLOAT;

		-- assign the variables that were declared & use them
		SET radius = 3958.7613; -- radius of the earth in miles
		SET latitudeAngle1 = RADIANS(originY);
		SET latitudeAngle2 = RADIANS(destinationY);
		SET latitudePhase = RADIANS(destinationY - originY);
		SET longitudePhase = RADIANS(destinationX - originX);

		SET alpha = POW(SIN(latitudePhase / 2), 2)
						+ POW(SIN(longitudePhase / 2), 2)
						* COS(latitudeAngle1) * COS(latitudeAngle2);
		SET corner = 2 * ASIN(SQRT(alpha));
		SET distance = radius * corner;

		RETURN distance;
	END;
