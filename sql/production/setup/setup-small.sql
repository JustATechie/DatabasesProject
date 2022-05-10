/* Script for database setup with small dataset.
 *
 * Louie DiBernardo (LDIBERN1)
 * Sanddhya Jayabalan (SJAYABA1)
*/

/*********** Begin Test Setup ***********/

/* Select the right database */
#USE 22sp_ldibern1_db;

/*================= Create Parent Tables =================*/
CREATE TABLE DataType(
                         TypeID SMALLINT UNSIGNED PRIMARY KEY NOT NULL,
                         BrokenTo ENUM('state', 'county', 'city', 'federal') NOT NULL,
                         Researcher ENUM('federal', 'state') NOT NULL
);

CREATE TABLE Location(
                         LocationID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                         State VARCHAR(100) NOT NULL,
                         County VARCHAR(100),
                         City VARCHAR(100),
                         LocationType ENUM('urban', 'suburban', 'mixed', 'rural')
);

/*================= Create child tables. =================*/

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
                                BillName LONGTEXT NOT NULL,
                                HealthTopic LONGTEXT,
                                PolicyTopic LONGTEXT,
                                Setting LONGTEXT,
                                Description LONGTEXT

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
                                CrimeRate BIGINT UNSIGNED,
                                LiteracyRate BIGINT UNSIGNED,
                                SchoolEnrollment BIGINT UNSIGNED
);

CREATE TABLE AvgHousehold(
                             AvgHouseID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

                             Year SMALLINT(4) UNSIGNED NOT NULL,

                             NumHouseholds INT UNSIGNED,

                             TypeID SMALLINT UNSIGNED NOT NULL,
                             CONSTRAINT FK_TypeID_AH
                                 FOREIGN KEY (TypeID) references DataType(TypeID)
                                     ON DELETE CASCADE
                                     ON UPDATE RESTRICT,

                             IncomeUnder15k DECIMAL(3,1),
                             Income15kTo25k DECIMAL(3,1),
                             Income25kTo35k DECIMAL(3,1),
                             Income35kTo50k DECIMAL(3,1),
                             Income50kTo75k DECIMAL(3,1),
                             Income75kTo100k DECIMAL(3,1),
                             Income100kTo150k DECIMAL(3,1),
                             Income150kTo200k DECIMAL(3,1),
                             Income200kAbove DECIMAL(3,1),
                             MedianIncome INT UNSIGNED,
                             AvgIncome INT UNSIGNED,
                             AvgNumMembers DECIMAL(3,2) UNSIGNED
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

                                 Year SMALLINT(4) UNSIGNED NOT NULL,
                                 AgeRange TEXT NOT NULL,
                                 Gender ENUM('Female','Male','All') NOT NULL,
                                 ProduceIntake DECIMAL(6,2) UNSIGNED,
                                 SugarIntake DECIMAL(6,3) UNSIGNED,
                                 FatIntake SMALLINT UNSIGNED,
                                 ProcessedIntake SMALLINT UNSIGNED

);

CREATE TABLE MetabolicDisease(
                                 MetaDisID BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

                                 LocationID SMALLINT UNSIGNED NOT NULL,
                                 CONSTRAINT FK_LocationID_MD
                                     FOREIGN KEY (LocationID) references Location(LocationID)
                                         ON DELETE CASCADE
                                         ON UPDATE RESTRICT,

                                 TypeID SMALLINT UNSIGNED NOT NULL,
                                 CONSTRAINT FK_TypeID_MD
                                     FOREIGN KEY (TypeID) references DataType(TypeID)
                                         ON DELETE CASCADE
                                         ON UPDATE RESTRICT,

                                 Year SMALLINT(4) UNSIGNED NOT NULL,
                                 AgeRange TEXT NOT NULL,
                                 Gender ENUM('Female', 'Male', 'All') NOT NULL,
                                 HeartDisease DECIMAL(5,2) UNSIGNED,
                                 Diabetes DECIMAL(5,2) UNSIGNED,
                                 Obesity DECIMAL(5,2) UNSIGNED,
                                 Cholesterol DECIMAL(5,2) UNSIGNED
);

CREATE TABLE FoodAssistance(
                               FoodAssistID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

                               LocationID SMALLINT UNSIGNED NOT NULL,
                               CONSTRAINT FK_LocationID_FS
                                   FOREIGN KEY (LocationID) references Location(LocationID)
                                       ON DELETE CASCADE
                                       ON UPDATE RESTRICT,

                               TypeID SMALLINT UNSIGNED NOT NULL,
                               CONSTRAINT FK_TypeID_FS
                                   FOREIGN KEY (TypeID) references DataType(TypeID)
                                       ON DELETE CASCADE
                                       ON UPDATE RESTRICT,

                               Name LONGTEXT NOT NULL,
                               Year SMALLINT(4) UNSIGNED,
                               numEnrolled BIGINT UNSIGNED

);

CREATE TABLE SchoolFoodPrograms(
                                   LunchProID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

                                   LocationID SMALLINT UNSIGNED NOT NULL,
                                   CONSTRAINT FK_LocationID_SLP
                                       FOREIGN KEY (LocationID) references Location(LocationID)
                                           ON DELETE CASCADE
                                           ON UPDATE RESTRICT,

                                   TypeID SMALLINT UNSIGNED NOT NULL DEFAULT 1,
                                   CONSTRAINT FK_TypeID_SLP
                                       FOREIGN KEY (TypeID) references DataType(TypeID)
                                           ON DELETE CASCADE
                                           ON UPDATE RESTRICT,

                                   Name LONGTEXT NOT NULL DEFAULT 'TEST',
                                   Year SMALLINT(4) UNSIGNED,
                                   numStudents BIGINT UNSIGNED

);

