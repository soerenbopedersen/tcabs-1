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
