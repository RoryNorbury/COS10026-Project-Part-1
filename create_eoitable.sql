-- drop the table if it already exists (optional, for re runs and testing)
-- uncomment the line below if dropping an existing eoi table first
-- DROP TABLE IF EXISTS eoi;

-- create the EOI table
CREATE TABLE IF NOT EXISTS eoi (
    EOInumber INT AUTO_INCREMENT PRIMARY KEY,
    JobReferenceNumber VARCHAR(5) NOT NULL,
    FirstName VARCHAR(20) NOT NULL,
    LastName VARCHAR(20) NOT NULL,
    DateOfBirth VARCHAR(10) NOT NULL, -- storing as VARCHAR as per dd/mm/yyyy format
    Gender VARCHAR(20) NOT NULL,
    StreetAddress VARCHAR(40) NOT NULL,
    SuburbTown VARCHAR(40) NOT NULL,
    State VARCHAR(3) NOT NULL,
    Postcode VARCHAR(4) NOT NULL,
    EmailAddress VARCHAR(255) NOT NULL,
    PhoneNumber VARCHAR(12) NOT NULL,
    Skill1 BOOLEAN DEFAULT FALSE,       -- true if 'Basic Networking Understanding' is checked
    Skill2 BOOLEAN DEFAULT FALSE,       -- true if 'Awareness of Privacy Protocols' is checked
    Skill3 BOOLEAN DEFAULT FALSE,       -- true if 'Cloud Platforms Familiarity' is checked
    OtherSkills TEXT,                   -- for other skills description
    Status ENUM('New', 'Current', 'Final') DEFAULT 'New', -- application status
    ApplicationTimestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- when the application was submitted
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
