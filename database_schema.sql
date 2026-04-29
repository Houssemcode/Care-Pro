-- Create the database
CREATE DATABASE IF NOT EXISTS care_db;
USE care_db;

-- 1. Create Base User Table
CREATE TABLE User (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    phone VARCHAR(255)
);

-- 2. Create Roles (Admin, Employee, Family) referencing User
CREATE TABLE Admin (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES User(id)
);

CREATE TABLE Employee (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    experience VARCHAR(255),
    diploma VARCHAR(255),
    status VARCHAR(255),
    description VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES User(id)
);

CREATE TABLE Family (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    address VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES User(id)
);

-- 3. Create Localization referencing User
CREATE TABLE Localization (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    wilaya VARCHAR(255),
    commune VARCHAR(255),
    latitude FLOAT,
    logitude FLOAT, -- Note: Kept exact spelling from DBML
    FOREIGN KEY (user_id) REFERENCES User(id)
);

-- 4. Create Core Services (Offre) referencing Employee
CREATE TABLE Offre (
    id INT PRIMARY KEY AUTO_INCREMENT,
    employee_id INT,
    address VARCHAR(255),
    service_type VARCHAR(255),
    working_house VARCHAR(255),
    address_service VARCHAR(255),
    FOREIGN KEY (employee_id) REFERENCES Employee(id)
);

-- 5. Create Request referencing Offre
CREATE TABLE Request (
    id INT PRIMARY KEY AUTO_INCREMENT,
    offre_id INT,
    start_date DATETIME,
    end_date DATETIME,
    FOREIGN KEY (offre_id) REFERENCES Offre(id)
);

-- 6. Create AssignementService referencing Family and Offre
CREATE TABLE AssignementService (
    id INT PRIMARY KEY AUTO_INCREMENT,
    family_id INT,
    offre_id INT,
    assigned_at DATETIME,
    price VARCHAR(255),
    FOREIGN KEY (family_id) REFERENCES Family(id),
    FOREIGN KEY (offre_id) REFERENCES Offre(id)
);

-- 7. Create Post-Service Operations referencing AssignementService
CREATE TABLE Price (
    id INT PRIMARY KEY AUTO_INCREMENT,
    assignement_id INT,
    FOREIGN KEY (assignement_id) REFERENCES AssignementService(id)
);

CREATE TABLE Rating (
    id INT PRIMARY KEY AUTO_INCREMENT,
    assignement_id INT,
    note VARCHAR(255),
    comentaire VARCHAR(255), -- Note: Kept exact spelling from DBML
    date DATETIME,
    FOREIGN KEY (assignement_id) REFERENCES AssignementService(id)
);

-- 8. Create Rapport referencing Admin, Employee, and Family
CREATE TABLE Rapport (
    id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT,
    employee_id INT,
    family_id INT,
    rapport_reason VARCHAR(255),
    comentaire VARCHAR(255),
    FOREIGN KEY (admin_id) REFERENCES Admin(id),
    FOREIGN KEY (employee_id) REFERENCES Employee(id),
    FOREIGN KEY (family_id) REFERENCES Family(id)
);
