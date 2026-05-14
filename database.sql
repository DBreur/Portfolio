CREATE DATABASE IF NOT EXISTS portfolio
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE portfolio;

DROP TABLE IF EXISTS projects;
DROP TABLE IF EXISTS skills;
DROP TABLE IF EXISTS admins;

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    sort_order INT NOT NULL DEFAULT 0
);

CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    project_url VARCHAR(255) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    image_alt VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0
);

INSERT INTO admins (username, password_hash)
VALUES ('admin', '$2y$12$jvo5L6KGgthtnrVdfZskzeMarEfSJeqr8XGwCl7/tFdyAcgOT7lFm');

INSERT INTO skills (title, description, sort_order) VALUES
('Web development', 'HTML, CSS, JavaScript', 10),
('Design / UX', 'Figma', 20),
('Backend / databases', 'PHP, MySQL', 30),
('Performance & SEO', 'Responsive design', 40),
('Soft skills / persoonlijke vaardigheden', 'Probleemoplossend vermogen, Zelfstandig', 50),
('Tools en versiebeheer', 'Git, Github, VS Code', 60);

INSERT INTO projects (title, project_url, image_path, image_alt, sort_order) VALUES
('Ouderavond', 'https://github.com/DBreur/Project/tree/main/Ouderavond', 'img/Ouderavond.png', 'Afbeelding van mijn ouderavond project', 10),
('Bank van de Toekomst', 'https://github.com/DBreur/Project/tree/main/Bank%20van%20de%20Toekomst', 'img/BvdT.png', 'Mijn bank applicatie project', 20);
