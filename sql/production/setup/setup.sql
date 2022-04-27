/* Script for database setup with small dataset.
 *
 * Louie DiBernardo (LDIBERN1)
 * Sanddhya Jayabalan (SJAYABA1)
*/

/*********** Begin Test Setup ***********/

/* Create and select new database. */
#CREATE DATABASE 22sp_ldibern1_db;
#USE 22sp_ldibern1_db;

/* Create Parent Tables */
CREATE TABLE DataType(
                         TypeID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
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

/*CREATE TABLE Food(
                     FoodID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
                     Name LONGTEXT,
                     Brand LONGTEXT,
                     Type ENUM('cereal','test','ebola')
);*/

/* Create child tables. */

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

                             IncomeUnder15k DECIMAL(4,1),
                             Income15kTo25k DECIMAL(4,1),
                             Income25kTo35k DECIMAL(4,1),
                             Income35kTo50k DECIMAL(4,1),
                             Income50kTo75k DECIMAL(4,1),
                             Income75kTo100k DECIMAL(4,1),
                             Income100kTo150k DECIMAL(4,1),
                             Income150kTo200k DECIMAL(4,1),
                             Income200kAbove DECIMAL(4,1),
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

/*CREATE TABLE FoodInitiatives(
                                FoodID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

                                LocationID SMALLINT UNSIGNED NOT NULL,
                                CONSTRAINT FK_LocationID_FI
                                    FOREIGN KEY (LocationID) references Location(LocationID)
                                        ON DELETE CASCADE
                                        ON UPDATE RESTRICT,

                                TypeID SMALLINT UNSIGNED NOT NULL,
                                CONSTRAINT FK_TypeID_FI
                                    FOREIGN KEY (TypeID) references DataType(TypeID)
                                        ON DELETE CASCADE
                                        ON UPDATE RESTRICT,

                                Name LONGTEXT NOT NULL,
                                AgeRange VARCHAR(20),
                                Genders ENUM('female', 'male', 'both')

);*/

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

                                   TypeID SMALLINT UNSIGNED NOT NULL,
                                   CONSTRAINT FK_TypeID_SLP
                                       FOREIGN KEY (TypeID) references DataType(TypeID)
                                           ON DELETE CASCADE
                                           ON UPDATE RESTRICT,

                                   Name LONGTEXT NOT NULL,
                                   Year SMALLINT(4) UNSIGNED,
                                   numStudents BIGINT UNSIGNED

);

/*CREATE TABLE FoodInitiativesCreated(
                                       InitiativeID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

                                       LocationID SMALLINT UNSIGNED NOT NULL,
                                       CONSTRAINT FK_LocationID_FIC
                                           FOREIGN KEY (LocationID) references Location(LocationID)
                                               ON DELETE CASCADE
                                               ON UPDATE RESTRICT,

                                       TypeID SMALLINT UNSIGNED NOT NULL,
                                       CONSTRAINT FK_TypeID_FIC
                                           FOREIGN KEY (TypeID) references DataType(TypeID)
                                               ON DELETE CASCADE
                                               ON UPDATE RESTRICT,

                                       Name LONGTEXT NOT NULL,
                                       StartYear SMALLINT(4) UNSIGNED,
                                       EndYear SMALLINT(4) UNSIGNED

);*/

/*CREATE TABLE NutritionalValue(
                                 ValueID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

                                 FoodID SMALLINT UNSIGNED NOT NULL,
                                 CONSTRAINT FK_FoodID_NV
                                     FOREIGN KEY (FoodID) references Food(FoodID)
                                         ON DELETE CASCADE
                                         ON UPDATE RESTRICT,

                                 Calories SMALLINT UNSIGNED,
                                 Sugars SMALLINT UNSIGNED,
                                 Fats SMALLINT UNSIGNED,
                                 Sodium SMALLINT UNSIGNED

);*/


