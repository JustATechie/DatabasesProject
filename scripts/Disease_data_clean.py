txtimport os

us_state_to_abbrev = {
    "Alabama": "AL",
    "Alaska": "AK",
    "Arizona": "AZ",
    "Arkansas": "AR",
    "California": "CA",
    "Colorado": "CO",
    "Connecticut": "CT",
    "Delaware": "DE",
    "Florida": "FL",
    "Georgia": "GA",
    "Hawaii": "HI",
    "Idaho": "ID",
    "Illinois": "IL",
    "Indiana": "IN",
    "Iowa": "IA",
    "Kansas": "KS",
    "Kentucky": "KY",
    "Louisiana": "LA",
    "Maine": "ME",
    "Maryland": "MD",
    "Massachusetts": "MA",
    "Michigan": "MI",
    "Minnesota": "MN",
    "Mississippi": "MS",
    "Missouri": "MO",
    "Montana": "MT",
    "Nebraska": "NE",
    "Nevada": "NV",
    "New Hampshire": "NH",
    "New Jersey": "NJ",
    "New Mexico": "NM",
    "New York": "NY",
    "North Carolina": "NC",
    "North Dakota": "ND",
    "Ohio": "OH",
    "Oklahoma": "OK",
    "Oregon": "OR",
    "Pennsylvania": "PA",
    "Rhode Island": "RI",
    "South Carolina": "SC",
    "South Dakota": "SD",
    "Tennessee": "TN",
    "Texas": "TX",
    "Utah": "UT",
    "Vermont": "VT",
    "Virginia": "VA",
    "Washington": "WA",
    "West Virginia": "WV",
    "Wisconsin": "WI",
    "Wyoming": "WY",
    "District of Columbia": "DC",
    "American Samoa": "AS",
    "Guam": "GU",
    "Northern Mariana Islands": "MP",
    "Puerto Rico": "PR",
    "United States Minor Outlying Islands": "UM",
    "U.S. Virgin Islands": "VI"
}

def addLocation(fileName, outFile, locationData):
    locationCodes = {}
    with open(locationData, 'r') as locationValues:
        locationD = locationValues.readlines()
    locationValues.close()
    for currLocation in locationD:
        loc = currLocation.split(',')
        locationCodes[(us_state_to_abbrev[loc[1]], loc[2].strip())] = loc[0]
    with open(fileName, 'r') as f:
        data = f.readlines()
    f.close
    with open(outFile, 'a') as out:
        for curr in data:
            values = curr.split(',')
            state = values[2]
            county = values[3]
            locationEntry = (state, county)
            id = locationCodes[locationEntry]
            values[1] = id
            dataWithLocation = ','.join(values)
            out.write(dataWithLocation)
    out.close()

inFile1 = 'data/ready/Disease/Disease by county - Federal1.csv'
inFile2 = 'data/ready/Disease/Disease by county - Federal2.csv'
outF = 'data/processed/full/MetabolicDisease/MetabolicDisease.txt'
locationF = 'data/processed/full/Location/US_Locations-Counties-Sorted.csv'
addLocation(inFile1, outF, locationF)
addLocation(inFile2, outF, locationF)

