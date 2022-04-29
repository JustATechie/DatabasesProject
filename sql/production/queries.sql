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
  * Which state has worked to pass the most legislative bills related to food, health and nutrition and how hasthe rates of metabolic disease changed in this state over the years? - Adapted question #10 from PhaseA
  *
  * Here we use some variables to select the state that has passed the most bills, and the min and max year of available data to finally
  * select and average the data we need.
  *
  * Perhaps we should also display a second table that contains the state name, and the number of bills passed in that state?
  */

SET @Q2State = (select State
              from (select State, MAX(numPassed)
                    from (select Location.State, Count(FoodLegislation.BillName) as numPassed
                          from FoodLegislation left join Location on FoodLegislation.LocationID=Location.LocationID
                          group by State
                          order by numPassed DESC) as BillCount)as stateCount);

select @Q2State;

SET @Q2MinYear = (select MIN(Year) from MetabolicDisease);

SET @Q2MaxYear = (select MAX(Year) from MetabolicDisease);

select State, Year, Gender, AgeRange, AVG(HeartDisease)
from MetabolicDisease left
    join Location on (MetabolicDisease.LocationID = Location.LocationID)
where State=@Q2State and (Year=@Q2MinYear or Year=@Q2MaxYear) and (AgeRange='Ages 35-64 years' or AgeRange='Ages 65+ years')
group by Year,AgeRange,Gender;


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
select GAS.Gender,AVGSugar as 'Average sugar intake',AVGHeart as 'Number of people per 100,00 with heart disease'
from (select Gender,AVG(SugarIntake) as 'AVGSugar' from ConsumptionStats where (Gender='Female' or Gender='Male') group by Gender) GAS
     left join
     ((select Gender,AVG(HeartDisease) as 'AVGHeart' from MetabolicDisease where (Gender='Female' or Gender='Male') and (AgeRange='Ages 35-64 years' or AgeRange='Ages 65+ years') group by Gender) as GAH)
     on GAS.Gender=GAH.Gender;

/*============================================================================*/
/** Q8
  * NEW QUESTION
  * Did the county as a whole during recent years shift wealth further down or up?
  * If up, did states respond by passing more food legislation bills in the following years?
  *
  * Using some parameters that the user would give us when interacting with the site.
  * MaxYear=2015,MinYear=2000
  * right now we compare numbers of those over 200k salary, but we could also compare avg income overall.
  *
  * to be displayed as two separate tables to make better understanding of data.
 */

#Set @Q8MaxYear = (select MAX(Year) as Year from AvgHousehold);
#Set @Q8MinYear = (select MIN(Year) as Year from AvgHousehold);

select Year,Income200kAbove from AvgHousehold where (year = 2015 or year=2000) order by year;

select YearPassed,sum(LegislationID) from FoodLegislation where yearPassed>=2015 group by YearPassed;


/*============================================================================*/
/** Q9
  * What is the prevalence of metabolic disease in kids for the year with highest and lowest school enrollment rate? 
  * (Adapted from question 3 of PhaseA)
 */

SELECT State, MinEnrolled, MinEnrolledYear, minYearObesity, MaxEnrolled, MaxEnrolledYear, AVG(Obesity) as maxYearObesity
FROM
(SELECT State, MinEnrolled, MinEnrolledYear, MaxEnrolled, MaxEnrolledYear, AVG(Obesity) as minYearObesity
FROM
        (SELECT State, MinEnrolled, PopulationStats.Year as "MinEnrolledYear", MaxEnrolled, MaxEnrolledYear
        FROM
        (SELECT State, MaxEnrolled, PopulationStats.Year as "MaxEnrolledYear", MinEnrolled
        FROM
                (SELECT State, Year, MAX(SchoolEnrollment) as "MaxEnrolled", MIN(SchoolEnrollment) as "MinEnrolled"
                FROM Location NATURAL JOIN PopulationStats
                WHERE Year <= "2022"
                GROUP BY State) as maxMinEnrolled
                JOIN PopulationStats
                ON PopulationStats.SchoolEnrollment = maxMinEnrolled.MaxEnrolled AND PopulationStats.Year <= "2022") as maxEnrollments
                JOIN PopulationStats
                ON PopulationStats.SchoolEnrollment = maxEnrollments.MinEnrolled AND PopulationStats.Year <= "2022") enrollmentYears
        LEFT JOIN
        MetabolicDisease
        ON AgeRange <> "Ages 35-64 years" AND AgeRange <> "Ages 65+ years" AND MetabolicDisease.Year = enrollmentYears.MinEnrolledYear
GROUP BY State
ORDER BY minYearObesity ASC) as minObesity
LEFT JOIN
MetabolicDisease
ON AgeRange <> "Ages 35-64 years" AND AgeRange <> "Ages 65+ years" AND MetabolicDisease.Year = minObesity.MaxEnrolledYear
GROUP BY State
ORDER BY minYearObesity DESC, maxYearObesity DESC, State ASC;

