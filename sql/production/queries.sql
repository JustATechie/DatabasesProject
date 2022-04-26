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
  * In the year with the highest sugar intake, how many people were enrolled in FoodAssistance programs? (Specifically in CA)
  *
  */

select ConsumptionStats.Year as 'Year with Maximum Sugar Intake', MAX(SugarIntake) as 'Maximum Sugar Intake',
       (select SUM(numEnrolled) as 'EnrollmentNumbers' from FoodAssistance left join Location on FoodAssistance.LocationID = Location.LocationID and Location.State='California' where Year=ConsumptionStats.Year) as numEnrolled
from ConsumptionStats left join Location on ConsumptionStats.LocationID = Location.LocationID and Location.State='California';

# We can use the following query for this same question to select the state with the highest sugar intake.
select Year, State, Max(totalSugar) as 'Sugar intake this year',
       (select SUM(numEnrolled) from FoodAssistance left join Location on FoodAssistance.LocationID = Location.LocationID where year=sugarIntake.Year and Location.State=sugarIntake.State group by year) as 'Number of people enrolled this year'
from (select Year, State, SUM(SugarIntake) as 'totalSugar' from ConsumptionStats left join Location on ConsumptionStats.LocationID = Location.LocationID where (Gender='Female' or Gender='Male') group by Year order by totalSugar DESC) as sugarIntake;




/**
  * NEW QUESTION:
  * Does the state with the highest number of people enrolled in food assistance programs also have the highest number of students
  * enrolled in school programs in the same year? (Specifically in CA)
  *
  * Currently, designed to be displayed in two different tables.
  */

select State, Year, MAX(sumEnrolled)
from (select State, Year, SUM(FoodAssistance.numEnrolled) as 'sumEnrolled' from FoodAssistance left join Location on FoodAssistance.locationID=Location.locationID where State='California' group by year order by sumEnrolled DESC) as enrollmentInfo;

select State, Year, MAX(sumEnrolled)
from (select State, Year, SUM(SchoolFoodPrograms.numStudents) as 'sumEnrolled' from SchoolFoodPrograms left join Location on SchoolFoodPrograms.locationID=Location.locationID where State='California' group by year order by sumEnrolled DESC) as enrollmentInfo;


/** SIMILAR QUESTION TO LAST BUT CHANGE A LITTLE TO MAKE IT ONE QUERY.
  * In the year with the highest number of people enrolled in Food assistance programs, how many students were enrolled in the
  * school food programs in that same year?
  *
  */

select FoodAssistanceSummed.State, FoodAssistanceSummed.Year, MAX(FoodAssistanceSummed.sumEnrolled) as 'Number of people enrolled in Food Assistance programs',
       (select SUM(numStudents) as 'sumStudents' from SchoolFoodPrograms left join Location on SchoolFoodPrograms.locationID=Location.locationID where Year=FoodAssistanceSummed.Year and State=FoodAssistanceSummed.State Group by year order by sumStudents DESC)
                                                                                                    as 'Number of students enrolled in SchoolFoodPrograms'
from (select State, Year, SUM(numEnrolled) as 'sumEnrolled' from FoodAssistance left join Location on FoodAssistance.locationID=Location.locationID Group by year Order By sumEnrolled DESC) as FoodAssistanceSummed;



/**
* How many students with childhood metabolic disease are enrolled in school lunch assistance programs? - (Specifically in CA) - Adapted from question #18 from PhaseA
*
*/