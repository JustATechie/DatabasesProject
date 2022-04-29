/* Script that contains performs a
 *
 * Louie DiBernardo (LDIBERN1)
 * Sanddhya Jayabalan (SJAYABA1)
*/

/*============================================================================*/
# Insert Section

/**
  * Inserting new data for SchoolFoodPrograms into table. ALl foreign keys exist.
  *
  */
insert into SchoolFoodPrograms values (32000, 5, 1, 'NSLP', 2021, 1800000);

/**
  * Inserting new data for ConsumptionStats into table. ALl foreign keys exist.
  *
 */
insert into ConsumptionStats values (50, 5, 1,2021,'65+','Female',20.3,0.25,30.38,60.89);

/**
  * Ideally when the user inserts data, we would have them select the state and county from dropdowns to
  * ensure the proper locationID is used. However, the user may want to insert data down to the city level.
  * In this case the user would have to provide us with the state, county, and city that they wish to add and
  * we would generate an id number for the database. This would mean that it would be impossible to run into
  * missing foreign key constraint issues with how we currently have things set and plan to set up for PhaseE.
  *
  * This example assumes none of that, but that the user has provided just a locationID for something we do
  * not have in the database. First we will check if that ID exists, and if not, then add it to the parent table
  * and then try to insert the data.
  *
  * Assuming the following:
  * given an invalid locationID
  * given a state name
  * given a county name
  * given a city name
  * given all other data for SchoolFoodPrograms as well.
 */

DROP PROCEDURE IF EXISTS insertInvalidForeignKeyEx;

DELIMITER //
CREATE Procedure insertInvalidForeignKeyEx (IN givenID int, IN newState varchar(100), IN newCounty varchar(100), IN newCity varchar(100),
IN newLunchProID int, IN newTypeID int, IN newName varchar(100), IN newYear int, IN newNumStudents int)
BEGIN

    # we first check if the given locationID is valid, if not add it in and continue
    IF NOT EXISTS (SELECT * FROM Location WHERE LocationID = @givenID) THEN
        insert into Location values (givenID, newState, newCounty, newCity, null);
    END IF;

    insert into SchoolFoodPrograms values (newLunchProID,givenID,newTypeID,newName,newYear,newNumStudents);

END;
//
DELIMITER ;

call insertInvalidForeignKeyEx(50001, 'Test','Test','Test', 1000, 1, 'test',2022, 0);

#debug statements to make sure data is inserted properly.
select * from SchoolFoodPrograms where LunchProID=1000;
select * from Location where LocationID=50001;


/*============================================================================*/
# Delete Section

/**
  * Deleting previously inserted data from SchoolFoodPrograms. No foreign key issues upon deletion.
  *
 */
delete SchoolFoodPrograms from SchoolFoodPrograms where SchoolFoodPrograms.LunchProID='32000';

/**
  * Deleting previously inserted data from ConsumptionStats. No foreign key issues upon deletion.
  *
 */
delete ConsumptionStats from ConsumptionStats where ConsumptionStats.ConStatID=50;


/**
  * Deleting previous inserted data from missing foreign key example.
  * Deleting the location entry only, would also delete all entries in other tables that have that locationID as a foreign key.
  *
 */
delete Location from Location where LocationID=50001;