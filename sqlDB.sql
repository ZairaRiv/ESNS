CREATE TABLE IF NOT EXISTS studentDatabase (
    schoolID INT(8) NOT NULL,
    lastName VARCHAR(45) NOT NULL,
    firstName VARCHAR(45) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    phoneNumber BIGINT(12) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS schoolDatabase (
    schoolID INT(8) NOT NULL UNIQUE,
    schoolName VARCHAR(256) NOT NULL,
    schoolCity VARCHAR(256) NOT NULL,
    schoolState VARCHAR(3) NOT NULL,
    schoolCountry VARCHAR(256) NOT NULL,
    schoolLat DECIMAL(10 , 7 ) NOT NULL,
    schoolLong DECIMAL(10 , 7 ) NOT NULL,
    PRIMARY KEY (schoolID)
);

CREATE TABLE IF NOT EXISTS adminDatabase (
    adminName VARCHAR(45) NOT NULL,
    typeOfAdmin VARCHAR(45) NOT NULL,
    schoolID INT(8) NOT NULL
);
    