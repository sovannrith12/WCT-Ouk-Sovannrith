create database department;
use department;
CREATE TABLE departments (
    department_id INT PRIMARY KEY AUTO_INCREMENT,
    department_name VARCHAR(50) NOT NULL
);

CREATE TABLE Faculty (
    faculty_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    department_id INT,
    FOREIGN KEY (department_id) REFERENCES Departments(department_id)
);

CREATE TABLE Courses (
    course_code VARCHAR(10) PRIMARY KEY,
    course_name VARCHAR(100) NOT NULL,
    credits INT NOT NULL,
    department_id INT,
    faculty_id INT,
    FOREIGN KEY (department_id) REFERENCES Departments(department_id),
    FOREIGN KEY (faculty_id) REFERENCES Faculty(faculty_id)
);

CREATE TABLE Students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE Enrollments (
    enrollment_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    course_code VARCHAR(10),
    enrollment_date DATE NOT NULL,
    grade VARCHAR(2),
    FOREIGN KEY (student_id) REFERENCES Students(student_id),
    FOREIGN KEY (course_code) REFERENCES Courses(course_code)
);


-- Insert into Departments
INSERT INTO departments (department_name) VALUES
('Computer Science'),
('Engineering'),
('Mathematics');

-- Insert into Faculty
INSERT INTO Faculty (first_name, last_name, department_id) VALUES
('Sovannrith', 'Ouk', 1),
('Tom', 'Hiddleston', 2),
('Chris', 'Hemsworth', 1);

-- Insert into Courses
INSERT INTO courses (course_code, course_name, credits, department_id, faculty_id) VALUES
('CS101', 'ITE', 3, 1, 1),
('EE201', 'Bio Engineering', 4, 2, 2),
('MA105', 'Computer Science', 3, 3, 3);

-- Insert into Students
INSERT INTO Students (first_name, last_name, date_of_birth, email) VALUES
('Anthony', 'Edward', '1980-01-18', 'anthony@example.com'),
('Scarlett', 'Johansson', '1980-05-22', 'scarlet@example.com'),
('Elizabeth', 'Olsen', '1980-11-12', 'elizabeth@example.com');

-- Insert into Enrollments
INSERT INTO Enrollments (student_id, course_code, enrollment_date, grade) VALUES
(1, 'CS101', '2024-10-02', 'A'),
(1, 'MA105', '2024-10-02', 'B'),
(2, 'EE201', '2024-10-02', 'C');

select student_id from Enrollments ;

select * from departments;

SELECT s.first_name, s.last_name
FROM Students s
JOIN Enrollments e ON s.student_id = e.student_id
WHERE e.course_code = 'CS101'; -- Replace 'CS101' with the specific course code

SELECT f.first_name, f.last_name
FROM Faculty f
JOIN Departments d ON f.department_id = d.department_id
WHERE d.department_name = 'Mathematic'; -- Replace 'Mathematic' with the specific department name

SELECT c.course_name
FROM Courses c
JOIN Enrollments e ON c.course_code = e.course_code
JOIN Students s ON e.student_id = s.student_id
WHERE s.first_name = 'Anthony'; -- Replace 'Anthony' with the specific student's first name

SELECT s.first_name, s.last_name
FROM Students s
WHERE s.student_id NOT IN (SELECT DISTINCT student_id FROM Enrollments);

SELECT AVG(CASE
            WHEN e.grade = 'A' THEN 4
            WHEN e.grade = 'B' THEN 3
            WHEN e.grade = 'C' THEN 2
            WHEN e.grade = 'D' THEN 1
            WHEN e.grade = 'F' THEN 0
            ELSE 0  -- Handle other cases or NULL
        END) AS average_grade
FROM Enrollments e
WHERE e.course_code = 'CS101'; -- Replace 'CS101' with the specific course code
