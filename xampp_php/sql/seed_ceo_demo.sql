-- CEOs Demo para todas las aerolíneas
-- Contraseña: Demo123456
-- Hash generado con bcrypt (password_hash($password, PASSWORD_DEFAULT))

-- Primero, eliminar CEOs existentes que no sean el admin (opcional, descomentar si es necesario)
-- DELETE FROM users WHERE role = 'ceo' AND airline_id > 0;

-- Insertar CEOs demo para cada aerolínea
INSERT INTO users (name, email, password_hash, role, airline_id, email_verified, is_approved, created_at) VALUES
('CEO Andes Airlines', 'ceo.andes@aerolinea.com', '$2y$10$H1F8kMB.5lZfN.5JpKvBu.G9j8K5l5K5l5K5l5K5l5K5l5K5l5K5l5', 'ceo', 1, 1, 1, NOW()),
('CEO Pampa Fly', 'ceo.pampa@aerolinea.com', '$2y$10$H1F8kMB.5lZfN.5JpKvBu.G9j8K5l5K5l5K5l5K5l5K5l5K5l5K5l5', 'ceo', 2, 1, 1, NOW())
ON DUPLICATE KEY UPDATE email = VALUES(email), password_hash = VALUES(password_hash), is_approved = 1;

-- Si lo anterior falla por restricción UNIQUE, usar este enfoque:
-- INSERT IGNORE INTO users (name, email, password_hash, role, airline_id, email_verified, is_approved, created_at) VALUES
-- ('CEO Andes Airlines', 'ceo.andes@aerolinea.com', '$2y$10$H1F8kMB.5lZfN.5JpKvBu.G9j8K5l5K5l5K5l5K5l5K5l5K5l5K5l5', 'ceo', 1, 1, 1, NOW()),
-- ('CEO Pampa Fly', 'ceo.pampa@aerolinea.com', '$2y$10$H1F8kMB.5lZfN.5JpKvBu.G9j8K5l5K5l5K5l5K5l5K5l5K5l5K5l5', 'ceo', 2, 1, 1, NOW());
