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
