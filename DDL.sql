
-- DDL statements for the test database in microsoft sql server

CREATE TABLE employees(employeeID INT UNIQUE NOT NULL IDENTITY(1,1),
username VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
PRIMARY KEY (employeeID)
);

CREATE TABLE admins(adminID INT NOT NULL IDENTITY(1,1),
admin_username VARCHAR(255) NOT NULL,
admin_password VARCHAR(255) NOT NULL,
employeeID INT UNIQUE NOT NULL,
PRIMARY KEY (employeeID),
FOREIGN KEY (employeeID) REFERENCES employees(employeeID)
);

CREATE TABLE schedule(employeeID INT NOT NULL,
work_date DATE NOT NULL,
start_work_hour TIME NOT NULL,
end_work_hour TIME NOT NULL,
PRIMARY KEY (employeeID, work_date),
FOREIGN KEY (employeeID) REFERENCES employees(employeeID)
);

INSERT INTO schedule VALUES(1, '2023-03-15', '08:00:00', '17:00:00', 0, 0);
INSERT INTO schedule VALUES(1, '2023-03-17', '08:00:00', '17:00:00', 0, 0);
INSERT INTO schedule VALUES(1, '2023-03-18', '08:00:00', '17:00:00', 0, 0);
INSERT INTO schedule VALUES(1, '2023-03-19', '08:00:00', '17:00:00', 0, 0);
INSERT INTO schedule VALUES(1, '2023-03-20', '08:00:00', '17:00:00', 0, 0);
INSERT INTO schedule VALUES(1, '2023-03-21', '08:00:00', '17:00:00', 0, 0);
INSERT INTO schedule VALUES(1, '2023-03-22', '08:00:00', '17:00:00', 0, 0);
INSERT INTO schedule VALUES(1, '2023-03-23', '08:00:00', '17:00:00', 0, 0);
INSERT INTO schedule VALUES(1, '2023-03-24', '08:00:00', '17:00:00', 0, 0);
INSERT INTO schedule VALUES(1, '2023-03-25', '08:00:00', '17:00:00', 0, 0);
INSERT INTO schedule VALUES(1, '2023-03-26', '08:00:00', '17:00:00', 0, 0);
INSERT INTO schedule VALUES(1, '2023-03-27', '08:00:00', '17:00:00', 0, 0);

CREATE TABLE schedule_requests(employeeID INT NOT NULL, 
requestID INT NOT NULL IDENTITY(1,1),
work_date DATE NOT NULL,
start_work_hour TIME NOT NULL,
end_work_hour TIME NOT NULL,
is_holiday BIT NOT NULL,
is_weekend BIT NOT NULL,
PRIMARY KEY (employeeID, requestID),
FOREIGN KEY (employeeID) REFERENCES employees(employeeID)
);
