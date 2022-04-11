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

/* Drop any an all tables that already exist. */
/* Child Tables */
DROP TABLE IF EXISTS FoodLegislation;
DROP TABLE IF EXISTS PopulationStats;

/* Parent Tables */
DROP TABLE IF EXISTS Location;
DROP TABLE IF EXISTS DataType;

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
    Description LONGTEXT NOT NULL
);

CREATE TABLE PopulationStats(
    StatID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

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

    CrimeRate DEC,
    LiteracyRate DEC,
    SchoolEnrollment DEC
);