-- Add CEO approval system
ALTER TABLE users ADD COLUMN is_approved TINYINT(1) DEFAULT 1;
-- CEOs created by non-admins will have is_approved = 0
-- CEOs created by admins will have is_approved = 1
CREATE INDEX idx_users_role_approved ON users(role, is_approved);
