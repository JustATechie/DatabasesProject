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
  * Deleting previously inserted data from SchoolFoodPrograms. No foegin key issues upon deletion.
  *
 */
delete SchoolFoodPrograms from SchoolFoodPrograms where SchoolFoodPrograms.LunchProID='32000';