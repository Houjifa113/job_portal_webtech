-- ------------------------------------------------------------
-- Job Portal - Database Design
-- ------------------------------------------------------------

-- Recreate database cleanly (optional if importing first time)
SET FOREIGN_KEY_CHECKS = 0;
DROP DATABASE IF EXISTS job_portal;
SET FOREIGN_KEY_CHECKS = 1;

CREATE DATABASE job_portal
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE job_portal;

-- -------------------------
-- users
-- -------------------------
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('Admin','Employer','Job Seeker') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_users_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------
-- jobs
-- -------------------------
CREATE TABLE jobs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  description TEXT NOT NULL,
  location VARCHAR(100) NOT NULL,
  salary VARCHAR(50) NOT NULL,
  employer_id INT NOT NULL,
  status ENUM('Active','Inactive','Pending') DEFAULT 'Active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_jobs_employer (employer_id),
  CONSTRAINT fk_jobs_employer
    FOREIGN KEY (employer_id) REFERENCES users(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------
-- activity_logs
-- (user_id nullable so logs stay if a user is deleted)
-- -------------------------
CREATE TABLE activity_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NULL,
  user_name VARCHAR(100) NOT NULL,
  action VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_logs_user (user_id),
  CONSTRAINT fk_logs_user
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------
-- job_applications
-- -------------------------
CREATE TABLE job_applications (
  id INT AUTO_INCREMENT PRIMARY KEY,
  job_id INT NOT NULL,
  jobseeker_id INT NOT NULL,
  applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_job_applicant (job_id, jobseeker_id),
  INDEX idx_app_job (job_id),
  INDEX idx_app_jobseeker (jobseeker_id),
  CONSTRAINT fk_app_job
    FOREIGN KEY (job_id) REFERENCES jobs(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_app_jobseeker
    FOREIGN KEY (jobseeker_id) REFERENCES users(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Done.
