/* Script that contains 15 data queries
 *
 * Louie DiBernardo (LDIBERN1)
 * Sanddhya Jayabalan (SJAYABA1)
*/

/*============================================================================*/
/** Q1
  * Is there a significant trend between sugar intake and heart disease in adults per year? (Specifically in CA) - Adapted question #9 from PhaseA
  */
select CL.State, CL.ConsumptionYear, ConsumptionGender, SugarIntake, HeartDisease
from (select State, Year as ConsumptionYear, Gender as ConsumptionGender, SugarIntake
      from ConsumptionStats left join Location Loc on Loc.LocationID = ConsumptionStats.LocationID
      where State='California' and ConsumptionStats.AgeRange='18+') as CL
    left join
    (select Year as MetabolicYear, Gender as MetabolicGender, AVG(HeartDisease) as HeartDisease
     from MetabolicDisease left join Location temp on temp.LocationID=MetabolicDisease.LocationID
     where State='California' and MetabolicDisease.AgeRange='Ages 35-64 years' group by Gender,Year) as ML
    on (ML.MetabolicYear=CL.ConsumptionYear and ML.MetabolicGender=CL.ConsumptionGender);


/*============================================================================*/
/** Q2
  * Which state has worked to pass the most legislative bills related to food, health and nutrition and how hasthe rates of metabolic disease changed in this state over the years? (Specifically in CA) - Adapted question #10 from PhaseA
  *
  * I think displaying two separate tables would be best for this question. One table with the number of bills passed, and
  * another with the changes in MetabolicDisease rates over the years.
  *
  * Perhaps for the second query, we should only select the first and last year of available data so we can more obviously
  * see the change.
  */

select Location.State, Count(FoodLegislation.BillName) as 'Number of Food Bills Passed'
from FoodLegislation left join Location on Location.LocationID=FoodLegislation.LocationID and FoodLegislation.LocationID=Location.LocationID;

select State, Year, Gender, AgeRange, HeartDisease
from MetabolicDisease left join Location on Location.State='California' and MetabolicDisease.LocationID = Location.LocationID
Order by Year;

/*============================================================================*/
/** Q3
  * NEW QUESTION:
  * In the year with the highest sugar intake, how many people were enrolled in FoodAssistance programs? (Specifically in CA)
  *
  */

select ConsumptionStats.Year as 'Year with Maximum Sugar Intake', MAX(SugarIntake) as 'Maximum Sugar Intake',
       (select SUM(numEnrolled) as 'EnrollmentNumbers'
        from FoodAssistance left join Location on FoodAssistance.LocationID = Location.LocationID and Location.State='California'
        where Year=ConsumptionStats.Year) as numEnrolled
from ConsumptionStats left join Location on ConsumptionStats.LocationID = Location.LocationID and Location.State='California';

# We can use the following query for this same question to select the state with the highest sugar intake.
select Year, State, Max(totalSugar) as 'Sugar intake this year',
       (select SUM(numEnrolled)
        from FoodAssistance left join Location on FoodAssistance.LocationID = Location.LocationID
        where year=sugarIntake.Year and Location.State=sugarIntake.State
        group by year) as 'Number of people enrolled this year'
from (select Year, State, SUM(SugarIntake) as 'totalSugar'
      from ConsumptionStats left join Location on ConsumptionStats.LocationID = Location.LocationID
      where (Gender='Female' or Gender='Male')
      group by Year
      order by totalSugar DESC) as sugarIntake;

/*============================================================================*/
/** Q4
  * NEW QUESTION:
  * Does the state with the highest number of people enrolled in food assistance programs also have the highest number of students
  * enrolled in school programs in the same year? (Specifically in CA)
  *
  * Currently, designed to be displayed in two different tables.
  */

select State, Year, MAX(sumEnrolled)
from (select State, Year, SUM(FoodAssistance.numEnrolled) as 'sumEnrolled'
      from FoodAssistance left join Location on FoodAssistance.locationID=Location.locationID
      where State='California'
      group by year
      order by sumEnrolled DESC) as enrollmentInfo;

