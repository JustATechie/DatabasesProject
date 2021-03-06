/* Script to clean up test database.
 *
 * Louie DiBernardo (LDIBERN1)
 * Sanddhya Jayabalan (SJAYABA1)
*/

/*********** Begin Cleanup ***********/

/* Select the right database */
#USE 22sp_ldibern1_db;

/* Unlock tables so we can remove them all */
UNLOCK TABLES;

/* Drop any and all tables/functions that already exist. */
/* Child Tables */
DROP TABLE IF EXISTS AvgHousehold;
DROP TABLE IF EXISTS FoodLegislation;
DROP TABLE IF EXISTS PopulationStats;
DROP TABLE IF EXISTS AvgHousehold;
DROP TABLE IF EXISTS ConsumptionStats;
DROP TABLE IF EXISTS MetabolicDisease;
DROP TABLE IF EXISTS FoodAssistance;
DROP TABLE IF EXISTS SchoolFoodPrograms;

/* Parent Tables */
DROP TABLE IF EXISTS DataType;
DROP TABLE IF EXISTS Location;

/* Functions */
# from PhaseD
DROP PROCEDURE IF EXISTS insertInvalidForeignKeyEx;

#PhaseE
Drop Procedure IF EXISTS getLocationInfo;
DROP PROCEDURE IF EXISTS deleteLocationByNames;
DROP FUNCTION IF EXISTS getLocationID;
DROP PROCEDURE IF EXISTS deleteSFP;
DROP FUNCTION IF EXISTS getSfpID;
DROP PROCEDURE IF EXISTS deleteFA;
DROP FUNCTION IF EXISTS getFAID;

/* Drop Database */
#DROP DATABASE IF EXISTS 22sp_ldibern1_db;

/*********** End cleanup ***********/