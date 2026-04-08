DROP DATABASE IF EXISTS tp_entornos_graficos;
CREATE DATABASE tp_entornos_graficos;
USE tp_entornos_graficos;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin', 'ceo', 'customer') NOT NULL DEFAULT 'customer',
  email_verified TINYINT(1) NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE airlines (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  code VARCHAR(10) NOT NULL UNIQUE,
  country VARCHAR(80) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE flights (
  id INT AUTO_INCREMENT PRIMARY KEY,
  airline_id INT NOT NULL,
  origin VARCHAR(80) NOT NULL,
  destination VARCHAR(80) NOT NULL,
  departure_time DATETIME NOT NULL,
  arrival_time DATETIME NOT NULL,
  price DECIMAL(10, 2) NOT NULL,
  total_seats INT NOT NULL,
  available_seats INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_flights_airline FOREIGN KEY (airline_id) REFERENCES airlines(id)
);

CREATE TABLE promotions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  airline_id INT NOT NULL,
  title VARCHAR(140) NOT NULL,
  description TEXT,
  discount_percent DECIMAL(5, 2) NOT NULL,
  status ENUM('pending', 'approved', 'denied') NOT NULL DEFAULT 'pending',
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  active_airline_id INT GENERATED ALWAYS AS (CASE WHEN is_active = 1 THEN airline_id ELSE NULL END) STORED,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_promotions_airline FOREIGN KEY (airline_id) REFERENCES airlines(id),
  CONSTRAINT uq_promotions_one_active UNIQUE (active_airline_id)
);

CREATE TABLE reservations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  flight_id INT NOT NULL,
  seats INT NOT NULL,
  total_amount DECIMAL(10, 2) NOT NULL,
  status ENUM('pending', 'confirmed', 'cancelled') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_reservations_user FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT fk_reservations_flight FOREIGN KEY (flight_id) REFERENCES flights(id)
);

CREATE TABLE news (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Datos semilla para pruebas rapidas.
INSERT INTO users (name, email, password_hash, role, email_verified) VALUES
('Admin Principal', 'admin@tp.com', '123456', 'admin', 1),
('CEO Andes Airlines', 'ceo@tp.com', '123456', 'ceo', 1),
('Cliente Demo', 'cliente@tp.com', '123456', 'customer', 1);

INSERT INTO airlines (name, code, country) VALUES
('Andes Airlines', 'AND', 'Argentina'),
('Pampa Fly', 'PAM', 'Argentina');

INSERT INTO flights (airline_id, origin, destination, departure_time, arrival_time, price, total_seats, available_seats) VALUES
(1, 'Cordoba', 'Buenos Aires', '2026-05-15 09:00:00', '2026-05-15 10:15:00', 85000.00, 120, 120),
(1, 'Mendoza', 'Neuquen', '2026-05-20 14:00:00', '2026-05-20 15:20:00', 62000.00, 90, 90),
(2, 'Rosario', 'Bariloche', '2026-06-10 08:30:00', '2026-06-10 11:10:00', 110000.00, 140, 140);

INSERT INTO promotions (airline_id, title, description, discount_percent, status, is_active) VALUES
(1, 'Promo Otono', '15% off para vuelos nacionales', 15.00, 'approved', 1),
(2, 'Promo Junio', '10% off en rutas patagonicas', 10.00, 'pending', 1);

INSERT INTO news (title, content) VALUES
('Nueva ruta Cordoba - Salta', 'Desde junio habilitamos nuevas frecuencias semanales.'),
('Check-in digital mejorado', 'Ahora podes hacer check-in 48hs antes de tu vuelo.');
