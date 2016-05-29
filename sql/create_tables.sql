CREATE TABLE Reader(
	id SERIAL PRIMARY KEY,
	username varchar(50) NOT NULL UNIQUE,
	password varchar(50) NOT NULL
);

CREATE TABLE Book(
	id SERIAL PRIMARY KEY,
	title varchar(255) NOT NULL,
	author varchar(255) NOT NULL
);

CREATE TABLE Review(
	id SERIAL PRIMARY KEY,
	reader_id INTEGER REFERENCES Reader(id),
	book_id INTEGER REFERENCES Book(id),
	score INTEGER NOT NULL,
	review_text varchar(max)
);

CREATE TABLE ReadingList(
	id SERIAL PRIMARY KEY,
	reader_id INTEGER REFERENCES Reader(id),
	book_id INTEGER REFERENCES Book(id)
);
