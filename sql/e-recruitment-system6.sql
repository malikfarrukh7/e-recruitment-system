-- Create the Candidates table
CREATE TABLE candidates (
    id VARCHAR(10) PRIMARY KEY,  -- Adjusted to store 'CD01', 'CD02', etc.
    name VARCHAR(255) NOT NULL,
    cnic VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,  -- Email should be unique
    phone VARCHAR(20) NOT NULL,
    town VARCHAR(100) NOT NULL,
    region VARCHAR(100) NOT NULL,
    postcode VARCHAR(10) NOT NULL,
    country VARCHAR(100) NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active'
   /* status  VARCHAR(10) NOT NULL */
);

-- Create the Recruiters table
CREATE TABLE recruiters (
    id VARCHAR(10) PRIMARY KEY,  -- Adjusted to store 'RT01', 'RT02', etc.
    name VARCHAR(255) NOT NULL,
    cnic VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,  -- Email should be unique
    phone VARCHAR(20) NOT NULL,
    town VARCHAR(100) NOT NULL,
    region VARCHAR(100) NOT NULL,
    postcode VARCHAR(10) NOT NULL,
    country VARCHAR(100) NOT NULL,
    status ENUM('active', 'inactive') DEFAULT 'active'
   /* status  VARCHAR(10) NOT NULL */
);

-- Create the Admins table
CREATE TABLE admins (
    id VARCHAR(10) PRIMARY KEY,  -- Adjusted to store 'AD01', 'AD02', etc.
    name VARCHAR(255) NOT NULL,
    cnic VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,  -- Email should be unique
    phone VARCHAR(20) NOT NULL,
    town VARCHAR(100) NOT NULL,
    region VARCHAR(100) NOT NULL,
    postcode VARCHAR(10) NOT NULL,
    country VARCHAR(100) NOT NULL,
 /* status  VARCHAR(10) NOT NULL */
    status ENUM('active', 'inactive') DEFAULT 'active'
);

-- Create the Jobs table
CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique job ID
    recruiter_id VARCHAR(10), 
    job_category VARCHAR(10),          -- Foreign key to reference the recruiters table
    title VARCHAR(255) NOT NULL,        -- Job title
    description TEXT NOT NULL,          -- Job description
    requirements TEXT NOT NULL,         -- Job requirements
    location VARCHAR(255) NOT NULL,     -- Job location
    industry VARCHAR(255) NOT NULL,
    job_vacancy INT,     -- Job industry
    status ENUM('active', 'inactive') DEFAULT 'active',  -- Job status
    posted_date DATE NOT NULL,          -- Job posting date
    last_modified DATE,                 -- Last modified date for edits
    salary DECIMAL(10,2) DEFAULT NULL,
    FOREIGN KEY (recruiter_id) REFERENCES recruiters(id) ON DELETE CASCADE  -- Link to recruiters table
);

-- Create the Job Search Index (optional for faster searches)
CREATE INDEX idx_job_search ON jobs (title, location, industry);

-- Create the Job Applications table (for candidates applying to jobs)
CREATE TABLE job_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    candidate_id VARCHAR(10),           -- Foreign key to reference candidates
    job_id INT,                         -- Foreign key to reference jobs
    status ENUM('applied', 'reviewed', 'rejected', 'accepted') DEFAULT 'applied', -- Application status
    applied_date DATE NOT NULL,         -- Date of application
    FOREIGN KEY (candidate_id) REFERENCES candidates(id),
    FOREIGN KEY (job_id) REFERENCES jobs(id)
);


/*CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique application ID
    candidate_id VARCHAR(10),  -- Foreign key to reference candidates table
    job_id INT,  -- Foreign key to reference jobs table
    status ENUM('applied', 'under review', 'shortlisted', 'rejected') DEFAULT 'applied',  -- Application status
    applied_date DATE NOT NULL,  -- Date of application
    FOREIGN KEY (candidate_id) REFERENCES candidates(id),
    FOREIGN KEY (job_id) REFERENCES jobs(id)
);*/

CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique application ID
    candidate_id VARCHAR(10),  -- Foreign key to reference candidates table
    job_id INT,  -- Foreign key to reference jobs table
    job_name VARCHAR(255),  -- Name of the job
    r_percentage DECIMAL(5,2),  -- Percentage obtained
    cv_file VARCHAR(255),
    status ENUM('applied', 'under review', 'shortlisted', 'rejected') DEFAULT 'applied',  -- Application status
    applied_date DATE NOT NULL,  -- Date of application
    FOREIGN KEY (candidate_id) REFERENCES candidates(id)  ON DELETE CASCADE,
    FOREIGN KEY (job_id) REFERENCES jobs(id)  ON DELETE CASCADE
);



CREATE TABLE qualifications (
    id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique qualification ID
    candidate_id VARCHAR(10),  -- Foreign key to reference candidates table
    degree_level ENUM('Intermediate', 'Bachelor', 'Master', 'PhD') NOT NULL,  -- Degree level
    major_subject VARCHAR(255) NOT NULL,  -- Major subject studied
    institution VARCHAR(255) NOT NULL,  -- Name of the institution
    obtained_percentage DECIMAL(5,2),  -- Percentage obtained
    resume_file_path VARCHAR(255),  -- Path to resume file
    start_date DATE,  -- Start date of the degree
    end_date DATE,  -- End date of the degree
    FOREIGN KEY (candidate_id) REFERENCES candidates(id)  ON DELETE CASCADE
);


CREATE TABLE shortlisted_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT,
    recruiter_id VARCHAR(10),  -- Changed to VARCHAR(10) to match the recruiters table
    shortlisted_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (application_id) REFERENCES applications(id)  ON DELETE CASCADE,
    FOREIGN KEY (recruiter_id) REFERENCES recruiters(id)  ON DELETE CASCADE
);

/*
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id VARCHAR(10) NOT NULL,          -- Updated to VARCHAR(10) to match recruiters.id
    receiver_id VARCHAR(10) NOT NULL,        -- Updated to VARCHAR(10) to match candidates.id
    application_id INT NOT NULL,             -- Foreign key to applications table
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES recruiters(id),
    FOREIGN KEY (receiver_id) REFERENCES candidates(id),
    FOREIGN KEY (application_id) REFERENCES applications(id)
);*/

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id VARCHAR(10) NOT NULL,            -- Matches recruiters.id type
    receiver_id VARCHAR(10) NOT NULL,          -- Matches candidates.id type
    application_id INT NOT NULL,               -- Foreign key to applications table
    subject VARCHAR(255) NOT NULL,             -- New subject field
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES recruiters(id)  ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES candidates(id)  ON DELETE CASCADE,
    FOREIGN KEY (application_id) REFERENCES applications(id)  ON DELETE CASCADE

);


CREATE TABLE interviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    recruiter_id VARCHAR(10) NOT NULL,
    candidate_id VARCHAR(10) NOT NULL,
    job_name VARCHAR(255) NOT NULL,
    interview_date DATE NOT NULL,
    interview_time TIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (application_id) REFERENCES applications(id) ON DELETE CASCADE
);


CREATE TABLE calendar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recruiter_id VARCHAR(10) NOT NULL,
    job_name VARCHAR(255) NOT NULL,
    interview_date DATE NOT NULL,
    interview_time TIME NOT NULL,
    interview_count INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE managers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    calendar_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (calendar_id) REFERENCES calendar(id) ON DELETE CASCADE
);


CREATE TABLE interviewers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(15),
    calendar_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (calendar_id) REFERENCES calendar(id) ON DELETE CASCADE
);


CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_type ENUM('candidate', 'website', 'recruiter') NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
 