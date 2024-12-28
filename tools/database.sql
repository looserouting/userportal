create database biznizz;
grant all privileges on biznizz.* to 'admin'@'localhost' identified by 'admin';
use biznizz;

create table users (
  id int unsigned auto_increment primary key,
  username varchar(64) not null,
  password varchar(64) not null,
  contact_id int unsigned
);
insert into users (username,contact_id,password) value ("admin", 1, "biznizz");

create table customers (
  id int unsigned PRIMARY KEY,
)

create table contacts (
  id int unsigned PRIMARY KEY,
  street varchar(255),
  no varchar(10),
  no_ext varchar(10),
  name varchar(100),
  lastname varchar(100),
  city varchar(100),
  province varchar(100),
  country varchar(100),
  phone varchar(20),
  mail varchar(100)
)

create table customer_contact (
  id int unsigned,
  customerid int unsigned,
  contactid int unsigned,
  is_maincontact BOOL,
  permissions int unsigned
)

create table tickets (
  id int unsigned auto_increment primary key,
  customerid int unsigned,
  agentid int unsigned,
  contacts text,
  created_time TIMESTAMP default CURRENT_TIMESTAMP,
  updated_time TIMESTAMP,
  FOREIGN KEY (agentid)
    REFERENCES users(id)
    ON UPDATE CASCADE,
  FOREIGN KEY (customerid)
    REFERENCES customers(id)
    ON UPDATE CASCADE
);

create table ticketEntry (
  id int unsigned auto_increment primary key,
  authorid int unsigned,
  ticketid int unsigned,
  message text,
  spend_time int unsigned,
  created_time TIMESTAMP default CURRENT_TIMESTAMP,
  CONSTRAINT `fk_ticket_ticketentry`
    FOREIGN KEY (ticketid) REFERENCES tickets(id)
    ON UPDATE CASCADE
)