/*============================================================================*/
/** Q10
  * What was the average, minimum, and maximum level of childhood objesity by state in the years after the intiation of the “No Kid Hungry” initiative?
  * (Adapted from questions 1 and 7 from PhaseA)
 */
 
SELECT State, avgObesity, minObesity, minObesityYear, maxObesity, maxObesityYear
FROM
        (SELECT *
        FROM
                (SELECT State, AVG(Obesity) AS avgObesity, MAX(Obesity) AS minObesity, MIN(Obesity) AS maxObesity
                FROM
                (SELECT LocationID, Year, AgeRange, Gender, Obesity
                FROM MetabolicDisease
                WHERE Year >= "2010" AND Year <= "2022" AND AgeRange <> "Ages 35-64 years" AND AgeRange <> "Ages 65+ years") AS childObesity
                NATURAL JOIN Location
                GROUP BY State) obesityStats
                JOIN 
                (SELECT Year as minObesityYear, Obesity
                FROM MetabolicDisease
                WHERE Year >= "2010" AND Year <= "2022" AND AgeRange <> "Ages 35-64 years" AND AgeRange <> "Ages 65+ years") AS allObesity
                ON obesityStats.minObesity = allObesity.Obesity) as minObesityStats
         JOIN
         (SELECT Year as maxObesityYear, Obesity AS maxObesity2
         FROM MetabolicDisease
         WHERE Year >= "2010" AND Year <= "2022" AND AgeRange <> "Ages 35-64 years" AND AgeRange <> "Ages 65+ years") AS maxObesityYears
         ON minObesityStats.maxObesity = maxObesityYears.maxObesity2
GROUP BY avgObesity DESC, State ASC;



/*============================================================================*/
/** Q11
  * NEW QUESTION
  * For each state, what year did NSLP help the most and least students and what was the average income for households in this year? 
  * 
  * Will have dropdown to choose from different food programs in SchoolFoodPrograms table to see similar type of stats
 */

SELECT State, minStudents, minStudentsYear, minYearAvgIncome, maxStudents, maxStudentsYear, AvgIncome as "maxYearAvgIncome"
FROM
        (SELECT State, minStudents, minStudentsYear, AvgIncome as "minYearAvgIncome", maxStudents, maxStudentsYear
        FROM
                (SELECT State, minStudents, Year as minStudentsYear, maxStudents, maxStudentsYear
                FROM
                        (SELECT State, maxStudents, Year AS maxStudentsYear, minStudents
                        FROM
                                (SELECT State, MAX(numStudents) as "maxStudents", MIN(numStudents) as "minStudents"
                                FROM
                                        (SELECT *
                                        FROM SchoolFoodPrograms
                                        WHERE Name = "NSLP") as NSLPStats
                                        NATURAL JOIN 
                                        Location
                                GROUP BY State) studentCounts
                                        JOIN
                                SchoolFoodPrograms
                                ON studentCounts.maxStudents = SchoolFoodPrograms.numStudents) as maxStudents
                            JOIN
                        SchoolFoodPrograms
                        ON maxStudents.minStudents = SchoolFoodPrograms.numStudents) as schoolProgramCounts
                 JOIN
                 AvgHousehold
                 ON schoolProgramCounts.minStudentsYear = AvgHousehold.Year) AS minAvgIncome
        JOIN
        AvgHousehold
        ON minAvgIncome.maxStudentsYear = AvgHousehold.Year
ORDER BY maxStudents DESC, minStudents DESC;


