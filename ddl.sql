DROP DATABASE tcabs;
CREATE DATABASE tcabs;

CREATE TABLE Users (
	userID			INT			AUTO_INCREMENT,
	fName				VARCHAR(255)			NOT NULL,
	lName				VARCHAR(255)			NOT NULL,
	gender			VARCHAR(1),
	pNum				VARCHAR(255),
	email				VARCHAR(255)			NOT NULL,
	pwd		VARCHAR(20)			NOT NULL,

	PRIMARY KEY (userID)
);

CREATE TABLE UserRole (
	userRoleID	INT			AUTO_INCREMENT,
	userType		VARCHAR(50)			NOT NULL,

	PRIMARY KEY (userRoleID)
);

CREATE TABLE UserUserRole (
	uurID			INT			AUTO_INCREMENT,
	userID			INT			NOT NULL,
	userRoleID			INT			NOT NULL,

	PRIMARY KEY (uurID),
	FOREIGN KEY (userID) REFERENCES Users(userID),
	FOREIGN KEY (userRoleID) REFERENCES UserRole(userRoleID)
);

CREATE TABLE Admin (
	adminID			INT			AUTO_INCREMENT,
	uurID			INT			NOT NULL,

	PRIMARY KEY (adminID),
	FOREIGN KEY (uurID) REFERENCES UserUserRole(uurID)
);

CREATE TABLE Student (
	studentID			INT			AUTO_INCREMENT,
	uurID			INT,

	PRIMARY KEY (studentID),
	FOREIGN KEY (uurID) REFERENCES UserUserRole(uurID)
);

CREATE TABLE Unit (
	unitID			INT			AUTO_INCREMENT,
	unitCode		VARCHAR(10)			NOT NULL,
	unitName		VARCHAR(100)			NOT NULL,
	faculty			VARCHAR(10)			NOT NULL,

	PRIMARY KEY (unitID)
);

CREATE TABLE Convenor (
	convenorID			INT			AUTO_INCREMENT,
	uurID			INT			NOT NULL,

	PRIMARY KEY (convenorID),
	FOREIGN KEY (uurID) REFERENCES UserUserRole(uurID)
);

-- how to record dates?
-- maybe make a study periods table
CREATE TABLE UnitOffering (
	unitOfferingID			INT			AUTO_INCREMENT,
	unitID			INT			NOT NULL,
	convenorID			INT			NOT NULL,
	period			VARCHAR(50)			NOT NULL,
	censusDate			VARCHAR(20)			NOT NULL,

	PRIMARY KEY (unitOfferingID),
	FOREIGN KEY (unitID) REFERENCES Unit(unitID),
	FOREIGN KEY (convenorID) REFERENCES Convenor(convenorID)
);

CREATE TABLE Enrolment (
	enrolmentID			INT			AUTO_INCREMENT,
	studentID			INT			NOT NULL,
	unitOfferingID			INT			NOT NULL,

	PRIMARY KEY (enrolmentID),
	FOREIGN KEY (studentID) REFERENCES Student(studentID),
	FOREIGN KEY (unitOfferingID) REFERENCES UnitOffering(unitOfferingID)
);

-----------------------------------------------------------------------------
------------------------- DATA INSERTION ------------------------------------
-----------------------------------------------------------------------------

INSERT INTO tcabs.Users VALUES (1, "Daenerys", "Targaryen", "F", "0412323443", "dtargaryen@gmail.com", "motherofdragons");
INSERT INTO tcabs.Users VALUES (2, "Tyrion", "Lannister", "M", "0412332543", "tlannister@gmail.com", "lannisteralwayspaysitsdebt");
INSERT INTO tcabs.Users VALUES (3, "John", "Snow", "M", "0412332243", "jsnow@gmail.com", "kingingthenorth");
INSERT INTO tcabs.Users VALUES (4, "Robert", "Baratheon", "M", "0412332263", "rbaratheon@gmail.com", "rulerofsevenkingdoms");
INSERT INTO tcabs.Users VALUES (5, "Arya", "Stark", "F", "0412332263", "astark@gmail.com", "thereisonlyonegod");

INSERT INTO tcabs.UserRole VALUES (1, "Admin");
INSERT INTO tcabs.UserRole VALUES (2, "Convenor");
INSERT INTO tcabs.UserRole VALUES (3, "Supervisor");
INSERT INTO tcabs.UserRole VALUES (4, "Student");

INSERT INTO tcabs.UserUserRole VALUES (1, 2, 4);
INSERT INTO tcabs.UserUserRole VALUES (2, 1, 1);
INSERT INTO tcabs.UserUserRole VALUES (3, 5, 4);
INSERT INTO tcabs.UserUserRole VALUES (4, 4, 2);
INSERT INTO tcabs.UserUserRole VALUES (5, 3, 2);

INSERT INTO tcabs.Admin VALUES (1, 2);

INSERT INTO tcabs.Unit VALUES (1, "ICT30001", "Information Technology Project", "FSET");
INSERT INTO tcabs.Unit VALUES (2, "INF30011", "Database Implementation", "FSET");
INSERT INTO tcabs.Unit VALUES (3, "STA10003", "Foundation of Statistics", "FSET");
INSERT INTO tcabs.Unit VALUES (4, "STA20010", "Statisical Computing", "FSET");

INSERT INTO tcabs.Convenor VALUES (1, 4);
INSERT INTO tcabs.Convenor VALUES (2, 5);

INSERT INTO tcabs.UnitOffering VALUES (1, 1, 1, "Sem1_2018", "31 March 2018");
INSERT INTO tcabs.UnitOffering VALUES (2, 1, 1, "Sem1_2019", "31 March 2019");
INSERT INTO tcabs.UnitOffering VALUES (3, 2, 2, "Sem1_2018", "31 March 2018");
INSERT INTO tcabs.UnitOffering VALUES (4, 2, 2, "Sem1_2019", "31 March 2019");

INSERT INTO tcabs.Student VALUES (1, 1);
INSERT INTO tcabs.Student VALUES (2, 3);

INSERT INTO tcabs.Enrolment VALUES (1, 1, 1);
INSERT INTO tcabs.Enrolment VALUES (2, 1, 2);
INSERT INTO tcabs.Enrolment VALUES (3, 1, 3);
INSERT INTO tcabs.Enrolment VALUES (4, 1, 4);
INSERT INTO tcabs.Enrolment VALUES (5, 2, 2);
INSERT INTO tcabs.Enrolment VALUES (6, 2, 4);
