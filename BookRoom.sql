drop database if exists booking;
create database if not exists booking;
use booking;

grant select, insert, update, delete, index, alter, create, drop 
on booking.*
to 'admin' identified by 'admin';

create table Students (
  StudentID varchar(9) not null,
  fname varchar(16) not null,
  lname varchar(16) not null,
  password varchar(40) not null,
  PRIMARY KEY(StudentID)
);

create table Room(
RoomNumber int not null,
Building varchar(16) not null,
PRIMARY KEY (RoomNumber)
);

create table RoomAvailability (
RoomNumber int not null,
Date date not null,
Time varchar(14) not null,
CONSTRAINT FK_Room_Availability FOREIGN KEY (RoomNumber)
REFERENCES Room(RoomNumber)
);

create table RoomBooked
(
BookingID int UNSIGNED not null AUTO_INCREMENT,
StudentID varchar(9) not null ,
RoomNumber int not null,
Date date not null,
Time varchar(14) not null,
PRIMARY KEY (BookingID),
CONSTRAINT FK_Room_Booked_SID FOREIGN KEY (StudentID) 
REFERENCES Students(StudentID),
CONSTRAINT FK_Room_Booked_RN FOREIGN KEY (RoomNumber)
REFERENCES Room(RoomNumber)
);

INSERT INTO Students VALUES
  ('admin','admin','admin','admin');

insert into Room (RoomNumber, Building) values (101, "South Building");
insert into Room (RoomNumber, Building) values (102, "South Building");
insert into Room (RoomNumber, Building) values (103, "South Building");
insert into Room (RoomNumber, Building) values (104, "South Building");
insert into Room (RoomNumber, Building) values (105, "South Building");
insert into Room (RoomNumber, Building) values (106, "South Building");
insert into Room (RoomNumber, Building) values (107, "South Building");
insert into Room (RoomNumber, Building) values (108, "South Building");
insert into Room (RoomNumber, Building) values (109, "South Building");
insert into Room (RoomNumber, Building) values (110, "South Building");
insert into Room (RoomNumber, Building) values (111, "North Building");
insert into Room (RoomNumber, Building) values (112, "North Building");
insert into Room (RoomNumber, Building) values (113, "North Building");
insert into Room (RoomNumber, Building) values (114, "North Building");
insert into Room (RoomNumber, Building) values (115, "North Building");
insert into Room (RoomNumber, Building) values (116, "North Building");
insert into Room (RoomNumber, Building) values (117, "North Building");
insert into Room (RoomNumber, Building) values (118, "North Building");
insert into Room (RoomNumber, Building) values (119, "North Building");
insert into Room (RoomNumber, Building) values (120, "North Building");
