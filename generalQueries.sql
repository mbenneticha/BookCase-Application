--ADD a value to each table

--Add values into genre table (SPECIFIC)
INSERT INTO genre (type)
VALUES ("Romance"), ("Comedy"), ("Science-Fiction"), ("Fantasy"), ("History"), ("Literature"), ("Fiction"), ("Non-Fiction"), ("Travel"), ("Religion"), ("Mystery"), ("Children"), ("News");

--(GENERAL USE)
INSERT INTO genre (type)
VALUES ([gtype]);


-- Add values into author table
INSERT INTO author (first_name, last_name)
VALUES ("Stephen", "King"), ("J.K.", "Rowling"), ("Dr.", "Seuss"), ("Rachel", "Phifer"), ("Veronica", "Roth"), ("Marc", "Secchia"), ("Sarah", "Fine"), ("Lucy", "McConnell"), ("Dan", "Brown"), ("Cassandra", "Clare"), ("George", "Martin");


--(GENERAL USE)
INSERT INTO author (first_name, last_name)
VALUES ([aFName], [aLName]);

--Add values into book table
INSERT INTO book (aid, gid, title, page_number)
VALUES ((SELECT id FROM author WHERE first_name = "Rachel" AND last_name = "Phifer"), (SELECT id FROM genre WHERE type = "Fiction"), "The Language of Sparrows", 388), ((SELECT id FROM author WHERE first_name = "Dan" AND last_name = "Brown"), (SELECT id FROM genre WHERE type = "Mystery"), "Inferno", 576);

--(GENERAL USE)
INSERT INTO book (aid, gid, title, page_number)
VALUES ((SELECT id FROM author WHERE first_name = [aFName] AND last_name = [aLName]), (SELECT id FROM genre WHERE type = [gtype]), [userTitle], [numPages]);

--Add values into individual table
INSERT INTO individual (first_name, last_name, dob)
VALUES ("Mariam", "Ben-Neticha", '1994-03-16'), ("John", "Doe", '2001-12-02'), ("Jane", "Smith", '1989-07-07');

--(GENERAL USE)
INSERT INTO individual (first_name, last_name, dob)
VALUES ([iFName], [iLName], [iDOB]);


--Add values into purchase table
INSERT INTO purchase (bid, iid, add_date)
VALUES ((SELECT book.id FROM book JOIN author ON author.id = book.aid WHERE book.title = "Inferno" AND author.first_name = "Dan" AND author.last_name = "Brown"), (SELECT id FROM individual WHERE first_name = "Jane" AND last_name = "Smith"), '2016-01-01');


--(GENERAL USE)
INSERT INTO purchase (bid, iid, add_date)
VALUES ((SELECT book.id FROM book JOIN author ON author.id = book.aid WHERE book.title = [bTitle] AND author.first_name = [aFName] AND author.last_name = [aLName]), (SELECT id FROM individual WHERE first_name = [iFName] AND last_name = [iLName]), [addDate]);


-- SELECT data from tables

--Selects all books read by a certain individual
SELECT i.first_name, i.last_name, b.title, a.first_name, a.last_name, p.add_date 
    FROM individual i
    INNER JOIN purchase p ON i.id = p.iid
    INNER JOIN book b ON p.bid = b.id
    INNER JOIN author a ON b.aid = a.id
    WHERE i.first_name = "Mariam" AND i.last_name= "Ben-Neticha"


--Selects all books of a certain genre




-- UPDATE data in tables

?

-- DELETE data from tables

?


