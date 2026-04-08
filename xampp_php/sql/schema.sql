DROP DATABASE IF EXISTS tp_entornos_graficos_php;
CREATE DATABASE tp_entornos_graficos_php CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tp_entornos_graficos_php;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(32) NOT NULL,
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
  price DECIMAL(10,2) NOT NULL,
  total_seats INT NOT NULL,
  available_seats INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_flights_airline FOREIGN KEY (airline_id) REFERENCES airlines(id)
);

CREATE TABLE promotions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  airline_id INT NOT NULL,
  title VARCHAR(150) NOT NULL,
  description TEXT,
  discount_percent DECIMAL(5,2) NOT NULL,
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
  total_amount DECIMAL(10,2) NOT NULL,
  status ENUM('pending', 'confirmed', 'cancelled') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_res_user FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT fk_res_flight FOREIGN KEY (flight_id) REFERENCES flights(id)
);

CREATE TABLE news (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(180) NOT NULL,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuarios demo (password = 123456 con MD5).
INSERT INTO users (name, email, password_hash, role, email_verified) VALUES
('Admin Principal', 'admin@tp.com', MD5('123456'), 'admin', 1),
('CEO Andes Airlines', 'ceo@tp.com', MD5('123456'), 'ceo', 1),
('Cliente Demo', 'cliente@tp.com', MD5('123456'), 'customer', 1);

INSERT INTO airlines (name, code, country) VALUES
('Andes Airlines', 'AND', 'Argentina'),
('Pampa Fly', 'PAM', 'Argentina');

INSERT INTO flights (airline_id, origin, destination, departure_time, arrival_time, price, total_seats, available_seats) VALUES
(1, 'Rosario', 'Cordoba', '2026-06-15 09:00:00', '2026-06-15 10:00:00', 92000, 100, 100),
(1, 'Cordoba', 'Mendoza', '2026-06-20 14:00:00', '2026-06-20 15:15:00', 76000, 80, 80),
(2, 'Buenos Aires', 'Bariloche', '2026-07-02 08:30:00', '2026-07-02 10:45:00', 128000, 140, 140),
(2, 'Neuquen', 'Salta', '2026-07-12 13:10:00', '2026-07-12 15:40:00', 99000, 110, 110);

INSERT INTO promotions (airline_id, title, description, discount_percent, status, is_active) VALUES
(1, 'Promo Otono', '15% de descuento en rutas nacionales.', 15, 'approved', 1),
(2, 'Promo Invierno', '10% de descuento para vuelos a la Patagonia.', 10, 'pending', 1);

INSERT INTO news (title, content) VALUES
('Nueva ruta Rosario - Cordoba', 'Se agregan 4 frecuencias semanales para mejorar conectividad regional.'),
('Check-in digital 48hs antes', 'Ahora podes realizar check-in online desde cualquier dispositivo.');
