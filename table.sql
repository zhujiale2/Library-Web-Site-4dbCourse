use library;

create table book(
    bookNum varchar(50),
    category varchar(50),
    bookName varchar(50),
    publisher varchar(50),
    year int,
    author varchar(50),
    price numeric(10,2),
    amount int,
    primary key (bookNum)
);

create table card(
    cardNum varchar(50),
    usrName varchar(50),
    company varchar(50),
    identity varchar(50),
    primary key (cardNum)
);

create table admin(
    adminID varchar(50),
    passwd varchar(50),
    adminName varchar(50),
    phoneNum varchar(50),
    primary key (adminID)
);

create table record(
    cardNum varchar(50),
   	bookNum varchar(50),
    borrowDate datetime,
	returnDate datetime,
	adminID varchar(50)
);

