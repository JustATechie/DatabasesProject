/* Script that contains 15 data queries
 *
 * Louie DiBernardo (LDIBERN1)
 * Sanddhya Jayabalan (SJAYABA1)
*/

/*
 * Is there a significant trend between sugar intake and heart disease in adults per year? (Specifically in CA)
 */

select Distinct Location.State, ConsumptionStats.Year, ConsumptionStats.AgeRange, ConsumptionStats.Gender, SugarIntake, MetabolicDisease.HeartDisease
from Location, ConsumptionStats left join MetabolicDisease on MetabolicDisease.Year=ConsumptionStats.Year
where ConsumptionStats.AgeRange='18+' and MetabolicDisease.AgeRange='Ages 35-64 years'
and ConsumptionStats.Gender=MetabolicDisease.Gender and Location.LocationID=MetabolicDisease.LocationID and Location.State='California';