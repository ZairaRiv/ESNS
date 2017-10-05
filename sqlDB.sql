CREATE TABLE IF NOT EXISTS studentDatabase (
    schoolID INT(8) NOT NULL,
    lastName VARCHAR(45) NOT NULL,
    firstName VARCHAR(45) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    phoneNumber BIGINT(12) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS schoolDatabase (
    schoolID INT(8) NOT NULL,
    nameOfSchool VARCHAR(45) NOT NULL,
    schoolLat DECIMAL(10 , 7 ) NOT NULL,
    schoolLong DECIMAL(10 , 7 ) NOT NULL,
    buildingID INT(8) NOT NULL
);

CREATE TABLE IF NOT EXISTS adminDatabase (
    adminName VARCHAR(45) NOT NULL,
    typeOfAdmin VARCHAR(45) NOT NULL,
    schoolID INT(8) NOT NULL
);

CREATE TABLE IF NOT EXISTS FSBuildings(
    blgName VARCHAR (50) NOT NULL,
    blgAcr VARCHAR (10) NOT NULL,
    blgNum INT (100) NOT NULL
);
    
