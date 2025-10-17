#!/bin/bash
# Direct MySQL fix for matches table

echo "Fixing matches table..."
echo ""

docker exec spor_kulubu_db mysql -u root -proot spor_kulubu <<EOF
-- Show current structure
SELECT '=== Current Structure ===' AS '';
DESCRIBE matches;

-- Add missing columns
SELECT '=== Adding Columns ===' AS '';

ALTER TABLE matches ADD COLUMN competition VARCHAR(100) NULL;
SELECT 'Added: competition' AS '';

ALTER TABLE matches ADD COLUMN season VARCHAR(20) NULL;
SELECT 'Added: season' AS '';

ALTER TABLE matches ADD COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;
SELECT 'Added: created_at' AS '';

ALTER TABLE matches ADD COLUMN updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;
SELECT 'Added: updated_at' AS '';

-- Show final structure
SELECT '=== Final Structure ===' AS '';
DESCRIBE matches;

SELECT '=== Fix Complete ===' AS '';
EOF

echo ""
echo "✓ Database fix completed!"
echo "Try creating a match now at: http://localhost:8090/admin/matches/create"
