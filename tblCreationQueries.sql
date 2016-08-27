-- Create a table called genre with the following properties:
-- id - an auto incrementing integer which is the primary key
-- type - a varchar of maximum length 255, cannot be null

CREATE TABLE `genre` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`type` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE (`type`)
) ENGINE=InnoDB;


-- Create a table called author with the following properties:
-- id - an auto incrementing integer which is the primary key
-- first_name - a varchar of maximum length 255, cannot be null
-- last_name - a varchar of maximum length 255, cannot be null
-- UNIQUE Constraint uc_AuthorName of first_name and last_name

CREATE TABLE `author` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`first_name` varchar(255) NOT NULL,
	`last_name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`),
	CONSTRAINT uc_AuthorName UNIQUE (`first_name`,`last_name`)
) ENGINE=InnoDB;


-- Create a table called book with the following properties:
-- id - an auto incrementing integer which is the primary key
-- aid - an integer which is a foreign key reference to the author table and a UNIQUE index
-- gid - an integer which is a foreign key reference to the genre table and a UNIQUE index
-- title - a varchar of maximum length 255, cannot be null
-- page_number - an integer value

CREATE TABLE `book` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`aid` int(11),
	`gid` int(11),
	`title` varchar(255) NOT NULL,
	`page_number` int(11),
	PRIMARY KEY (`id`),
	CREATE UNIQUE INDEX aid ON `book` (`aid`),
	CREATE UNIQUE INDEX gid ON `book` (`gid`),
	FOREIGN KEY (`aid`) REFERENCES `author` (`id`),
	FOREIGN KEY (`gid`) REFERENCES `genre` (`id`)
) ENGINE=InnoDB;


-- Create a table called individual with the following properties:
-- id - an auto incrementing integer which is the primary key
-- first_name - a varchar of maximum length 255, cannot be null
-- last_name - a varchar of maximum length 255, cannot be null
-- dob - a date type
-- username - a UNIQUE varchar of maximum length 255, cannot be null

CREATE TABLE `individual` (
	`id` int(11) NOT NULL AUTO_INCREMENT,
	`first_name` varchar(255) NOT NULL,
	`last_name` varchar(255) NOT NULL,
	`username` varchar(255) NOT NULL,
	`dob` date,
	PRIMARY KEY (`id`),
	UNIQUE (`username`)
) ENGINE=InnoDB;


-- Create a table called purchase with the following properties, this is a table representing a many-to-many relationship
-- between books and individuals:
-- bid - an integer which is a foreign key reference to book
-- iid - an integer which is a foreign key reference to individual and a UNIQUE index
-- add_date - a date type
-- The primary key is a combination of bid and iid

CREATE TABLE `purchase` (
	`bid` int(11),
	`iid` int(11),
	`add_date` date,
	PRIMARY KEY (`bid`, `iid`),
	CREATE UNIQUE INDEX iid ON `purchase` (`iid`),
	FOREIGN KEY (`bid`) REFERENCES `book` (`id`),
	FOREIGN KEY (`iid`) REFERENCES `individual` (`id`)
) ENGINE=InnoDB;



--Add a few values to each table

--Add values into genre table
INSERT INTO genre (type)
VALUES ("Romance"), ("Comedy"), ("Science-Fiction"), ("Fantasy"), ("History"), ("Literature"), ("Fiction"), ("Non-Fiction"), ("Travel"), ("Religion"), ("Mystery"), ("Children"), ("News");

-- Add values into author table
INSERT INTO author (first_name, last_name)
VALUES ("Stephen", "King"), ("J.K.", "Rowling"), ("Dr.", "Seuss"), ("Rachel", "Phifer"), ("Veronica", "Roth"), ("Marc", "Secchia"), ("Sarah", "Fine", ("Lucy", "McConnell"), ("Dan", "Brown"), ("Cassandra", "Clare"), ("George", "Martin");

--Add values into book table
INSERT INTO book (aid, gid, title, page_number)
VALUES ((SELECT id FROM author WHERE first_name = "Rachel" AND last_name = "Phifer"), (SELECT id FROM genre WHERE type = "Fiction"), "The Language of Sparrows", 388), ((SELECT id FROM author WHERE first_name = "Dan" AND last_name = "Brown"), (SELECT id FROM genre WHERE type = "Mystery"), "Inferno", 576);


--Add values into individual table
INSERT INTO individual (first_name, last_name, dob)
VALUES ("Mariam", "Ben-Neticha", '1994-03-16'), ("John", "Doe", '2001-12-02'), ("Jane", "Smith", '1989-07-07');


--Add values into purchase table
INSERT INTO purchase (bid, iid, add_date)
VALUES ((SELECT book.id FROM book JOIN author ON author.id = book.aid WHERE book.title = "Inferno" AND author.first_name = "Dan" AND author.last_name = "Brown"), (SELECT id FROM individual WHERE first_name = "Jane" AND last_name = "Smith"), '2016-01-01');




