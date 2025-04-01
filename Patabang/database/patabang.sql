-- Create Database
CREATE DATABASE IF NOT EXISTS patabang;
USE patabang;

-- Create Users Table (Students & Tutors)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'tutor') NOT NULL,
    mbti_type VARCHAR(4), -- Stores MBTI type (e.g., INFP, ESTJ)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create MBTI Test Results Table
CREATE TABLE mbti_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    mbti_type VARCHAR(4) NOT NULL,
    test_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create Tutors Table
CREATE TABLE tutors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    specialization TEXT NOT NULL, -- Subjects they can teach
    availability TEXT NOT NULL, -- Available schedule
    rating DECIMAL(3,2) DEFAULT 0.00, -- Tutor's average rating
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create Tutor Matching Table (Student Requests a Tutor)
CREATE TABLE tutor_matching (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    tutor_id INT NOT NULL,
    status ENUM('pending', 'matched', 'rejected') DEFAULT 'pending',
    requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (tutor_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create Bookings Table (After Tutor is Matched)
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    tutor_id INT NOT NULL,
    session_date DATETIME NOT NULL,
    status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (tutor_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create Ratings Table (Students Rate Tutors)
CREATE TABLE tutor_ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    tutor_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5), -- 1-5 star rating system
    review TEXT,
    rated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (tutor_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create Session Logs Table (Track Tutoring Sessions)
CREATE TABLE session_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    student_id INT NOT NULL,
    tutor_id INT NOT NULL,
    session_notes TEXT,
    session_start TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    session_end TIMESTAMP NULL,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (tutor_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE mbti_test_results (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    mbti_type VARCHAR(4) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE tutor_ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tutor_id INT NOT NULL,
    student_id INT NOT NULL,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    feedback TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tutor_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE
);


-- Sample Data for Users
INSERT INTO users (name, email, password, role, mbti_type) VALUES
('John Doe', 'john@example.com', MD5('password123'), 'student', 'INFP'),
('Jane Smith', 'jane@example.com', MD5('securepass'), 'tutor', 'ENTP');

-- Sample Data for Tutors
INSERT INTO tutors (user_id, specialization, availability) VALUES
(2, 'Mathematics, Physics', 'Monday-Friday 3PM-6PM');

-- Sample Tutor Matching Request
INSERT INTO tutor_matching (student_id, tutor_id, status) VALUES
(1, 2, 'matched');

-- Sample Booking
INSERT INTO bookings (student_id, tutor_id, session_date, status) VALUES
(1, 2, '2025-03-20 14:00:00', 'confirmed');

-- Sample Rating
INSERT INTO tutor_ratings (student_id, tutor_id, rating, review) VALUES
(1, 2, 5, 'Great tutor! Very helpful.');

-- Sample Session Log
INSERT INTO session_logs (booking_id, student_id, tutor_id, session_notes) VALUES
(1, 1, 2, 'Covered algebra and trigonometry concepts.');
