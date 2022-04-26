/* Script that contains 15 data queries
 *
 * Louie DiBernardo (LDIBERN1)
 * Sanddhya Jayabalan (SJAYABA1)
*/

/**
  * Is there a significant trend between sugar intake and heart disease in adults per year? (Specifically in CA) - Adapted question #9 from PhaseA
  */

select Distinct Location.State, ConsumptionStats.Year, ConsumptionStats.AgeRange, ConsumptionStats.Gender, SugarIntake, MetabolicDisease.HeartDisease
from Location, ConsumptionStats left join MetabolicDisease on MetabolicDisease.Year=ConsumptionStats.Year
where ConsumptionStats.AgeRange='18+' and MetabolicDisease.AgeRange='Ages 35-64 years'
and ConsumptionStats.Gender=MetabolicDisease.Gender and Location.LocationID=MetabolicDisease.LocationID and Location.State='California';

/**
  * Which state has worked to pass the most legislative bills related to food, health and nutrition and how hasthe rates of metabolic disease changed in this state over the years? (Specifically in CA) - Adapted question #10 from PhaseA
  *
  * I think displaying two separate tables would be best for this question. One table with the number of bills passed, and
  * another with the changes in MetabolicDisease rates over the years.
  *
  * Perhaps for the second query, we should only select the first and last year of available data so we can more obviously
  * see the change.
  */

select Location.State, Count(FoodLegislation.BillName) as 'Number of Food Bills Passed'
from FoodLegislation left join Location on Location.State='California' and FoodLegislation.LocationID=Location.LocationID;

select State, Year, Gender, AgeRange, HeartDisease
from MetabolicDisease left join Location on Location.State='California' and MetabolicDisease.LocationID = Location.LocationID
Order by Year;


/**
  * NEW QUESTION:
  * The state with the highest sugar intake, how many residents are enrolled in food assistance programs?
  *
  *
  */

select ConsumptionStats.Year as 'Year with Maximum Sugar Intake', MAX(SugarIntake) as 'Maximum Sugar Intake',
       (select SUM(numEnrolled) as 'EnrollmentNumbers' from FoodAssistance left join Location on FoodAssistance.LocationID = Location.LocationID and Location.State='California' where Year=ConsumptionStats.Year) as numEnrolled
from ConsumptionStats left join Location on ConsumptionStats.LocationID = Location.LocationID and Location.State='California';





/**
  * NEW QUESTION:
  * Does the state with the highest number of people enrolled in food assistance programs also have the highest number of students
  * enrolled in school programs? (Specifically in CA)
  *
  */

/**
* How many students with childhood metabolic disease are enrolled in school lunch assistance programs? - (Specifically in CA) - Adapted from question #18 from PhaseA
*
*/