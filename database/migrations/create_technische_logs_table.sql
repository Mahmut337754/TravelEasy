-- Technische Logs Tabel
-- Voor het bijhouden van alle systeemacties en errors

CREATE TABLE IF NOT EXISTS technische_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    level VARCHAR(20) NOT NULL,
    message TEXT NOT NULL,
    context JSON,
    gebruikerId INT NULL,
    ipAdres VARCHAR(45),
    userAgent VARCHAR(255),
    url VARCHAR(255),
    datumAangemaakt DATETIME NOT NULL,
    
    INDEX idx_level (level),
    INDEX idx_gebruiker (gebruikerId),
    INDEX idx_datum (datumAangemaakt),
    
    FOREIGN KEY (gebruikerId) REFERENCES gebruikers(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
