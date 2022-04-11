/* Test script for database setup with test dataset.
 *
 * Louie DiBernardo (LDIBERN1)
 * Sanddhya Jayabalan (SJAYABA1)
*/

/* Drop and create new table. Only run if debugging issues. */
/*
DROP DATABASE IF EXISTS Project;
CREATE DATABASE Project;
*/

UNLOCK TABLES;

/* Drop any an all tables that already exist. */
/* Child Tables */
DROP TABLE IF EXISTS FoodLegislation;
DROP TABLE IF EXISTS PopulationStats;
DROP TABLE IF EXISTS AvgHousehold;
DROP TABLE IF EXISTS ConsumptionStats;

/* Parent Tables */
DROP TABLE IF EXISTS Location;
DROP TABLE IF EXISTS DataType;

DROP FUNCTION IF EXISTS FilePath;

/* Create all tables. */
CREATE TABLE Location(
    LocationID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    State VARCHAR(100) NOT NULL,
    County VARCHAR(100),
    City VARCHAR(100),
    LocationType ENUM('urban', 'suburban', 'mixed', 'rural')
);

CREATE TABLE DataType(
    TypeID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    BrokenTo ENUM('state', 'county', 'city') NOT NULL,
    Researcher ENUM('federal', 'state') NOT NULL
);

CREATE TABLE FoodLegislation(
    LegislationID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

    LocationID SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT FK_LocationID_FL
        FOREIGN KEY (LocationID) references Location(LocationID)
        ON DELETE CASCADE
        ON UPDATE RESTRICT,

    TypeID SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT FK_TypeID_FL
        FOREIGN KEY (TypeID) references DataType(TypeID)
        ON DELETE CASCADE
        ON UPDATE RESTRICT,

    YearPassed VARCHAR(4) NOT NULL,
    BillName VARCHAR(100) NOT NULL,
    Description LONGTEXT NOT NULL
);

CREATE TABLE PopulationStats(
    PopStatID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

    LocationID SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT FK_LocationID_PS
        FOREIGN KEY (LocationID) references Location(LocationID)
        ON DELETE CASCADE
        ON UPDATE RESTRICT,

    TypeID SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT FK_TypeID_PS
        FOREIGN KEY (TypeID) references DataType(TypeID)
        ON DELETE CASCADE
        ON UPDATE RESTRICT,

    Year SMALLINT(4) UNSIGNED NOT NULL,
    CrimeRate DECIMAL(5,5) UNSIGNED,
    LiteracyRate DECIMAL(5,5) UNSIGNED,
    SchoolEnrollment DECIMAL(5,5) UNSIGNED
);

CREATE TABLE AvgHousehold(
    AvgHouseID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

    LocationID SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT FK_LocationID_AH
        FOREIGN KEY (LocationID) references Location(LocationID)
            ON DELETE CASCADE
            ON UPDATE RESTRICT,

    TypeID SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT FK_TypeID_AH
        FOREIGN KEY (TypeID) references DataType(TypeID)
            ON DELETE CASCADE
            ON UPDATE RESTRICT,

    Year SMALLINT(4) UNSIGNED NOT NULL,
    NumMembers SMALLINT(2) UNSIGNED NOT NULL,
    NumDependents SMALLINT(2) UNSIGNED NOT NULL,
    NumWorking SMALLINT(2) UNSIGNED NOT NULL,
    AvgIncome SMALLINT(6) UNSIGNED NOT NULL
);

CREATE TABLE ConsumptionStats(
    ConStatID  SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

    LocationID SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT FK_LocationID_CS
        FOREIGN KEY (LocationID) references Location(LocationID)
            ON DELETE CASCADE
            ON UPDATE RESTRICT,

    TypeID SMALLINT UNSIGNED NOT NULL,
    CONSTRAINT FK_TypeID_CS
        FOREIGN KEY (TypeID) references DataType(TypeID)
            ON DELETE CASCADE
            ON UPDATE RESTRICT,

    Age SMALLINT(3) UNSIGNED NOT NULL,
    SugarIntake SMALLINT UNSIGNED,
    FatIntake SMALLINT UNSIGNED

);



/* Load data into tables from files. */

DELIMITER //

CREATE FUNCTION FilePath ()
    RETURNS varchar(100) DETERMINISTIC

BEGIN

    DECLARE path varchar(100);

    IF @@hostname = 'framework' THEN
        SET path = '/home/justatechie/IdeaProjects/DatabasesProject/data/test/location-test.txt';
    ELSE
        SET path = './db/location-test.txt';

    END IF;

    RETURN path;

END; //

DELIMITER ;

set @path = FilePath();

/*select @path;*/
/*LOAD DATA LOCAL INFILE @path INTO TABLE Location FIELDS TERMINATED BY ',';*/

/* hopefully we can eventually utilize the above code to auto determine file path. */
LOAD DATA LOCAL INFILE '/home/justatechie/IdeaProjects/DatabasesProject/data/test/location-test.txt' INTO TABLE Location FIELDS TERMINATED BY ',';

LOAD DATA LOCAL INFILE '/home/justatechie/IdeaProjects/DatabasesProject/data/test/datatype-test.txt' INTO TABLE DataType FIELDS TERMINATED BY ',';

LOAD DATA LOCAL INFILE '/home/justatechie/IdeaProjects/DatabasesProject/data/test/foodlegislation-test.txt' INTO TABLE FoodLegislation FIELDS TERMINATED BY ',';

LOAD DATA LOCAL INFILE '/home/justatechie/IdeaProjects/DatabasesProject/data/test/populationstats-test.txt' INTO TABLE PopulationStats FIELDS TERMINATED BY ',';

/* Lock tables that should be read-only (should be all tables eventually to prevent data deletion.) */
/*LOCK TABLES DataType READ;*/