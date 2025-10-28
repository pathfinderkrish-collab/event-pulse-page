CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role ENUM('student','organizer','admin') DEFAULT 'student',
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    rollno VARCHAR(50) DEFAULT NULL,
    branch VARCHAR(100) DEFAULT NULL,
    year YEAR DEFAULT NULL,
    contact VARCHAR(15) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    poster_name VARCHAR(255),
    poster_type VARCHAR(100),
    poster_size INT,
    poster_data LONGBLOB,
    qrcode_name VARCHAR(255),
    qrcode_type VARCHAR(100),
    qrcode_size INT,
    qrcode_data LONGBLOB,
    event_name VARCHAR(255) NOT NULL,
    short_details TEXT NOT NULL,
    about_event TEXT NOT NULL,
    event_date DATE NOT NULL,
    event_start_time TIME NOT NULL,
    event_end_time TIME NOT NULL,
    event_location VARCHAR(255) NOT NULL,
    event_category VARCHAR(50) NOT NULL,
    event_organiser VARCHAR(255) NOT NULL,
    admin_contact VARCHAR(255) NOT NULL,
    public_contact VARCHAR(255) NOT NULL,
    event_type ENUM('free','paid') DEFAULT 'free',
    reg_type ENUM('qrcode','form') DEFAULT 'form',
    what_to_expect TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    organizer_id INT NOT NULL,
    FOREIGN KEY (organizer_id) REFERENCES users(id) ON DELETE CASCADE
);




CREATE TABLE registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    student_id INT NOT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE(event_id, student_id)
);

CREATE TABLE email_verification (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL UNIQUE,
    is_verified BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE new_events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    poster_name VARCHAR(255),
    poster_type VARCHAR(100),
    poster_size INT,
    poster_data LONGBLOB,
    qrcode_name VARCHAR(255),
    qrcode_type VARCHAR(100),
    qrcode_size INT,
    qrcode_data LONGBLOB,
    event_name VARCHAR(255) NOT NULL,
    short_details TEXT NOT NULL,
    about_event TEXT NOT NULL,
    event_date DATE NOT NULL,
    event_start_time TIME NOT NULL,
    event_end_time TIME NOT NULL,
    event_location VARCHAR(255) NOT NULL,
    event_category VARCHAR(50) NOT NULL,
    event_organiser VARCHAR(255) NOT NULL,
    admin_contact VARCHAR(255) NOT NULL,
    public_contact VARCHAR(255) NOT NULL,
    event_type ENUM('free','paid') DEFAULT 'free',
    reg_type ENUM('qrcode','form') DEFAULT 'form',
    what_to_expect TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    organizer_id INT NOT NULL,
    FOREIGN KEY (organizer_id) REFERENCES users(id) ON DELETE CASCADE
);

