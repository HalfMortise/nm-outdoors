ALTER DATABASE nmoutdoors CHARACTER SET  utf8 COLLATE  utf8_unicode_ci;


CREATE TABLE recArea (
   recAreaId BINARY(16) NOT NULL,
	recAreaDescription VARCHAR (6000),
	recAreaDirections VARCHAR(6000),
	recAreaImageUrl VARCHAR(255),
	recAreaLat FLOAT,
	recAreaLong FLOAT,
	recAreaMapUrl VARCHAR (255),
	recAreaName VARCHAR (255),

	PRIMARY KEY(recAreaId)
);


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
	reviewProfileId
);

