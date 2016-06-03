-- Lisää INSERT INTO lauseet tähän tiedostoon
-- Reader-taulun testidata
INSERT INTO Reader (username, password) VALUES ('Test', 'password');
INSERT INTO Reader (username, password) VALUES ('DDO', '1337');
-- Book-taulun testidata
INSERT INTO Book (title, author) VALUES ('To Kill A Mockingbird', 'Harper Lee');
INSERT INTO Book (title, author) VALUES ('Neuromancer', 'William Gibson');
-- MyBook-taulun testidata
INSERT INTO MyBook (reader_id, book_id, status, added) VALUES (1, 1, 0, '2011-11-11');
INSERT INTO MyBook (reader_id, book_id, status, added) VALUES (2, 2, 1, '2011-11-11');
INSERT INTO MyBook (reader_id, book_id, status, added) VALUES (2, 1, 0, '2011-11-11');
-- Review-taulun testidata
INSERT INTO Review (reader_id, book_id, score, review_text) VALUES (1, 1, 5, 'Awesome book!');
INSERT INTO Review (reader_id, book_id, score, review_text) VALUES (1, 1, 4, 'Awesome book!');