select State, Year, MAX(sumEnrolled)
from (select State, Year, SUM(SchoolFoodPrograms.numStudents) as 'sumEnrolled'
      from SchoolFoodPrograms left join Location on SchoolFoodPrograms.locationID=Location.locationID
      where State='California'
      group by year
      order by sumEnrolled DESC) as enrollmentInfo;


/** SIMILAR QUESTION TO LAST BUT CHANGE A LITTLE TO MAKE IT ONE QUERY.
  * In the year with the highest number of people enrolled in Food assistance programs, how many students were enrolled in the
  * school food programs in that same year?
  *
  */

select FoodAssistanceSummed.State, FoodAssistanceSummed.Year, MAX(FoodAssistanceSummed.sumEnrolled) as 'Number of people enrolled in Food Assistance programs',
       (select SUM(numStudents) as 'sumStudents'
        from SchoolFoodPrograms left join Location on SchoolFoodPrograms.locationID=Location.locationID
        where Year=FoodAssistanceSummed.Year and State=FoodAssistanceSummed.State
        Group by year, State
        order by sumStudents DESC) as 'Number of students enrolled in SchoolFoodPrograms'
from (select State, Year, SUM(numEnrolled) as 'sumEnrolled'
      from FoodAssistance left join Location on FoodAssistance.locationID=Location.locationID
      Group by year, State
      Order By sumEnrolled DESC) as FoodAssistanceSummed;

/*============================================================================*/
/** Q5
* Is there a significant trend between childhood metabolic rates and number of students enrolled in SchoolFoodPrograms?  - (Specifically in CA) - Adapted from question #18 from PhaseA
*
*/
select SYA.State as State, SYA.Year as Year, SYA.Obesity as 'Obesity Rate', SYS.numEnrolled as 'Number of students enrolled in SFP'
from (select State, Year, AVG(Obesity) as Obesity
      from MetabolicDisease left join Location L on L.LocationID = MetabolicDisease.LocationID
      where State='California' and Gender='All'
      group by Year) as SYA
      left join
     (select State, Year, SUM(numStudents) as numEnrolled
      from SchoolFoodPrograms left join Location L on SchoolFoodPrograms.LocationID = L.LocationID
      where State='California'
      group by Year) as SYS
      on SYA.Year=SYS.Year;


/*============================================================================*/
/** Q6
  * NEW QUESTION:
  *
  * Does the state with the highest number of food bills passed have less people enrolled in Food assistance programs compared to
  * states with less food bills?
  *
  * Note: will be comparing latest data year possible for comparisons.
  * In our website, we should have a toggle or something for the user to be able to switch the sort order from People enrolled, to numBills.
 */

# need to set this variable first before running the actual selection queries.
Set @MaxYear = (select MAX(Year) as Year from FoodAssistance);

# Below query is sorted by number of people enrolled in FA
select SC.State, numBills, PeopleEnrolled
from (select State, COUNT(LegislationID) as 'numBills' from FoodLegislation left join Location L on L.LocationID = FoodLegislation.LocationID group by State) as SC
left join (select State, SUM(numEnrolled) as 'PeopleEnrolled' from FoodAssistance left join Location L on L.LocationID = FoodAssistance.LocationID where year=@MaxYear group by State) as SS
on SC.State=SS.State
order by PeopleEnrolled desc;

# Below query is sorted by number of Food Legislation bills passed
select SC.State, numBills, PeopleEnrolled
from (select State, COUNT(LegislationID) as 'numBills' from FoodLegislation left join Location L on L.LocationID = FoodLegislation.LocationID group by State) as SC
         left join (select State, SUM(numEnrolled) as 'PeopleEnrolled' from FoodAssistance left join Location L on L.LocationID = FoodAssistance.LocationID where year=@MaxYear group by State) as SS
                   on SC.State=SS.State
order by numBills desc;

/*============================================================================*/
/** Q7
  * NEW QUESTION
  * Do the genders that have the worst (highest) consumption in sugar also have the highest rates of metabolic disease?
  *
 */

select * from ConsumptionStats;

# New potential question: Did the county as a whole during recent years shift wealth further down or up? If down, did states respond by passing more food legislation bills in the following years?