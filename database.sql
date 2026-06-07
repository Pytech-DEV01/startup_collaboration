-- ============================================================
-- Startup Collaboration Portal - Complete Database Schema
-- Database: startup_portal
-- Engine: InnoDB (all tables)
-- Context: Indian Startup Ecosystem
-- ============================================================

CREATE DATABASE IF NOT EXISTS `startup_portal`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `startup_portal`;

-- ============================================================
-- DROP TABLES (reverse dependency order to avoid FK errors)
-- ============================================================

DROP TABLE IF EXISTS `mentorships`;
DROP TABLE IF EXISTS `collaborations`;
DROP TABLE IF EXISTS `applications`;
DROP TABLE IF EXISTS `event_organizers`;
DROP TABLE IF EXISTS `event_registrations`;
DROP TABLE IF EXISTS `events`;
DROP TABLE IF EXISTS `event_types`;
DROP TABLE IF EXISTS `startup_investors`;
DROP TABLE IF EXISTS `startup_founders`;
DROP TABLE IF EXISTS `startups`;
DROP TABLE IF EXISTS `organizations`;
DROP TABLE IF EXISTS `startup_types`;
DROP TABLE IF EXISTS `user_roles`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `roles`;

-- ============================================================
-- 1. ROLES - Base lookup table (no FK dependencies)
-- ============================================================

