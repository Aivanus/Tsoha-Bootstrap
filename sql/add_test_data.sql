-- Lisää INSERT INTO lauseet tähän tiedostoon
-- Reader-taulun testidata
INSERT INTO Reader (username, password) VALUES ('Test', 'password');
INSERT INTO Reader (username, password) VALUES ('DDO', '1337');
-- Book-taulun testidata
INSERT INTO Boook (title, author) VALUES ('To Kill A Mockingbird', 'Harper Lee');
INSERT INTO Boook (title, author) VALUES ('Neuromancer', 'William Gibson');
-- Readlist-taulun testidata
INSERT INTO ReadList (reader_id, book_id) VALUES (1, 1);
INSERT INTO ReadList (reader_id, book_id) VALUES (2, 2);
INSERT INTO ReadList (reader_id, book_id) VALUES (2, 1);
-- Review-taulun testidata
INSERT INTO Review (user_id, reader_id, score, review_text) VALUES (1, 1, 5, 'Awesome book!');