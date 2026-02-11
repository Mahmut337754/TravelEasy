DROP DATABASE IF EXISTS TravelEasy;
CREATE DATABASE TravelEasy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE TravelEasy;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

INSERT INTO roles (name) VALUES
('Administrator'),
('Manager'),
('Financial'),
('Advisor');

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO users (name,email,password_hash,role_id) VALUES
('Alice Admin','alice@traveleasy.com','$2y$10$examplehash1',1),
('Bob Manager','bob@traveleasy.com','$2y$10$examplehash2',2),
('Carol Finance','carol@traveleasy.com','$2y$10$examplehash3',3),
('David Advisor','david@traveleasy.com','$2y$10$examplehash4',4),
('Eve Advisor','eve@traveleasy.com','$2y$10$examplehash5',4);

CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    address VARCHAR(255),
    birthdate DATE
) ENGINE=InnoDB;

INSERT INTO customers (first_name,last_name,email,phone,address,birthdate) VALUES
('John','Doe','john.doe@example.com','+31 6 12345678','Amsterdam, NL','1980-05-15'),
('Jane','Smith','jane.smith@example.com','+31 6 87654321','Rotterdam, NL','1990-08-22'),
('Mike','Johnson','mike.johnson@example.com','+31 6 23456789','Utrecht, NL','2010-03-10'),
('Sara','Brown','sara.brown@example.com','+31 6 98765432','Eindhoven, NL','2015-07-05'),
('Tom','Davis','tom.davis@example.com','+31 6 34567890','Groningen, NL','2012-12-30');

CREATE TABLE trips (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    base_currency CHAR(3) NOT NULL,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

INSERT INTO trips (title,description,base_currency,created_by) VALUES
('Luxury Paris Tour','5-day luxury tour in Paris', 'EUR', 4),
('Rome Highlights','3-day Rome highlights trip','EUR',4),
('Swiss Alps Adventure','7-day adventure in Swiss Alps','CHF',4),
('Amsterdam Canal Cruise','2-day Amsterdam luxury cruise','EUR',4),
('Barcelona Gourmet','4-day gourmet experience in Barcelona','EUR',4);

CREATE TABLE accommodations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type VARCHAR(50),
    address VARCHAR(255),
    contact_email VARCHAR(100),
    contact_phone VARCHAR(20)
) ENGINE=InnoDB;

INSERT INTO accommodations (name,type,address,contact_email,contact_phone) VALUES
('Hotel Paris Luxe','Hotel','123 Champs-Élysées, Paris, FR','info@parisluxe.com','+33 1 23456789'),
('Rome Inn','B&B','45 Via Roma, Rome, IT','contact@romeinn.it','+39 06 98765432'),
('Alpine Lodge','Hotel','Alpstrasse 12, Swiss Alps, CH','stay@alpinelodge.ch','+41 44 1234567'),
('Amsterdam Grand Hotel','Hotel','Dam Square 1, Amsterdam, NL','book@amsterdamgrand.nl','+31 20 1234567'),
('Barcelona Gourmet Suites','Apartment','Carrer de la Boqueria 20, Barcelona, ES','stay@barcelonagourmet.es','+34 93 1234567');

CREATE TABLE trip_accommodations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    trip_id INT NOT NULL,
    accommodation_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    room_type VARCHAR(50),
    board_type VARCHAR(50),
    price_per_night DECIMAL(10,2) NOT NULL,
    currency CHAR(3) NOT NULL,
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE,
    FOREIGN KEY (accommodation_id) REFERENCES accommodations(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO trip_accommodations (trip_id,accommodation_id,check_in,check_out,room_type,board_type,price_per_night,currency) VALUES
(1,1,'2026-06-01','2026-06-06','Deluxe','Full Board',350,'EUR'),
(2,2,'2026-07-10','2026-07-13','Standard','Breakfast',120,'EUR'),
(3,3,'2026-08-01','2026-08-08','Suite','Half Board',400,'CHF'),
(4,4,'2026-09-05','2026-09-07','Executive','Breakfast',200,'EUR'),
(5,5,'2026-10-10','2026-10-14','Apartment','None',300,'EUR');

CREATE TABLE transports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    type VARCHAR(50) NOT NULL,
    provider VARCHAR(100),
    base_price DECIMAL(10,2) NOT NULL,
    currency CHAR(3) NOT NULL
) ENGINE=InnoDB;

INSERT INTO transports (type,provider,base_price,currency) VALUES
('Flight','Air France',450,'EUR'),
('Train','Trenitalia',80,'EUR'),
('Flight','Swiss Air',500,'CHF'),
('Bus','Amsterdam Tours',40,'EUR'),
('Flight','Vueling',300,'EUR');

CREATE TABLE extras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    per_person BOOLEAN NOT NULL,
    currency CHAR(3) NOT NULL
) ENGINE=InnoDB;

INSERT INTO extras (name,price,per_person,currency) VALUES
('City Museum Pass',50,TRUE,'EUR'),
('Wine Tasting',120,TRUE,'EUR'),
('Guided Hike',80,TRUE,'CHF'),
('Canal Dinner Cruise',100,TRUE,'EUR'),
('Cooking Class',90,TRUE,'EUR');

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    trip_id INT NOT NULL,
    status ENUM('option','confirmed','cancelled') DEFAULT 'option',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    confirmed_at TIMESTAMP NULL,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (trip_id) REFERENCES trips(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO bookings (customer_id,trip_id,status,confirmed_at) VALUES
(1,1,'confirmed','2026-02-01 10:00:00'),
(2,2,'option',NULL),
(3,3,'confirmed','2026-02-05 14:30:00'),
(4,4,'cancelled','2026-02-07 09:15:00'),
(5,5,'confirmed','2026-02-10 16:45:00');

CREATE TABLE booking_participants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    type ENUM('adult','child','baby') NOT NULL,
    birthdate DATE NOT NULL,
    calculated_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO booking_participants (booking_id,type,birthdate,calculated_price) VALUES
(1,'adult','1980-05-15',500),
(1,'child','2012-03-10',450),
(2,'adult','1990-08-22',400),
(2,'adult','1985-11-05',400),
(3,'adult','2010-03-10',350);

CREATE TABLE booking_extras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    extra_id INT NOT NULL,
    quantity INT DEFAULT 1,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
    FOREIGN KEY (extra_id) REFERENCES extras(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO booking_extras (booking_id,extra_id,quantity) VALUES
(1,1,2),
(1,2,2),
(2,3,1),
(3,4,2),
(5,5,1);
