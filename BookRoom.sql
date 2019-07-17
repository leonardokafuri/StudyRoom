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
BookingID int AUTO_INCREMENT,
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
