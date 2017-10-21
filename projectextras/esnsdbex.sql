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