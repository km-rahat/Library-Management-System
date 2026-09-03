-- =====================================================
-- Bashundhara Library System — Database Schema
-- Database name must be "webtech" (matches Model/db.php)
--
-- NOTE: This schema is INFERRED from the column names your
-- PHP code already uses (e.g. members.role, books.total_copies,
-- borrow_records.status, borrow_records.book_id). If your
-- original database had extra columns (like a due_date on
-- borrow_records), add them — the "pending_returns" stat in
-- the admin dashboard is left at 0 until that column exists.
-- =====================================================

CREATE DATABASE IF NOT EXISTS webtech;
USE webtech;

-- ---------------------------------------------------
-- Users (members / librarians / admins all live here —
-- your login and registration code both query "members")
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('member', 'librarian', 'admin') NOT NULL DEFAULT 'member',
    created_at DATE NOT NULL
);

-- ---------------------------------------------------
-- Genres
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS genres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    genre_name VARCHAR(100) NOT NULL
);

-- ---------------------------------------------------
-- Books
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    author VARCHAR(150) NOT NULL,
    isbn VARCHAR(50),
    total_copies INT NOT NULL DEFAULT 1,
    genre_id INT,
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE SET NULL
);

-- ---------------------------------------------------
-- Borrow records (issued/returned books)
-- ---------------------------------------------------
CREATE TABLE IF NOT EXISTS borrow_records (
    id INT AUTO_INCREMENT PRIMARY KEY,
    book_id INT NOT NULL,
    member_id INT NOT NULL,
    status ENUM('Active', 'Returned') NOT NULL DEFAULT 'Active',
    borrow_date DATE NOT NULL,
    return_date DATE NULL,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (member_id) REFERENCES members(id) ON DELETE CASCADE
);

-- ---------------------------------------------------
-- Seed data: one admin account so you can log in
-- immediately and reach the Admin Dashboard / Users page.
-- Password is plain text "admin123" — matches how the
-- rest of the project currently stores passwords.
-- Change it after first login.
-- ---------------------------------------------------
INSERT INTO members (name, email, phone, password_hash, role, created_at)
VALUES ('Admin', 'admin@library.com', '01700000000', 'admin123', 'admin', CURDATE());

-- Optional: a couple of sample genres/books so BookList.php
-- and member_books.php aren't empty on first run.
INSERT INTO genres (genre_name) VALUES ('Fiction'), ('Technology'), ('Science');

INSERT INTO books (title, author, isbn, total_copies, genre_id)
VALUES
('Database Systems', 'Raghu Ramakrishnan', '9780072465631', 3, 2),
('Web Technology', 'Achyut Godbole', '9780070146457', 2, 2),
('A Brief History of Time', 'Stephen Hawking', '9780553380163', 1, 3);
