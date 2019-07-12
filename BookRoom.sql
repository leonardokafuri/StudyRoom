drop database if exists auth;
create database if not exists auth;
use auth;

grant select, insert, update, delete, index, alter, create, drop 
on auth.*
to 'webauth' identified by 'webauth';

create table if not exists authorized_users (
  name varchar(16) primary key,
  password varchar(40) not null
);

INSERT INTO authorized_users VALUES
  ('user1','pass1'),
  ('user2','pass2'),
  ('user3','pass3');