/*CREATE TABLE FoodConsumption(
                                ConsumptionID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

                                LocationID SMALLINT UNSIGNED NOT NULL,
                                CONSTRAINT FK_LocationID_FC
                                    FOREIGN KEY (LocationID) references Location(LocationID)
                                        ON DELETE CASCADE
                                        ON UPDATE RESTRICT,

                                TypeID SMALLINT UNSIGNED NOT NULL,
                                CONSTRAINT FK_TypeID_FC
                                    FOREIGN KEY (TypeID) references DataType(TypeID)
                                        ON DELETE CASCADE
                                        ON UPDATE RESTRICT,

                                FoodID SMALLINT UNSIGNED NOT NULL,
                                CONSTRAINT FK_FoodID_FC
                                    FOREIGN KEY (FoodID) references Food(FoodID)
                                        ON DELETE CASCADE
                                        ON UPDATE RESTRICT,

                                Year SMALLINT(4) UNSIGNED NOT NULL,
                                Age SMALLINT(3) UNSIGNED NOT NULL,
                                AmountConsumed SMALLINT UNSIGNED
);*/

/*CREATE TABLE FoodDistribution(
                                 DistributionID SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,

                                 LocationID SMALLINT UNSIGNED NOT NULL,
                                 CONSTRAINT FK_LocationID_FD
                                     FOREIGN KEY (LocationID) references Location(LocationID)
                                         ON DELETE CASCADE
                                         ON UPDATE RESTRICT,

                                 TypeID SMALLINT UNSIGNED NOT NULL,
                                 CONSTRAINT FK_TypeID_FD
                                     FOREIGN KEY (TypeID) references DataType(TypeID)
                                         ON DELETE CASCADE
                                         ON UPDATE RESTRICT,

                                 FoodID SMALLINT UNSIGNED NOT NULL,
                                 CONSTRAINT FK_FoodID_FD
                                     FOREIGN KEY (FoodID) references Food(FoodID)
                                         ON DELETE CASCADE
                                         ON UPDATE RESTRICT,

                                 Year SMALLINT(4) UNSIGNED NOT NULL,
                                 amountDistributed SMALLINT UNSIGNED
);*/


/* Load data into tables from files. */

/* Location Data */
#LOAD DATA LOCAL INFILE './data/final/Location.txt' INTO TABLE Location FIELDS TERMINATED BY ',';

/* Reduced Location Data */
LOAD DATA LOCAL INFILE './data/final/Location - Reduced.txt' INTO TABLE Location FIELDS TERMINATED BY ',';

/* Data Type */
LOAD DATA LOCAL INFILE './data/final/DataType.txt' INTO TABLE DataType FIELDS TERMINATED BY ',';

/* Food Legislation Data */
#LOAD DATA LOCAL INFILE './data/final/FoodLegislation.txt' INTO TABLE FoodLegislation FIELDS TERMINATED BY ',';

/* Reduced Food Legislation Data */
LOAD DATA LOCAL INFILE './data/final/FoodLegislation - Reduced.txt' INTO TABLE FoodLegislation FIELDS TERMINATED BY ',';

/* population Stats Data */
LOAD DATA LOCAL INFILE './data/final/PopulationStats.txt' INTO TABLE PopulationStats FIELDS TERMINATED BY ',';

/* Consumption Stats Data */
LOAD DATA LOCAL INFILE './data/final/ConsumptionStats.txt' INTO TABLE ConsumptionStats FIELDS TERMINATED BY ',';

/* Metabolic Disease Data */
#LOAD DATA LOCAL INFILE './data/final/MetabolicDisease.txt' INTO TABLE MetabolicDisease FIELDS TERMINATED BY ',';

/* Reduced Metabolic Disease Data */
LOAD DATA LOCAL INFILE './data/final/MetabolicDisease - Reduced.txt' INTO TABLE MetabolicDisease FIELDS TERMINATED BY ',';

/* Food Assistance Data */
LOAD DATA LOCAL INFILE './data/final/FoodAssistance.txt' INTO TABLE FoodAssistance FIELDS TERMINATED BY ',';

/* School Lunch Program Data */
LOAD DATA LOCAL INFILE './data/final/SchoolFoodPrograms.txt' INTO TABLE SchoolFoodPrograms FIELDS TERMINATED BY ',';

/* Average Household Data */
LOAD DATA LOCAL INFILE './data/final/AvgHousehold.txt' INTO TABLE AvgHousehold FIELDS TERMINATED BY ',';

/********/

/* Data Type - Local Example */
#LOAD DATA LOCAL INFILE '/home/justatechie/IdeaProjects/DatabasesProject/data/final/DataType.txt' INTO TABLE DataType FIELDS TERMINATED BY ',';

/* Lock tables that should be read-only (should be all tables eventually to prevent data deletion.) */
/*LOCK TABLES DataType READ;*/

# for louie:
#USE information_schema;