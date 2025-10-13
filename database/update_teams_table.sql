-- Database Update for Teams Table
-- Add coach_name field if it doesn't exist

-- Check if coach_name column exists, if not add it
SET @sql = (SELECT IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS 
     WHERE table_schema = DATABASE() 
     AND table_name = 'teams' 
     AND column_name = 'coach_name') = 0,
    'ALTER TABLE teams ADD COLUMN coach_name VARCHAR(100) DEFAULT NULL AFTER coach_id',
    'SELECT "Column coach_name already exists" as message'
));

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Also add sort_order field if it doesn't exist (for team ordering)
SET @sql2 = (SELECT IF(
    (SELECT COUNT(*) FROM information_schema.COLUMNS 
     WHERE table_schema = DATABASE() 
     AND table_name = 'teams' 
     AND column_name = 'sort_order') = 0,
    'ALTER TABLE teams ADD COLUMN sort_order INT(11) DEFAULT 0 AFTER status',
    'SELECT "Column sort_order already exists" as message'
));

PREPARE stmt2 FROM @sql2;
EXECUTE stmt2;
DEALLOCATE PREPARE stmt2;

-- Update existing teams to have sort_order values
UPDATE teams SET sort_order = id WHERE sort_order = 0 OR sort_order IS NULL;