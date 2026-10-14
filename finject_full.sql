-- =====================================
-- MASTER DATABASE INITIALIZATION: exploiti_finject
-- Version: 2.0 (Full Business Scale)
-- =====================================

CREATE DATABASE IF NOT EXISTS exploiti_finject;
USE exploiti_finject;

-- -------------------------------------
-- 1. USERS & IDENTITY SYSTEM
-- -------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    full_name VARCHAR(255) DEFAULT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    whatsapp_number VARCHAR(20) DEFAULT NULL,
    phone_number VARCHAR(20) DEFAULT NULL,
    personal_email VARCHAR(255) DEFAULT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'lead_hunter', 'client_handler', 'executioner') DEFAULT 'lead_hunter',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------
-- 2. FINANCIAL & DISTRIBUTION CONFIG
-- -------------------------------------
CREATE TABLE IF NOT EXISTS distribution_settings (
    id INT PRIMARY KEY DEFAULT 1,
    startup_pct DECIMAL(5,2) DEFAULT 30.00,
    member_pct DECIMAL(5,2) DEFAULT 20.00,
    execution_pct DECIMAL(5,2) DEFAULT 50.00,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS income (
    id INT AUTO_INCREMENT PRIMARY KEY,
    amount DECIMAL(15,2) NOT NULL,
    source VARCHAR(255) NOT NULL,
    user_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    income_id INT NOT NULL,
    startup_amount DECIMAL(15,2) NOT NULL,
    member_amount DECIMAL(15,2) NOT NULL,
    execution_amount DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (income_id) REFERENCES income(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------
-- 3. INTELLIGENCE & ACADEMY
-- -------------------------------------
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    type VARCHAR(50) DEFAULT 'info',
    link VARCHAR(255) DEFAULT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tutorials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    media_type ENUM('video', 'audio', 'text') DEFAULT 'text',
    media_url TEXT,
    content_text LONGTEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tools (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) UNIQUE NOT NULL,
    icon VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------
-- 4. MARKET DATA & SUPPORT
-- -------------------------------------
CREATE TABLE IF NOT EXISTS clients_data_buttons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(255) NOT NULL,
    url TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS support_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    message TEXT NOT NULL,
    status ENUM('pending', 'resolved', 'rejected') DEFAULT 'pending',
    admin_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- -------------------------------------
-- 5. PERFORMANCE INDICES
-- -------------------------------------
CREATE INDEX idx_notif_user_read ON notifications(user_id, is_read);
CREATE INDEX idx_income_created_at ON income(created_at);
CREATE INDEX idx_income_user_id ON income(user_id);
CREATE INDEX idx_support_status ON support_requests(status);

-- -------------------------------------
-- 6. MASTER SEED DATA
-- -------------------------------------

-- Default Distribution Settings
INSERT IGNORE INTO distribution_settings (id, startup_pct, member_pct, execution_pct) 
VALUES (1, 30.00, 20.00, 50.00);

-- Master Administrator
INSERT IGNORE INTO users (name, full_name, email, password, role) 
VALUES ('Admin', 'Master Administrator', 'admin@exploitinject.dev', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Initial Arsenal Toolkit
INSERT IGNORE INTO tools (name, icon, description) VALUES 
('Google Maps', 'map-pin', 'Lead generation and market research'),
('Microsoft Excel/Google Sheet', 'file-spreadsheet', 'Data organization and lead tracking'),
('WhatsApp & WhatsApp Business', 'message-circle', 'Direct client communication and closing'),
('Phone Calls', 'phone', 'High-touch outreach for warm leads'),
('Emails', 'mail', 'Professional formal communication'),
('ChatGPT', 'bot', 'AI-powered content and logic generation'),
('Claude Ai', 'cpu', 'Advanced coding and strategy assistant'),
('Gemini', 'sparkles', 'Google’s multimodal intelligence'),
('Grok', 'brain', 'Real-time intelligence and insight'),
('Antigravity', 'zap', 'Ultimate agentic coding partner'),
('Lovable', 'heart', 'Rapid UI prototyping and design'),
('Hostinger', 'server', 'All-in-one hosting and AI builder'),
('OBS', 'video', 'Professional screen and video recording'),
('GitHub', 'github', 'Version control and collaboration'),
('Vercel', 'triangle', 'Instant frontend deployment'),
('Netlify', 'cloud', 'Cloud hosting and automation');
