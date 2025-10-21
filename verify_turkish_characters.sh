#!/bin/bash

# Turkish Character Verification Script
# This script checks if Turkish characters are properly configured

echo "========================================="
echo "Turkish Character Configuration Checker"
echo "========================================="
echo ""

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check 1: Database Character Set
echo "1. Checking Database Character Set..."
DB_CHARSET=$(docker-compose exec -T database mysql -u root -proot_password -se "SHOW VARIABLES LIKE 'character_set_database';" 2>/dev/null | awk '{print $2}')
DB_COLLATION=$(docker-compose exec -T database mysql -u root -proot_password -se "SHOW VARIABLES LIKE 'collation_database';" 2>/dev/null | awk '{print $2}')

if [ "$DB_CHARSET" == "utf8mb4" ] && [ "$DB_COLLATION" == "utf8mb4_turkish_ci" ]; then
    echo -e "${GREEN}✓ Database charset: $DB_CHARSET${NC}"
    echo -e "${GREEN}✓ Database collation: $DB_COLLATION${NC}"
else
    echo -e "${RED}✗ Database charset or collation incorrect${NC}"
    echo "  Expected: utf8mb4 / utf8mb4_turkish_ci"
    echo "  Found: $DB_CHARSET / $DB_COLLATION"
fi
echo ""

# Check 2: HTML Entities in Database
echo "2. Checking for HTML Entities in Database..."
ENTITY_COUNT=$(docker-compose exec -T database mysql -u root -proot_password spor_kulubu -se "SELECT COUNT(*) FROM site_settings WHERE setting_value LIKE '%&#%' OR setting_value LIKE '%&quot;%' OR setting_value LIKE '%&amp;%';" 2>/dev/null)

if [ "$ENTITY_COUNT" == "0" ]; then
    echo -e "${GREEN}✓ No HTML entities found in site_settings${NC}"
else
    echo -e "${YELLOW}⚠ Found $ENTITY_COUNT records with HTML entities${NC}"
    echo "  Run: docker-compose exec -T database mysql -u root -proot_password spor_kulubu < FIX_TURKISH_CHARACTERS.sql"
fi
echo ""

# Check 3: Sample Turkish Text
echo "3. Testing Turkish Characters in Database..."
SAMPLE_TEXT=$(docker-compose exec -T database mysql -u root -proot_password spor_kulubu -se "SELECT setting_value FROM site_settings WHERE setting_key = 'site_description' LIMIT 1;" 2>/dev/null)

if [[ "$SAMPLE_TEXT" =~ [ğüşöçİĞÜŞÖÇ] ]]; then
    echo -e "${GREEN}✓ Turkish characters stored correctly${NC}"
    echo "  Sample: ${SAMPLE_TEXT:0:50}..."
else
    echo -e "${YELLOW}⚠ No Turkish characters found in test field${NC}"
    echo "  This might be normal if you haven't entered any Turkish text yet"
fi
echo ""

# Check 4: PHP Configuration
echo "4. Checking PHP Configuration..."
PHP_CHARSET=$(docker-compose exec -T web php -r "echo ini_get('default_charset');" 2>/dev/null)

if [ "$PHP_CHARSET" == "UTF-8" ]; then
    echo -e "${GREEN}✓ PHP default charset: $PHP_CHARSET${NC}"
else
    echo -e "${RED}✗ PHP charset incorrect: $PHP_CHARSET${NC}"
    echo "  Expected: UTF-8"
fi
echo ""

# Check 5: Controller sanitizeInput Method
echo "5. Checking Controller.php sanitizeInput method..."
if grep -q "return trim(\$input);" /Users/celebigil/Dev/spor_web/core/Controller.php 2>/dev/null; then
    echo -e "${GREEN}✓ sanitizeInput() correctly configured (no htmlspecialchars)${NC}"
elif grep -q "htmlspecialchars(trim(\$input)" /Users/celebigil/Dev/spor_web/core/Controller.php 2>/dev/null; then
    echo -e "${RED}✗ sanitizeInput() still using htmlspecialchars${NC}"
    echo "  Fix: Remove htmlspecialchars() from sanitizeInput() in core/Controller.php"
else
    echo -e "${YELLOW}⚠ Could not verify sanitizeInput() method${NC}"
fi
echo ""

# Summary
echo "========================================="
echo "Summary"
echo "========================================="
echo ""
echo "Configuration files to check:"
echo "  - /docker/mysql/my.cnf (database charset)"
echo "  - /docker/php/php.ini (PHP charset)"
echo "  - /core/Database.php (PDO connection)"
echo "  - /core/Controller.php (sanitizeInput method)"
echo ""
echo "Test URLs:"
echo "  - http://localhost:8090/admin/settings"
echo "  - http://localhost:8090/"
echo ""
echo "Test string: Şimşek çarptı, ağaç düştü. Öğrenciler gülüştü."
echo ""
echo "For detailed documentation, see:"
echo "  - TURKISH_CHARACTER_FIX.md"
echo "  - TURKISH_CHARACTER_BEST_PRACTICES.md"
echo "  - TURKISH_CHARACTER_FIX_SUMMARY.md"
echo ""
