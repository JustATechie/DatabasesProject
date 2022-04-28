/* Script that contains performs a
 *
 * Louie DiBernardo (LDIBERN1)
 * Sanddhya Jayabalan (SJAYABA1)
*/

/**
  * Notes: We have included two sql queries right now that insert and delete a tuple into SchoolFoodPrograms.

  * NOTE FOR SANDDHYA: Not sure how we will deal with the second portion of Part 2. We currently have location data
  * for all cities in the US, so we don't exacltly have an instance in which a foregin key will not exist.
  * I suppose after we removed extraneous locations, we could have this issue, but we would require the user to provide
  * that location data to us.
 */






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
  * In this case the user would have to provide us with the state, county, and city that they wish to add.
  *
  * This example assumes none of that, but that the user has provided just a locationID for something we do
  * not have in the database. First we will check if that ID exists, and if not, then add it to the parent table
  * and then try to insert the data.
  *
 */


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



