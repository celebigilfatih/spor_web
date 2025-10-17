#!/bin/bash
# Quick fix for matches table - Add missing columns

echo "Adding missing columns to matches table..."

docker exec -i spor_kulubu_db mysql -u root -proot spor_kulubu << 'EOF'

-- Add competition column
ALTER TABLE matches 
ADD COLUMN competition VARCHAR(100) NULL 
COMMENT 'Competition type (Liga, Kupa, etc.)';

-- Add season column
ALTER TABLE matches 
ADD COLUMN season VARCHAR(20) NULL 
COMMENT 'Season (e.g., 2024-2025)';

-- Add created_at column
ALTER TABLE matches 
ADD COLUMN created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP;

-- Add updated_at column
ALTER TABLE matches 
ADD COLUMN updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;

-- Verify the changes
DESCRIBE matches;

SELECT 'Columns added successfully!' AS result;
EOF

echo ""
echo "✅ Done! Try creating a match now at http://localhost:8090/admin/matches/create"
