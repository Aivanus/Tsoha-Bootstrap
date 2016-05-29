-- Lisää INSERT INTO lauseet tähän tiedostoon
-- Reader-taulun testidata
INSERT INTO Reader (username, password) VALUES ('Test', 'password');
INSERT INTO Reader (username, password) VALUES ('DDO', '1337');
-- Book-taulun testidata
INSERT INTO Book (title, author) VALUES ('To Kill A Mockingbird', 'Harper Lee');
INSERT INTO Book (title, author) VALUES ('Neuromancer', 'William Gibson');
-- Readinglist-taulun testidata
INSERT INTO ReadingList (reader_id, book_id) VALUES (1, 1);
INSERT INTO ReadingList (reader_id, book_id) VALUES (2, 2);
INSERT INTO ReadingList (reader_id, book_id) VALUES (2, 1);
-- Review-taulun testidata
INSERT INTO Review (reader_id, book_id, score, review_text) VALUES (1, 1, 5, 'Awesome book!');