# Turkish Character Encoding Fix

## Problem
Turkish characters (ş, ğ, ü, ö, ç, ı, İ, Ş, Ğ, Ü, Ö, Ç) were being HTML-encoded when saved to the database (e.g., `Türkiye'nin` became `Türkiye&#039;nin`), causing double-encoding issues when displayed.

## Root Cause
The `sanitizeInput()` method in the `Controller` class was using `htmlspecialchars()` which converted Turkish characters and special characters to HTML entities **before** saving to the database. Then when displaying with `htmlspecialchars()` again, it caused double encoding.

## Solution

### 1. Controller Changes
**File:** `/core/Controller.php`

**Before:**
```php
public function sanitizeInput($input)
{
    if (is_array($input)) {
        return array_map([$this, 'sanitizeInput'], $input);
    }
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
```

**After:**
```php
public function sanitizeInput($input)
{
    if (is_array($input)) {
        return array_map([$this, 'sanitizeInput'], $input);
    }
    // Just trim, don't encode - preserve Turkish characters
    // XSS protection will be applied in views with htmlspecialchars()
    return trim($input);
}
```

**Key Change:** Removed `htmlspecialchars()` from input sanitization. Now we store raw UTF-8 text in the database and only encode when displaying in views.

### 2. Database Configuration
Already configured correctly:
- **Character Set:** `utf8mb4`
- **Collation:** `utf8mb4_turkish_ci`
- **Connection Charset:** `utf8mb4`

Configuration files:
- `/docker/mysql/my.cnf` - MySQL server settings
- `/core/Database.php` - PDO connection with `charset=utf8mb4`

### 3. Database Data Cleanup
**File:** `/FIX_TURKISH_CHARACTERS.sql`

This script cleans up all existing HTML-encoded data in the database by replacing HTML entities with actual characters:
- `&#039;` → `'`
- `&quot;` → `"`
- `&amp;` → `&`
- `&lt;` → `<`
- `&gt;` → `>`

Affected tables:
- `site_settings`
- `news`
- `announcements`
- `players`
- `technical_staff`
- `teams`
- `matches`
- `youth_groups`

### 4. View Files
All view files already have:
```php
<meta charset="UTF-8">
```

And use `htmlspecialchars()` when displaying user data:
```php
<?php echo htmlspecialchars($settings['site_description'] ?? ''); ?>
```

This provides XSS protection at the display layer, not the storage layer.

## Best Practices Going Forward

### 1. Data Flow
```
User Input → trim() → Database (UTF-8) → htmlspecialchars() → Display
```

### 2. Storage
- ✅ Store raw UTF-8 text in database
- ❌ Don't HTML-encode before storage
- ✅ Use prepared statements (PDO) for SQL injection protection

### 3. Display
- ✅ Always use `htmlspecialchars()` in views for XSS protection
- ✅ Use `ENT_QUOTES` and `'UTF-8'` parameters
- ✅ Example: `<?php echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); ?>`

### 4. Security
- **XSS Protection:** Applied at view layer with `htmlspecialchars()`
- **SQL Injection:** Protected by PDO prepared statements
- **Turkish Characters:** Preserved as UTF-8 throughout

## Files Modified

1. `/core/Controller.php` - Removed `htmlspecialchars()` from `sanitizeInput()`
2. `/FIX_TURKISH_CHARACTERS.sql` - Database cleanup script (executed)

## Testing

### Before Fix
```
Database: Türkiye&#039;nin
Display: Türkiye&amp;#039;nin (double encoded)
```

### After Fix
```
Database: Türkiye'nin (raw UTF-8)
Display: Türkiye&#039;nin (properly encoded for HTML)
Browser: Türkiye'nin (properly rendered)
```

## Verification Commands

```bash
# Check database character set
docker-compose exec database mysql -u root -proot_password -e "SHOW VARIABLES LIKE 'character_set%';"

# Check site settings
docker-compose exec database mysql -u root -proot_password spor_kulubu -e "SELECT * FROM site_settings WHERE setting_key = 'site_description';"

# Check for any HTML entities in database
docker-compose exec database mysql -u root -proot_password spor_kulubu -e "SELECT setting_key FROM site_settings WHERE setting_value LIKE '%&#%';"
```

## Result
✅ Turkish characters now display correctly throughout the entire site
✅ No more double-encoding issues
✅ XSS protection maintained
✅ UTF-8 encoding works properly end-to-end
