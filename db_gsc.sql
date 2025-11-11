-- 🔄 Réinitialiser complètement la base
DROP DATABASE IF EXISTS db_gsc;
CREATE DATABASE db_gsc;
USE db_gsc;

-- 1️⃣ Table roles
CREATE TABLE roles (
    role_id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(50) NOT NULL UNIQUE,
    role_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO roles (role_name) VALUES ('Super admin');

-- 2️⃣ Table access
CREATE TABLE access (
    access_id INT PRIMARY KEY AUTO_INCREMENT,
    access_name VARCHAR(255) NOT NULL UNIQUE,
    access_section VARCHAR(255) NOT NULL DEFAULT 'autre',
    access_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO access (access_name, access_section)
VALUES ('add-personal', 'personals');
INSERT INTO access (access_name, access_section)
VALUES ('list-personal', 'personals');

-- 3️⃣ Table roles_access
CREATE TABLE roles_access (
    role_access_id INT PRIMARY KEY AUTO_INCREMENT,
    role_id INT NOT NULL,
    access_id INT NOT NULL,
    role_access_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(role_id) ON DELETE CASCADE,
    FOREIGN KEY (access_id) REFERENCES access(access_id) ON DELETE CASCADE
);

INSERT INTO roles_access (role_id, access_id) VALUES (1, 1);
INSERT INTO roles_access (role_id, access_id) VALUES (1, 2);

-- 4️⃣ Table years
CREATE TABLE years (
    year_id INT PRIMARY KEY AUTO_INCREMENT,
    year_name VARCHAR(9) NOT NULL UNIQUE,
    year_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 5️⃣ Table places
CREATE TABLE places (
    place_id INT PRIMARY KEY AUTO_INCREMENT,
    place_name VARCHAR(255) NOT NULL UNIQUE,
    place_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 6️⃣ Table cycles
CREATE TABLE cycles (
    cycle_id INT PRIMARY KEY AUTO_INCREMENT,
    cycle_name VARCHAR(10) NOT NULL UNIQUE,
    cycle_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 7️⃣ Table levels
CREATE TABLE levels (
    level_id INT PRIMARY KEY AUTO_INCREMENT,
    level_name VARCHAR(10) NOT NULL,
    level_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 8️⃣ Table rooms
CREATE TABLE rooms (
    room_id INT PRIMARY KEY AUTO_INCREMENT,
    room_name VARCHAR(10) NOT NULL UNIQUE,
    room_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 9️⃣ Table series
CREATE TABLE series (
    serie_id INT PRIMARY KEY AUTO_INCREMENT,
    serie_name VARCHAR(2) NOT NULL UNIQUE,
    serie_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 🔟 Table courses
CREATE TABLE courses (
    course_id INT PRIMARY KEY AUTO_INCREMENT,
    course_name VARCHAR(30) NOT NULL UNIQUE,
    course_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 11️⃣ Table schoolings
CREATE TABLE schoolings (
    schooling_id INT PRIMARY KEY AUTO_INCREMENT,
    schooling_name VARCHAR(50) NOT NULL UNIQUE,
    schooling_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- 12️⃣ Table fees
CREATE TABLE fees (
    fee_id INT PRIMARY KEY AUTO_INCREMENT,
    level_id INT NOT NULL,
    schooling_id INT NOT NULL,
    fee_amount DECIMAL(10, 2) NOT NULL,
    tranche1 DECIMAL(10, 2) NULL,
    tranche2 DECIMAL(10, 2) NULL,
    tranche3 DECIMAL(10, 2) NULL,
    fee_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (level_id) REFERENCES levels(level_id) ON DELETE CASCADE,
    FOREIGN KEY (schooling_id) REFERENCES schoolings(schooling_id) ON DELETE CASCADE
);


-- 13️⃣ Table users
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    role_id INT NOT NULL,
    user_adder_id INT NOT NULL,
    user_firstname VARCHAR(30) NOT NULL,
    user_lastname VARCHAR(30) NOT NULL,
    user_birth_date DATE NOT NULL,
    user_sex VARCHAR(8) NOT NULL,
    user_phone VARCHAR(20) NOT NULL UNIQUE,
    user_email VARCHAR(255) NOT NULL UNIQUE,
    user_password VARCHAR(255) NOT NULL,
    user_first_connection INT NOT NULL DEFAULT 0,
    user_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

INSERT INTO users (
    role_id, 
    user_adder_id,
    user_firstname, 
    user_lastname,
    user_birth_date, 
    user_sex, 
    user_phone,
    user_email, 
    user_password
) VALUES (
    1, 1, 'admin', 'ADMIN', '2001-05-20', 'Masculin',
    '0144781021', 'admin@gmail.com',
    '$2y$10$DNWoMAyhGAifeDIZWbHWZ.kJKUvJ1YVgGGSNVq0fFGUxIeqqDl2mK'
);

-- 14️⃣ Table personals
CREATE TABLE personals (
    personal_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    place_id INT NOT NULL,
    personal_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (place_id) REFERENCES places(place_id)
);

-- 15️⃣ Table teachers
CREATE TABLE teachers (
    teacher_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    teacher_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 16️⃣ Table parents
CREATE TABLE parents (
    parent_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    parent_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 17️⃣ Table students
CREATE TABLE students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    parent_id INT NOT NULL,
    year_id INT NOT NULL,
    place_id INT NOT NULL,
    cycle_id INT NOT NULL,
    level_id INT NOT NULL,
    serie_id INT NOT NULL,
    room_id INT NOT NULL,
    student_matricule VARCHAR(15) NOT NULL,
    student_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES parents(parent_id) ON DELETE CASCADE,
    FOREIGN KEY (year_id) REFERENCES years(year_id),
    FOREIGN KEY (place_id) REFERENCES places(place_id),
    FOREIGN KEY (cycle_id) REFERENCES cycles(cycle_id),
    FOREIGN KEY (level_id) REFERENCES levels(level_id),
    FOREIGN KEY (serie_id) REFERENCES series(serie_id),
    FOREIGN KEY (room_id) REFERENCES rooms(room_id)
);

-- 18️⃣ Table reinscriptions
CREATE TABLE reinscriptions (
    reinscription_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    year_id INT NOT NULL,
    place_id INT NOT NULL,
    level_id INT NOT NULL,
    serie_id INT NOT NULL,
    room_id INT NOT NULL,
    reinscription_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE,
    FOREIGN KEY (year_id) REFERENCES years(year_id),
    FOREIGN KEY (place_id) REFERENCES places(place_id),
    FOREIGN KEY (level_id) REFERENCES levels(level_id),
    FOREIGN KEY (serie_id) REFERENCES series(serie_id),
    FOREIGN KEY (room_id) REFERENCES rooms(room_id)
);

-- 19️⃣ Table schedules
CREATE TABLE schedules (
    schedule_id INT PRIMARY KEY AUTO_INCREMENT,
    teacher_id INT NOT NULL,
    year_id INT NOT NULL,
    place_id INT NOT NULL,
    cycle_id INT NOT NULL,
    level_id INT NOT NULL,
    serie_id INT NOT NULL,
    course_id INT NOT NULL,
    schedule_day VARCHAR(15),
    schedule_start_time TIME,
    schedule_end_time TIME,
    room_id INT NOT NULL,
    schedule_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id) ON DELETE CASCADE,
    FOREIGN KEY (year_id) REFERENCES years(year_id),
    FOREIGN KEY (place_id) REFERENCES places(place_id),
    FOREIGN KEY (cycle_id) REFERENCES cycles(cycle_id),
    FOREIGN KEY (level_id) REFERENCES levels(level_id),
    FOREIGN KEY (serie_id) REFERENCES series(serie_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id),
    FOREIGN KEY (room_id) REFERENCES rooms(room_id)
);

-- 20️⃣ Table grades
CREATE TABLE grades (
    grade_id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    student_id INT NOT NULL,
    grade_first_interro DECIMAL(5,2) NOT NULL,
    grade_second_interro DECIMAL(5,2) NOT NULL,
    grade_third_interro DECIMAL(5,2) NOT NULL,
    grade_first_duty DECIMAL(5,2) NOT NULL,
    grade_second_duty DECIMAL(5,2) NOT NULL,
    grade_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES courses(course_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
);

-- 21️⃣ Table payements
CREATE TABLE payements (
    payement_id INT PRIMARY KEY AUTO_INCREMENT,
    schooling_id INT NOT NULL,
    student_id INT NOT NULL,
    payement_date DATE NOT NULL,
    payement_amount DECIMAL(10, 2) NOT NULL,
    payement_mode VARCHAR(50) NOT NULL,
    payement_statut VARCHAR(50) NOT NULL,
    payement_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (schooling_id) REFERENCES schoolings(schooling_id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
);

-- 22️⃣ Table invoices
CREATE TABLE invoices (
    invoice_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    invoice_date DATE NOT NULL,
    invoice_amount DECIMAL(10, 2) NOT NULL,
    invoice_due_date DATE,
    invoice_description_service VARCHAR(255),
    invoice_date_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE
);
