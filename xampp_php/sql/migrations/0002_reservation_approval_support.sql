-- Migracion 0002: soporte para aprobacion/denegacion de reservas
-- Esta migracion permite que las reservas se queden pendientes, se confirmen o se denieguen.

USE airarg_db;

ALTER TABLE reservations
  ADD COLUMN IF NOT EXISTS status ENUM('pending', 'confirmed', 'cancelled', 'denied') NOT NULL DEFAULT 'pending';

CREATE TABLE IF NOT EXISTS reservation_status_history (
  id INT AUTO_INCREMENT PRIMARY KEY,
  reservation_id INT NOT NULL,
  from_status ENUM('pending', 'confirmed', 'cancelled', 'denied') NULL,
  to_status ENUM('pending', 'confirmed', 'cancelled', 'denied') NOT NULL,
  changed_by_user_id INT NULL,
  note VARCHAR(255) NULL,
  changed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_rsh_reservation FOREIGN KEY (reservation_id) REFERENCES reservations(id),
  CONSTRAINT fk_rsh_user FOREIGN KEY (changed_by_user_id) REFERENCES users(id),
  INDEX idx_rsh_res_changed (reservation_id, changed_at)
);

ALTER TABLE reservations
  ADD INDEX IF NOT EXISTS idx_res_status (status);
