ALTER DATABASE nmoutdoors CHARACTER SET  utf8 COLLATE  utf8_unicode_ci;

DROP TABLE IF EXISTS activityType;
DROP TABLE IF EXISTS activity;
DROP TABLE IF EXISTS review;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS recArea;

CREATE TABLE recArea (
	recAreaId BINARY(16) NOT NULL,
	recAreaDescription VARCHAR (4096),
	recAreaDirections VARCHAR(4096),
	recAreaImageUrl VARCHAR(255),
	recAreaLat DECIMAL (12, 9),
	recAreaLong DECIMAL (12, 9),
	recAreaMapUrl VARCHAR (255),
	recAreaName VARCHAR (255),

	PRIMARY KEY(recAreaId)

);
TRUNCATE TABLE recArea;

CREATE TABLE profile (

	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileAtHandle VARCHAR(32) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileHash CHAR(97) NOT NULL,
	profileImageUrl VARCHAR(255),

	PRIMARY KEY(profileId)
);

CREATE TABLE review (
	reviewId BINARY(16) NOT NULL,
	reviewProfileId BINARY(16) NOT NULL,
	reviewRecAreaId BINARY(16) NOT NULL,
	reviewContent VARCHAR(512),
	reviewDateTime DATETIME(6) NOT NULL,
	reviewRating TINYINT UNSIGNED NOT NULL,
	INDEX(reviewProfileId),
	INDEX(reviewRecAreaId),
	FOREIGN KEY (reviewProfileId) REFERENCES profile(profileId),
	FOREIGN KEY (reviewRecAreaId) REFERENCES recArea(recAreaId),
	PRIMARY KEY (reviewId)
);

CREATE TABLE activity (
	activityId BINARY(16) NOT NULL,
	activityName VARCHAR(60),
	PRIMARY KEY (activityId)
);

CREATE TABLE activityType (
	activityTypeActivityId BINARY(16) NOT NULL,
	activityTypeRecAreaId BINARY(16) NOT NULL,
	INDEX (activityTypeActivityId),
	INDEX (activityTypeRecAreaId),
	FOREIGN KEY (activityTypeActivityId) REFERENCES activity(activityId),
	FOREIGN KEY (activityTypeRecAreaId) REFERENCES recArea(recAreaId),
	PRIMARY KEY (activityTypeActivityId, activityTypeRecAreaId)
);


# INSERT INTO recArea(recAreaId, recAreaDescription, recAreaDirections, recAreaImageUrl, recAreaLat, recAreaLong, recAreaMapUrl, recAreaName) VALUES ("1234567890123456", "Rec Area Test", "Go here", "http://haml.amdn.com", 30.15624, 110.78958, "http://sraco.coan", "Cool place");

# select *
# from recArea;