/*============================================================================*/
/** Q12
  * NEW QUESTION
  * In the state that on average had the most students enrolled in the SBP program, what was the number of people enrolled in the WIC 
  * FoodAssistance Program by year?
  * 
  * Returns two tables: One for WIC enrollment by year and one for SBP enrollment by year, both in the state with the average max
  * number of students enrolled.
  * 
  * Will have dropdown to choose from different food programs (NSLP, SBP, WIC, etc.) and option to look at state with min/max students enrolled. 
 */

SET @maxState = (SELECT State
                FROM    (SELECT State, AVG(numStudents) as avgStudents
                        FROM SchoolFoodPrograms NATURAL JOIN Location
                        WHERE Name = "SBP"
                        GROUP BY State
                        ORDER BY avgStudents DESC
                        LIMIT 1) as maxStudentState);

SELECT State, Year, Name, numEnrolled
FROM FoodAssistance NATURAL JOIN Location
WHERE State = @maxState AND Name = "WIC"
ORDER BY Year ASC;

SELECT State, Year, Name, numStudents
FROM SchoolFoodPrograms NATURAL JOIN Location
WHERE State = @maxState AND Name = "SBP"
ORDER BY Year ASC;

/*============================================================================*/
/** Q13
  * NEW QUESTION
  * In the year with the most people enrolled in school food programs in the whole country, what was the federal income 
  * distribution and average income? 
  * 
  * Will have dropdown to choose from different food programs (WIC, SNAP, etc) or all food programs in total and option to look 
  * at state with min/max students enrolled. 
 */

SET @maxEnrollmentYear = (SELECT totalEnrollments.Year FROM
                                (SELECT Year, SUM(numEnrolled) as totalEnrolled
                                FROM FoodAssistance
                                GROUP BY Year
                                ORDER BY totalEnrolled DESC
                                LIMIT 1) AS totalEnrollments);

SELECT Year, IncomeUnder15k, Income15kTo25k, Income25kTo35k, 
       Income35kTo50k, Income50kTo75k, Income75kTo100k, Income100kTo150k, 
       Income150kTo200k, Income200kAbove, AvgIncome
FROM AvgHousehold
WHERE Year = @maxEnrollmentYear;


/*============================================================================*/
/** Q14
  * NEW QUESTION
  * In 2013 in California, for adults (18+), which gender had the greater ratio of sugar to produce intake and what was the 
  * rate of heart disease for this gender by county? 
  * (Adapted from question 21 from PhaseA)
  * 
  * Will have option to look at gender with min/max students sugar to produce intake ratio. 
 */
 
 SET @maxConsumptionGender = (SELECT Gender
                             FROM
                                   (SELECT State, Year, AgeRange, Gender, ProduceIntake, SugarIntake, SugarIntake / ProduceIntake AS ConsumptionRatio
                                    FROM ConsumptionStats NATURAL JOIN Location
                                    WHERE Year = "2013" AND AgeRange = "18+") AS AdultConsumption
                             ORDER BY ConsumptionRatio DESC
                             LIMIT 1);

SELECT County, HeartDisease
FROM MetabolicDisease NATURAL JOIN Location
WHERE Year = "2013" AND Gender = @maxConsumptionGender AND AgeRange = "Ages 35-64 years" AND State = "California"
ORDER By HeartDisease DESC;

/*============================================================================*/
/** Q15
  * NEW QUESTION
  * Which year had the overall greatest enrollment in school food programs and what was the enrollment for each individual 
  * program in this year and the average income distribution for this year? 
  * 
  * Will have option to use dropdown to look at different years to see enrollment in each program.
 */

SET @maxYearFoodPrograms =  (SELECT Year
                             FROM
                                   (SELECT Year, SUM(numEnrolled) as totalEnrolled
                                    FROM FoodAssistance
                                    GROUP BY Year
                                    ORDER BY totalEnrolled DESC
                                    LIMIT 1) as totalEnrolledCounts); 
                                    
SELECT Name, Year, SUM(numEnrolled) as "numEnrolled"
FROM FoodAssistance NATURAL JOIN Location
WHERE Year = @maxYearFoodPrograms
GROUP BY Name
ORDER BY numEnrolled DESC;

SELECT Year, IncomeUnder15k, Income15kTo25k, Income25kTo35k, 
       Income35kTo50k, Income50kTo75k, Income75kTo100k, Income100kTo150k, 
       Income150kTo200k, Income200kAbove, AvgIncome, AvgNumMembers
FROM AvgHousehold
WHERE Year = @maxYearFoodPrograms;
