/**
school DB
should contain:
name of school, location of school, 
school id
**/

CREATE TABLE schoolDB(schID INTEGER PRIMARY KEY, name TEXT(40),address TEXT(100));

INSERT INTO schoolDB(1, "Fresno State", "5241 N Maple Ave. Fresno, CA 93740");


/**
student DB
should contain: 
name, phone number, e-mail, schID
Primary Key should be int prim so we can 
search for students by school 
**/
CREATE TABLE studentDB (schID INTEGER PRIMARY KEY, name TEXT, phnumber INTEGER, email TEXT);

INSERT INTO studentDB(1, "Zaira", 2090000000, "zaira@gmail.com");
INSERT INTO studentDB(1, "Agustin", 2090000001, "agustin@gmail.com");
INSERT INTO studentDB(1, "Julian", 2090000002, "julian@gmail.com");
INSERT INTO studentDB(1, "Kyle", 2090000000, "kyle@gmail.com");
INSERT INTO studentDB(1, "Majid", 2090000000, "majid@gmail.com");

/**
ADMIN will have diff view from student in web
but we require the same amount of information from them
Need to be able to search by school 
**/
CREATE TABLE adminDB (schID INTEGER PRIMARY KEY, name TEXT, phnumber INTEGER, email TEXT);

INSERT INTO adminDB(1, "Professor Alex", 1234567890, "professor@gmail.com");
INSERT INTO adminDB(1, "Sharma", 1234567899, "sharma@gmail.com");

/**
This piece is very important 
Labels all of building in Fresno State and assigns them an identifier for 
the map shown on the esns website, for easy clicking
Need to know what the name of the building
**/ 
CREATE TABLE buildingsDB(schID INTEGER PRIMARY KEY, name TEXT, blgnum TEXT);

