-- Job Portal Database Schema + Sample Data
-- Database: jobportal

-- Drop database if it exists
DROP DATABASE IF EXISTS jobportal;
CREATE DATABASE jobportal;
USE jobportal;

-- ==========================
-- Table: users
-- ==========================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Employer', 'Job Seeker') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample Users
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@example.com', SHA2('admin123', 256), 'Admin'),
('employer1', 'employer1@example.com', SHA2('employer123', 256), 'Employer'),
('seeker1', 'seeker1@example.com', SHA2('seeker123', 256), 'Job Seeker');

-- ==========================
-- Table: jobs
-- ==========================
CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    company VARCHAR(100) NOT NULL,
    location VARCHAR(100) NOT NULL,
    salary VARCHAR(50),
    employer_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employer_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Sample Jobs
INSERT INTO jobs (title, description, company, location, salary, employer_id) VALUES
('Web Developer', 'Looking for a skilled PHP developer', 'TechSoft Ltd.', 'Dhaka', '40,000 BDT', 2),
('Graphic Designer', 'Creative designer needed for digital marketing projects', 'DesignPro Studio', 'Chittagong', '30,000 BDT', 2);

-- ==========================
-- Table: job_applications
-- ==========================
CREATE TABLE job_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT,
    seeker_id INT,
    applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (seeker_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Sample Applications
INSERT INTO job_applications (job_id, seeker_id) VALUES
(1, 3),
(2, 3);

-- ==========================
-- Table: activity_logs
-- ==========================
CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(255) NOT NULL,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Sample Logs
INSERT INTO activity_logs (user_id, action) VALUES
(1, 'Admin logged in'),
(2, 'Employer posted a job'),
(3, 'Job Seeker applied for a job');
