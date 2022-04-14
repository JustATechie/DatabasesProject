/* Script to clean up test database.
 *
 * Louie DiBernardo (LDIBERN1)
 * Sanddhya Jayabalan (SJAYABA1)
*/

/*********** Begin Cleanup ***********/

/* Select the right database */
USE 22sp_ldibern1_db;

/* Unlock tables so we can remove them all */
UNLOCK TABLES;

/* Drop any and all tables/functions that already exist. */
/* Child Tables */
DROP TABLE IF EXISTS FoodLegislation;
DROP TABLE IF EXISTS PopulationStats;
DROP TABLE IF EXISTS AvgHousehold;
DROP TABLE IF EXISTS ConsumptionStats;
DROP TABLE IF EXISTS MetabolicDisease;
DROP TABLE IF EXISTS FoodInitiatives;
DROP TABLE IF EXISTS FoodStamps;
DROP TABLE IF EXISTS FoodAssistance;
DROP TABLE IF EXISTS SchoolFoodPrograms;
DROP TABLE IF EXISTS FoodInitiativesCreated;
DROP TABLE IF EXISTS NutritionalValue;
DROP TABLE IF EXISTS FoodConsumption;
DROP TABLE IF EXISTS FoodDistribution;

/* Parent Tables */
DROP TABLE IF EXISTS DataType;
DROP TABLE IF EXISTS Location;
DROP TABLE IF EXISTS Food;

/* Functions */
DROP FUNCTION IF EXISTS FilePath;

/* Drop Database */
DROP DATABASE IF EXISTS 22sp_ldibern1_db;

/*********** End cleanup ***********/