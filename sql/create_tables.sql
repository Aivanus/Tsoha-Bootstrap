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
	reader_id INTEGER REFERENCES Reader(id) ON DELETE CASCADE,
	book_id INTEGER REFERENCES Book(id) ON DELETE CASCADE,
	score INTEGER NOT NULL,
	review_text text,
	reviewed DATE NOT NULL
);

CREATE TABLE MyBook(
	id SERIAL PRIMARY KEY,
	reader_id INTEGER REFERENCES Reader(id) ON DELETE CASCADE,
	book_id INTEGER REFERENCES Book(id) ON DELETE CASCADE,
	status INTEGER NOT NULL,
	added DATE NOT NULL
);