CREATE TABLE `roles` (
  `role_id` INT AUTO_INCREMENT PRIMARY KEY,
  `role_name` VARCHAR(50) NOT NULL UNIQUE,
  `description` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `roles` (`role_name`, `description`) VALUES
('admin',     'System administrator with full access'),
('founder',   'Startup founder or co-founder'),
('investor',  'Angel investor or venture capitalist'),
('applicant', 'User applying to join or collaborate with startups'),
('mentor',    'Industry mentor providing guidance to startups'),
('student',   'Student exploring or participating in the ecosystem');

-- ============================================================
-- 2. USERS - Core user table (no FK dependencies)
-- ============================================================

CREATE TABLE `users` (
  `user_id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL UNIQUE,
  `phone` VARCHAR(20),
  `bio` TEXT,
  `user_type` ENUM('student','founder','investor','mentor') NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`full_name`, `email`, `phone`, `bio`, `user_type`) VALUES
('Arjun Mehta',     'arjun.mehta@novapay.in',      '+91-9876543210', 'Serial entrepreneur with 8+ years in FinTech. Previously built a UPI-based payment gateway.', 'founder'),
('Priya Sharma',    'priya.sharma@venturehub.in',   '+91-9123456789', 'Angel investor focused on early-stage Indian startups. Portfolio of 20+ companies across FinTech and HealthTech.', 'investor'),
('Rahul Verma',     'rahul.verma@mentornet.in',     '+91-9988776655', 'Ex-CTO of a unicorn startup. Mentors young founders on scaling tech teams and product-market fit.', 'mentor'),
('Sneha Iyer',      'sneha.iyer@mediscan.ai',       '+91-9876012345', 'AI researcher turned founder. Building next-gen diagnostic tools using deep learning.', 'founder'),
('Vikram Patel',    'vikram.patel@greenvolt.co.in',  '+91-9012345678', 'Cleantech advocate and founder. Working on affordable solar micro-grids for rural India.', 'founder'),
('Ananya Reddy',    'ananya.reddy@iitkgp.ac.in',    '+91-8765432109', 'Final-year CS student at IIT Kharagpur. Passionate about AI/ML and social impact startups.', 'student'),
('Deepak Gupta',    'deepak.gupta@capitalwave.in',   '+91-9567890123', 'Managing Partner at CapitalWave Ventures. Focuses on Series A investments in B2B SaaS and EdTech.', 'investor'),
('Kavitha Nair',    'kavitha.nair@edubridge.in',     '+91-9345678901', 'EdTech founder focused on vernacular language learning platforms for Tier-2 and Tier-3 cities.', 'founder');

-- ============================================================
-- 3. USER_ROLES - Junction table linking users to roles
-- ============================================================

CREATE TABLE `user_roles` (
  `user_id` INT NOT NULL,
  `role_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `role_id`),
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (`role_id`) REFERENCES `roles`(`role_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Arjun (founder), Priya (investor), Rahul (mentor),
-- Sneha (founder), Vikram (founder), Ananya (student + applicant),
-- Deepak (investor), Kavitha (founder)
INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 2),  -- Arjun  -> founder
(2, 3),  -- Priya  -> investor
(3, 5),  -- Rahul  -> mentor
(4, 2),  -- Sneha  -> founder
(5, 2),  -- Vikram -> founder
(6, 6),  -- Ananya -> student
(6, 4),  -- Ananya -> applicant (student applying to startups)
(7, 3),  -- Deepak -> investor
(8, 2);  -- Kavitha -> founder

-- ============================================================
-- 4. STARTUP_TYPES - Lookup table for startup categories
-- ============================================================

CREATE TABLE `startup_types` (
  `type_id` INT AUTO_INCREMENT PRIMARY KEY,
  `type_name` VARCHAR(50) NOT NULL UNIQUE,
  `description` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `startup_types` (`type_name`, `description`) VALUES
('Tech',      'General technology startups including SaaS, DevTools, and platforms'),
('FinTech',   'Financial technology - payments, lending, insurance, and banking solutions'),
('HealthTech','Healthcare technology - diagnostics, telemedicine, and medical devices'),
('EdTech',    'Education technology - e-learning, skill development, and assessment platforms'),
('AgriTech',  'Agriculture technology - farm management, supply chain, and precision farming'),
('CleanTech', 'Clean energy and sustainability - solar, EV, waste management, and green solutions');

-- ============================================================
-- 5. ORGANIZATIONS - Universities, incubators, accelerators
-- ============================================================

CREATE TABLE `organizations` (
  `org_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `org_type` ENUM('university','incubator','accelerator','corporate') NOT NULL,
  `location` VARCHAR(200),
  `website` VARCHAR(255),
  `description` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `organizations` (`name`, `org_type`, `location`, `website`, `description`) VALUES
('IIT Delhi Innovation & Incubation Centre', 'incubator',   'Hauz Khas, New Delhi',       'https://iitd.ac.in/incubation',      'Premier incubation centre at IIT Delhi supporting deep-tech and hardware startups.'),
('T-Hub Hyderabad',                          'accelerator', 'Raidurg, Hyderabad',          'https://t-hub.co',                    'India''s largest incubator & accelerator, fostering innovation and entrepreneurship in Telangana.'),
('NASSCOM 10,000 Startups',                  'corporate',   'Bengaluru, Karnataka',        'https://nasscom.in/10000startups',    'NASSCOM initiative to incubate, fund, and support 10,000 startups across India.'),
('IIM Bangalore NSRCEL',                     'incubator',   'Bannerghatta Road, Bengaluru','https://nsrcel.org',                  'IIM Bangalore''s entrepreneurship centre providing incubation, acceleration, and launchpad programs.'),
('Atal Incubation Centre - BIMTECH',         'incubator',   'Greater Noida, UP',           'https://aic-bimtech.org',             'Government-backed Atal Incubation Centre at BIMTECH supporting early-stage startups.'),
('Startup India Hub',                        'corporate',   'New Delhi',                   'https://startupindia.gov.in',         'Government of India flagship initiative providing mentorship, funding, and policy support.');

-- ============================================================
-- 6. STARTUPS - Core startup entity
-- ============================================================

CREATE TABLE `startups` (
  `startup_id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(150) NOT NULL,
  `type_id` INT,
  `description` TEXT,
  `funding_stage` ENUM('Pre-Seed','Seed','Series A','Series B','Series C+') DEFAULT 'Pre-Seed',
  `website` VARCHAR(255),
  `founded_year` YEAR,
  `org_id` INT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`type_id`) REFERENCES `startup_types`(`type_id`) ON DELETE SET NULL,
  FOREIGN KEY (`org_id`) REFERENCES `organizations`(`org_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `startups` (`name`, `type_id`, `description`, `funding_stage`, `website`, `founded_year`, `org_id`) VALUES
('NovaPay',       2, 'AI-powered UPI payment analytics platform helping merchants optimize transaction flows and reduce fraud.', 'Seed',     'https://novapay.in',       2024, 2),
('MediScan AI',   3, 'Deep learning diagnostic platform that analyses X-rays and CT scans to detect anomalies with 97% accuracy.', 'Series A', 'https://mediscan.ai',      2023, 1),
('AgriConnect',   5, 'Farm-to-fork supply chain platform connecting small-hold farmers directly to retailers and restaurants.', 'Pre-Seed', 'https://agriconnect.co.in',2025, 5),
('EduBridge',     4, 'Vernacular language learning platform offering courses in 12 Indian languages for Tier-2/3 city learners.', 'Seed',     'https://edubridge.in',     2024, 4),
('GreenVolt',     6, 'Affordable solar micro-grid solutions for rural electrification with IoT-based monitoring dashboards.', 'Series A', 'https://greenvolt.co.in',  2022, 3),
('CodeCraft',     1, 'Cloud-based collaborative IDE and DevOps platform tailored for student developers and hackathon teams.', 'Pre-Seed', 'https://codecraft.dev',    2025, 6);

-- ============================================================
-- 7. STARTUP_FOUNDERS - Links founders to their startups
-- ============================================================

CREATE TABLE `startup_founders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `startup_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `role_title` VARCHAR(100),
  FOREIGN KEY (`startup_id`) REFERENCES `startups`(`startup_id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Meaningful linkages: each founder to their actual startup
INSERT INTO `startup_founders` (`startup_id`, `user_id`, `role_title`) VALUES
(1, 1, 'CEO & Co-Founder'),         -- Arjun Mehta  -> NovaPay
(2, 4, 'CEO & Founder'),            -- Sneha Iyer   -> MediScan AI
(3, 1, 'Co-Founder & Advisor'),     -- Arjun Mehta  -> AgriConnect (serial entrepreneur)
(4, 8, 'Founder & CEO'),            -- Kavitha Nair -> EduBridge
(5, 5, 'Founder & CTO'),            -- Vikram Patel -> GreenVolt
(6, 6, 'Co-Founder (Student Lead)');-- Ananya Reddy -> CodeCraft

-- ============================================================
-- 8. STARTUP_INVESTORS - Tracks investments in startups
-- ============================================================

CREATE TABLE `startup_investors` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `startup_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `investment_amount` DECIMAL(15,2),
  `investment_date` DATE,
  FOREIGN KEY (`startup_id`) REFERENCES `startups`(`startup_id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Priya (user 2) and Deepak (user 7) are investors
INSERT INTO `startup_investors` (`startup_id`, `user_id`, `investment_amount`, `investment_date`) VALUES
(1, 2, 5000000.00,  '2025-03-15'),  -- Priya invested ₹50 Lakhs in NovaPay
(2, 2, 15000000.00, '2024-11-01'),  -- Priya invested ₹1.5 Crore in MediScan AI
(4, 7, 3000000.00,  '2025-06-20'),  -- Deepak invested ₹30 Lakhs in EduBridge
(5, 7, 20000000.00, '2025-01-10'),  -- Deepak invested ₹2 Crore in GreenVolt
(1, 7, 7500000.00,  '2025-08-05'),  -- Deepak also invested ₹75 Lakhs in NovaPay
(2, 7, 10000000.00, '2025-02-28');  -- Deepak invested ₹1 Crore in MediScan AI

-- ============================================================
-- 9. EVENT_TYPES - Lookup table for event categories
-- ============================================================

CREATE TABLE `event_types` (
  `event_type_id` INT AUTO_INCREMENT PRIMARY KEY,
  `type_name` VARCHAR(50) NOT NULL UNIQUE,
  `description` VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `event_types` (`type_name`, `description`) VALUES
('Hackathon',   'Intensive coding and building competition spanning 24-48 hours'),
('Pitch Day',   'Startups pitch their ideas to a panel of investors and mentors'),
('Workshop',    'Hands-on learning session on a specific skill or technology'),
('Seminar',     'Expert-led talk or panel discussion on industry trends'),
('Demo Day',    'Startups showcase their products to investors and the public'),
('Networking',  'Informal networking event for founders, investors, and mentors');

-- ============================================================
-- 10. EVENTS - Scheduled events in the ecosystem
-- ============================================================

CREATE TABLE `events` (
  `event_id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(200) NOT NULL,
  `event_type_id` INT,
  `description` TEXT,
  `event_date` DATETIME NOT NULL,
  `location` VARCHAR(200),
  `max_participants` INT DEFAULT 100,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`event_type_id`) REFERENCES `event_types`(`event_type_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `events` (`title`, `event_type_id`, `description`, `event_date`, `location`, `max_participants`) VALUES
('Startup India Pitch Day 2026',   2, 'Annual pitch competition where top 20 startups present to a panel of leading VCs and angel investors.',           '2026-07-15 10:00:00', 'Pragati Maidan, New Delhi',      200),
('FinTech Hackathon 2026',         1, '48-hour hackathon focused on building innovative payment solutions, lending tools, and RegTech applications.',     '2026-08-22 09:00:00', 'T-Hub, Hyderabad',               150),
('AI & ML Workshop',               3, 'Hands-on workshop covering TensorFlow, PyTorch, and real-world ML model deployment for startup engineers.',       '2026-07-05 14:00:00', 'IIT Delhi Campus, New Delhi',     80),
('CleanTech Demo Day',             5, 'GreenVolt, SolarGrid, and 8 other CleanTech startups showcase their products to impact investors.',                '2026-09-10 11:00:00', 'NSRCEL, IIM Bangalore',          120),
('Founders & Funders Networking',  6, 'An evening of curated networking between early-stage founders and active angel investors in the Bangalore ecosystem.', '2026-08-01 18:00:00', 'WeWork Galaxy, Bengaluru',       100),
('EdTech Seminar: Future of Learning', 4, 'Panel discussion featuring EdTech leaders on AI tutors, vernacular content, and gamification in education.',   '2026-07-28 10:30:00', 'BIMTECH Auditorium, Greater Noida', 90);

-- ============================================================
-- 11. EVENT_REGISTRATIONS - Users registered for events
-- ============================================================

CREATE TABLE `event_registrations` (
  `reg_id` INT AUTO_INCREMENT PRIMARY KEY,
  `event_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `registered_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `status` ENUM('registered','attended','cancelled') DEFAULT 'registered',
  FOREIGN KEY (`event_id`) REFERENCES `events`(`event_id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `event_registrations` (`event_id`, `user_id`, `status`) VALUES
(1, 1, 'registered'),  -- Arjun registered for Startup India Pitch Day
(1, 4, 'registered'),  -- Sneha registered for Startup India Pitch Day
(2, 1, 'registered'),  -- Arjun registered for FinTech Hackathon
(2, 6, 'registered'),  -- Ananya registered for FinTech Hackathon
(3, 6, 'registered'),  -- Ananya registered for AI & ML Workshop
(3, 4, 'registered'),  -- Sneha registered for AI & ML Workshop
(4, 5, 'registered'),  -- Vikram registered for CleanTech Demo Day
(5, 2, 'registered'),  -- Priya registered for Founders & Funders Networking
(5, 7, 'registered'),  -- Deepak registered for Founders & Funders Networking
(6, 8, 'registered');  -- Kavitha registered for EdTech Seminar

-- ============================================================
-- 12. EVENT_ORGANIZERS - Organizations hosting/sponsoring events
-- ============================================================

CREATE TABLE `event_organizers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `event_id` INT NOT NULL,
  `org_id` INT NOT NULL,
  FOREIGN KEY (`event_id`) REFERENCES `events`(`event_id`) ON DELETE CASCADE,
  FOREIGN KEY (`org_id`) REFERENCES `organizations`(`org_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `event_organizers` (`event_id`, `org_id`) VALUES
(1, 6),  -- Startup India Pitch Day organized by Startup India Hub
(2, 2),  -- FinTech Hackathon organized by T-Hub Hyderabad
(3, 1),  -- AI & ML Workshop organized by IIT Delhi Innovation Centre
(4, 4),  -- CleanTech Demo Day organized by IIM Bangalore NSRCEL
(5, 3),  -- Founders & Funders Networking organized by NASSCOM
(6, 5);  -- EdTech Seminar organized by Atal Incubation Centre BIMTECH

-- ============================================================
-- 13. APPLICATIONS - Users applying to join/invest/collaborate
-- ============================================================

CREATE TABLE `applications` (
  `app_id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `startup_id` INT NOT NULL,
  `app_type` ENUM('join','invest','collaborate') NOT NULL,
  `message` TEXT,
  `status` ENUM('pending','approved','rejected') DEFAULT 'pending',
  `applied_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (`startup_id`) REFERENCES `startups`(`startup_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `applications` (`user_id`, `startup_id`, `app_type`, `message`, `status`) VALUES
(6, 1, 'join',        'I am a final-year CS student at IIT KGP with strong Python and ML skills. I would love to intern at NovaPay on the fraud detection module.', 'approved'),
(6, 2, 'join',        'Passionate about AI in healthcare. I have published a paper on CNN-based image classification and would love to contribute to MediScan AI.', 'pending'),
(2, 3, 'invest',      'AgriConnect aligns with my thesis on rural fintech. I am interested in leading a pre-seed round of ₹25 Lakhs.', 'pending'),
(7, 6, 'invest',      'CodeCraft has potential in the developer tools space. Interested in exploring a seed investment.', 'pending'),
(3, 4, 'collaborate', 'I can mentor the EduBridge team on scaling their platform architecture and setting up CI/CD pipelines.', 'approved'),
(8, 5, 'collaborate', 'EduBridge and GreenVolt can co-create sustainability education modules for rural schools. Let us explore synergies.', 'pending');

-- ============================================================
-- 14. COLLABORATIONS - Partnerships between startups
-- ============================================================

CREATE TABLE `collaborations` (
  `collab_id` INT AUTO_INCREMENT PRIMARY KEY,
  `startup_id_1` INT NOT NULL,
  `startup_id_2` INT NOT NULL,
  `collab_type` VARCHAR(100),
  `status` ENUM('active','completed','terminated') DEFAULT 'active',
  `start_date` DATE,
  FOREIGN KEY (`startup_id_1`) REFERENCES `startups`(`startup_id`) ON DELETE CASCADE,
  FOREIGN KEY (`startup_id_2`) REFERENCES `startups`(`startup_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `collaborations` (`startup_id_1`, `startup_id_2`, `collab_type`, `status`, `start_date`) VALUES
(1, 3, 'Payment Integration',          'active',    '2025-09-01'),  -- NovaPay provides payments for AgriConnect
(2, 5, 'IoT Health Monitoring',        'active',    '2025-07-15'),  -- MediScan AI + GreenVolt on rural health+energy kiosks
(4, 6, 'Student Learning Platform',    'active',    '2025-11-01'),  -- EduBridge + CodeCraft: coding courses in vernacular
(1, 4, 'Digital Payments for EdTech',  'completed', '2025-03-01'),  -- NovaPay + EduBridge: payment gateway integration
(3, 5, 'Solar-Powered Cold Storage',   'active',    '2026-01-10'),  -- AgriConnect + GreenVolt: solar cold storage for farms
(2, 4, 'Health Education Content',     'active',    '2026-02-20');  -- MediScan AI + EduBridge: health literacy modules

-- ============================================================
-- 15. MENTORSHIPS - Mentor-mentee relationships
-- ============================================================

CREATE TABLE `mentorships` (
  `mentorship_id` INT AUTO_INCREMENT PRIMARY KEY,
  `mentor_id` INT NOT NULL,
  `mentee_id` INT NOT NULL,
  `focus_area` VARCHAR(100),
  `status` ENUM('active','completed') DEFAULT 'active',
  `start_date` DATE,
  FOREIGN KEY (`mentor_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (`mentee_id`) REFERENCES `users`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Rahul Verma (user 3) is the mentor
INSERT INTO `mentorships` (`mentor_id`, `mentee_id`, `focus_area`, `status`, `start_date`) VALUES
(3, 1, 'Scaling Engineering Teams',        'active',    '2025-04-01'),  -- Rahul mentors Arjun (NovaPay)
(3, 4, 'AI Product Strategy',              'active',    '2025-06-15'),  -- Rahul mentors Sneha (MediScan AI)
(3, 5, 'Hardware-Software Integration',    'completed', '2025-01-10'),  -- Rahul mentored Vikram (GreenVolt)
(3, 8, 'Platform Growth & Retention',      'active',    '2025-09-01'),  -- Rahul mentors Kavitha (EduBridge)
(3, 6, 'Career in Tech Startups',          'active',    '2026-01-15'),  -- Rahul mentors Ananya (student)
(2, 1, 'Fundraising & Investor Relations', 'active',    '2025-11-01');  -- Priya (investor) mentors Arjun on fundraising

-- ============================================================
-- END OF SCHEMA & SAMPLE DATA
-- ============================================================
