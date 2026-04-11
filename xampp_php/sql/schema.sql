DROP DATABASE IF EXISTS airarg_db;
CREATE DATABASE airarg_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE airarg_db;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  phone VARCHAR(20) NULL,
  document_number VARCHAR(20) NULL,
  birthdate DATE NULL,
  password_hash VARCHAR(32) NOT NULL,
  role ENUM('admin', 'ceo', 'customer') NOT NULL DEFAULT 'customer',
  email_verified TINYINT(1) NOT NULL DEFAULT 0,
  last_login_at DATETIME NULL,
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
  CONSTRAINT fk_flights_airline FOREIGN KEY (airline_id) REFERENCES airlines(id),
  INDEX idx_flights_route_date (origin, destination, departure_time),
  INDEX idx_flights_price (price),
  INDEX idx_flights_available (available_seats)
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
  CONSTRAINT fk_res_flight FOREIGN KEY (flight_id) REFERENCES flights(id),
  INDEX idx_res_user_created (user_id, created_at),
  INDEX idx_res_status (status)
);

CREATE TABLE reservation_status_history (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reservation_id INT NOT NULL,
  from_status ENUM('pending', 'confirmed', 'cancelled') NULL,
  to_status ENUM('pending', 'confirmed', 'cancelled') NOT NULL,
  changed_by_user_id INT NULL,
  note VARCHAR(255) NULL,
  changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_rsh_reservation FOREIGN KEY (reservation_id) REFERENCES reservations(id),
  CONSTRAINT fk_rsh_user FOREIGN KEY (changed_by_user_id) REFERENCES users(id),
  INDEX idx_rsh_res_changed (reservation_id, changed_at)
);

CREATE TABLE user_favorites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  flight_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_fav_user FOREIGN KEY (user_id) REFERENCES users(id),
  CONSTRAINT fk_fav_flight FOREIGN KEY (flight_id) REFERENCES flights(id),
  CONSTRAINT uq_user_favorite UNIQUE (user_id, flight_id),
  INDEX idx_fav_user_created (user_id, created_at)
);

-- Si la base ya existe, usar ALTER para sumar mejoras sin reinstalar todo:
-- ALTER TABLE users ADD COLUMN phone VARCHAR(20) NULL, ADD COLUMN document_number VARCHAR(20) NULL, ADD COLUMN birthdate DATE NULL, ADD COLUMN last_login_at DATETIME NULL;
-- ALTER TABLE flights ADD INDEX idx_flights_route_date (origin, destination, departure_time), ADD INDEX idx_flights_price (price), ADD INDEX idx_flights_available (available_seats);
-- ALTER TABLE reservations ADD INDEX idx_res_user_created (user_id, created_at), ADD INDEX idx_res_status (status);
-- CREATE TABLE reservation_status_history (...);
-- CREATE TABLE user_favorites (...);

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