/* Load data into tables from files. */

/* Location Data */
LOAD DATA LOCAL INFILE './data/final-small/Location-small.txt' INTO TABLE Location FIELDS TERMINATED BY ',';

/* Data Type */
LOAD DATA LOCAL INFILE './data/final-small/DataType-small.txt' INTO TABLE DataType FIELDS TERMINATED BY ',';

/* Food Legislation Data */
LOAD DATA LOCAL INFILE './data/final-small/FoodLegislation-small.txt' INTO TABLE FoodLegislation FIELDS TERMINATED BY ',';

/* population Stats Data */
LOAD DATA LOCAL INFILE './data/final-small/PopulationStats-small.txt' INTO TABLE PopulationStats FIELDS TERMINATED BY ',';

/* Consumption Stats Data */
LOAD DATA LOCAL INFILE './data/final-small/ConsumptionStats-small.txt' INTO TABLE ConsumptionStats FIELDS TERMINATED BY ',';

/* Metabolic Disease Data */
LOAD DATA LOCAL INFILE './data/final-small/MetabolicDisease-small.txt' INTO TABLE MetabolicDisease FIELDS TERMINATED BY ',';

/* Food Assistance Data */
LOAD DATA LOCAL INFILE './data/final-small/FoodAssistance-small.txt' INTO TABLE FoodAssistance FIELDS TERMINATED BY ',';

/* School Lunch Program Data */
LOAD DATA LOCAL INFILE './data/final-small/SchoolFoodPrograms-small.txt' INTO TABLE SchoolFoodPrograms FIELDS TERMINATED BY ',';

/* Average Household Data */
LOAD DATA LOCAL INFILE './data/final-small/AvgHousehold-small.txt' INTO TABLE AvgHousehold FIELDS TERMINATED BY ',';


/* Lock tables that should be read-only (should be all tables eventually to prevent data deletion.) */
/*LOCK TABLES DataType READ;*/

# for louie:
#USE information_schema;

/*================= Stored Procedures =================*/
# DELETE PROCEDURE FOR LOCATION DATA
/* Get location information from given ID */

DELIMITER //
CREATE Procedure deleteLocationByNames (IN givenState VARCHAR(100), IN givenCounty VARCHAR(100), IN givenCity VARCHAR(100))
BEGIN

    SET @ID = getLocationID(givenState, givenCounty, givenCity);

# we first check if the given locationID is valid, if not add it in and continue
    IF EXISTS (SELECT * FROM Location WHERE LocationID = @ID) THEN
        delete Location from Location where LocationID=@ID;
    ELSE
        select -1 as result;
    END IF;

END;
//

DELIMITER //
CREATE FUNCTION getLocationID (givenState VARCHAR(100), givenCounty VARCHAR(100), givenCity VARCHAR(100))
    RETURNS INT DETERMINISTIC
BEGIN

    DECLARE id INT;

    if (givenCounty is NULL || givenCounty=' ' || givenCounty='') then
        return (select locationID from Location where state=givenState and (county=' ' or county='') order by locationID asc limit 1);

    elseif (givenCity is Null || givenCity=' ' || givenCity='') then
        return (select locationID from Location where state=givenState and county=givenCounty and (city=' ' or city IS NULL or city='') limit 1);
    else
        return (select locationID from Location where state=givenState and county=givenCounty and City=givenCity limit 1);
    end if;


END; //
DELIMITER ;

/* DELETION FOR SFP BELOW*/
DELIMITER //
CREATE Procedure deleteSFP (IN givenState VARCHAR(100), IN givenName VARCHAR(100), IN givenYear INT)
BEGIN

    SET @ID = getSFPID(givenState, givenName, givenYear);

# we first check if the given locationID is valid, if not add it in and continue
    IF EXISTS (SELECT * FROM SchoolFoodPrograms WHERE LunchProID = @ID) THEN
        delete SchoolFoodPrograms from SchoolFoodPrograms where LunchProID=@ID;
    ELSE
        select -1 as result;
    END IF;

END;
//


DELIMITER //
CREATE FUNCTION getSfpID (givenState VARCHAR(100), givenName VARCHAR(100), givenYear INT) RETURNS INT DETERMINISTIC
BEGIN

    DECLARE locID INT;

    set @locID = getLocationID(givenState, '','');

    return (select LunchProID from SchoolFoodPrograms where locationID = @locID and Name=givenName and Year=givenYear limit 1);


END; //
DELIMITER ;

/* DELETION FOR FA BELOW*/
DELIMITER //
CREATE Procedure deleteFA (IN givenState VARCHAR(100), IN givenName VARCHAR(100), IN givenYear INT)
BEGIN

    SET @ID = getFAID(givenState, givenName, givenYear);

# we first check if the given locationID is valid, if not add it in and continue
    IF EXISTS (SELECT * FROM FoodAssistance WHERE FoodAssistID = @ID) THEN
        delete FoodAssistance from FoodAssistance where FoodAssistID=@ID;
    ELSE
        select -1 as result;
    END IF;

END;
//


DELIMITER //
CREATE FUNCTION getFAID (givenState VARCHAR(100), givenName VARCHAR(100), givenYear INT) RETURNS INT DETERMINISTIC
BEGIN

    DECLARE locID INT;

    set @locID = getLocationID(givenState, '','');

    return (select FoodAssistID from FoodAssistance where locationID = @locID and Name=givenName and Year=givenYear limit 1);


END; //
DELIMITER ;