INSERT INTO buildingsDB(1, "Agricultural Sciences", "AG");
INSERT INTO buildingsDB(1, "Agricultural Mechanics", "AGM");
INSERT INTO buildingsDB(1, "Agricultural Operations Center", "AGOP");
INSERT INTO buildingsDB(1, "Amphitheater", "AM");
INSERT INTO buildingsDB(1, "Animal Science Pavillion", "ASP");
INSERT INTO buildingsDB(1, "Aspen Hall", "APH");
INSERT INTO buildingsDB(1, "Aquatics Center", "AQ");
INSERT INTO buildingsDB(1, "Auxilliary Services", "AS");
INSERT INTO buildingsDB(1, "Baker Hall", "BH"); 
INSERT INTO buildingsDB(1, "Beef Cattle Unit", "BCU");
INSERT INTO buildingsDB(1, "Beef Finish Unit", "BFU");
INSERT INTO buildingsDB(1, "Beiden Field","BEID");
INSERT INTO buildingsDB(1, "Birch Hall", "BIRH");
INSERT INTO buildingsDB(1, "Boiler Plant","BP");
INSERT INTO buildingsDB(1, "Kennel Bookstore","KB");
INSERT INTO buildingsDB(1, "Bulldog Stadium","BS");
INSERT INTO buildingsDB(1, "Calf Barn","CB");
INSERT INTO buildingsDB(1, "Cati","CATI");
INSERT INTO buildingsDB(1, "Chiller","CH");
INSERT INTO buildingsDB(1, "CIT Testing","CIT");
INSERT INTO buildingsDB(1, "Conley Art","CA");
INSERT INTO buildingsDB(1, "Dairy Processing Unit, Creamery","DPU");
INSERT INTO buildingsDB(1, "DOJ Forensics Lab","DOJ");
INSERT INTO buildingsDB(1, "Downing Planetarium","DP");
INSERT INTO buildingsDB(1, "Duncan Athletic","DUNC");
INSERT INTO buildingsDB(1, "Kremen Education","ED");
INSERT INTO buildingsDB(1, "Education Annex","EDAX");
INSERT INTO buildingsDB(1, "Engineering East","EE");
INSERT INTO buildingsDB(1, "Engineering West","EW");
INSERT INTO buildingsDB(1, "Enology Unit","ENL");
INSERT INTO buildingsDB(1, "Family and Food Sciences","FFS");
INSERT INTO buildingsDB(1, "Farm Machinery Center","FMC");
INSERT INTO buildingsDB(1, "Gibson Farm Market","FM");
INSERT INTO buildingsDB(1, "Food Processing Unit","FPU");
INSERT INTO buildingsDB(1, "Foundation","FD");
INSERT INTO buildingsDB(1, "Graduate Lab","GL");
INSERT INTO buildingsDB(1, "Graves Hall","GH");
INSERT INTO buildingsDB(1, "Greenhouses","GRH");
INSERT INTO buildingsDB(1, "Grosse Industrial Technology","GIT");
INSERT INTO buildingsDB(1, "Homan Hall","HH");
INSERT INTO buildingsDB(1, "Home Management","HMH");
INSERT INTO buildingsDB(1, "Horse Unit","HU");
INSERT INTO buildingsDB(1, "Jordan Agricultural Research Center","JARC");
INSERT INTO buildingsDB(1, "Joyal Administration","JA");
INSERT INTO buildingsDB(1, "Judging Pavillio","JP");
INSERT INTO buildingsDB(1, "Keats","KCB");
INSERT INTO buildingsDB(1, "Lab School","LS");
INSERT INTO buildingsDB(1, "Henry Madden Library","L");
INSERT INTO buildingsDB(1, "Mail Services and Printing","USUM");
INSERT INTO buildingsDB(1, "Margie Wright Diamond","MWD");
INSERT INTO buildingsDB(1, "McKee Fisk","MCF");
INSERT INTO buildingsDB(1, "McLane Hall","MCL");
INSERT INTO buildingsDB(1, "Music","M");
INSERT INTO buildingsDB(1, "North Gym Annex","NGA");
INSERT INTO buildingsDB(1, "North Gym","NG");
INSERT INTO buildingsDB(1, "Orchard Field House","OFH");
INSERT INTO buildingsDB(1, "Ornamental Horiculture Unit","HORT");
INSERT INTO buildingsDB(1, "Peters Building","PB");
INSERT INTO buildingsDB(1, "Physical Therapy and Intercollegiate Athletics Building","PTAB");
INSERT INTO buildingsDB(1, "Planetarium Museum","PM");
INSERT INTO buildingsDB(1, "Plant Operations","PO");
INSERT INTO buildingsDB(1, "Police/Public Safety","PS");
INSERT INTO buildingsDB(1, "Poultry Unit","PU");
INSERT INTO buildingsDB(1, "Professional/Human Services","PHS");
INSERT INTO buildingsDB(1, "Raisin Lab","RL");
INSERT INTO buildingsDB(1, "Recycling Center","RC");
INSERT INTO buildingsDB(1, "Ricchutti Center","RCC");
INSERT INTO buildingsDB(1, "Rodeo Grounds","RG");
INSERT INTO buildingsDB(1, "Round-up Lab","RUL");
INSERT INTO buildingsDB(1, "Satellite Student Union","SSU");
INSERT INTO buildingsDB(1, "Save Mart Center","SMC");
INSERT INTO buildingsDB(1, "Science","S1");
INSERT INTO buildingsDB(1, "Science II","S2");
INSERT INTO buildingsDB(1, "Sequoia/Cedar Hall","SCH");
INSERT INTO buildingsDB(1, "Sheep Unit","SU");
INSERT INTO buildingsDB(1, "Shipping and Receiving","SR");
INSERT INTO buildingsDB(1, "Smittcamp Alumni House","SAH");
INSERT INTO buildingsDB(1, "Social Science","SS");
INSERT INTO buildingsDB(1, "South Gym","SG");
INSERT INTO buildingsDB(1, "Speech Arts","SA");
INSERT INTO buildingsDB(1, "Student Health Center","SC");
INSERT INTO buildingsDB(1, "Student Horse Center","SHC");
INSERT INTO buildingsDB(1, "Student Recreation Center","SRC");
INSERT INTO buildingsDB(1, "Swine Unit","SU");
INSERT INTO buildingsDB(1, "Sycamore Hall","SH");
INSERT INTO buildingsDB(1, "The Atrium","RH");
INSERT INTO buildingsDB(1, "The Bulldog Shop","BS");
INSERT INTO buildingsDB(1, "Thomas","TAD");
INSERT INTO buildingsDB(1, "University Business Center","UBC");
INSERT INTO buildingsDB(1, "University Center","UC");
INSERT INTO buildingsDB(1, "University Dining Hall","RDF");
INSERT INTO buildingsDB(1, "University High School","UHS");
INSERT INTO buildingsDB(1, "University Student Union","SU");
INSERT INTO buildingsDB(1, "Veterinary Unit","VU");
INSERT INTO buildingsDB(1, "Viticulture and Enology Research Center","VIT");
INSERT INTO buildingsDB(1, "Viticulture Enology East","VITE");
INSERT INTO buildingsDB(1, "Warmerdam Field","WF");
INSERT INTO buildingsDB(1, "WET Field","WET");
