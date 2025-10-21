# Turkish Character Best Practices

## Quick Reference for Developers

### ✅ DO

#### 1. In Controllers (Saving Data)
```php
// Use sanitizeInput() - it now only trims, preserves UTF-8
$data = [
    'title' => $this->sanitizeInput($_POST['title']),
    'description' => $this->sanitizeInput($_POST['description'])
];
```

#### 2. In Views (Displaying Data)
```php
<!-- Always use htmlspecialchars() for XSS protection -->
<h1><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h1>
<p><?php echo htmlspecialchars($description, ENT_QUOTES, 'UTF-8'); ?></p>

<!-- Or shorter version (UTF-8 is default) -->
<?php echo htmlspecialchars($text); ?>
```

#### 3. In HTML Meta Tags
```html
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
```

#### 4. In Database Queries (Using PDO)
```php
// Always use prepared statements - they handle UTF-8 automatically
$sql = "INSERT INTO news (title, content) VALUES (:title, :content)";
$this->db->execute($sql, [
    ':title' => $title,    // Store as UTF-8
    ':content' => $content
]);
```

### ❌ DON'T

#### 1. Don't Double-Encode
```php
// ❌ WRONG - Double encoding
$data = htmlspecialchars($input); // Encode
$this->db->execute($sql, [':title' => $data]); // Save encoded
echo htmlspecialchars($data); // Encode again = WRONG!

// ✅ CORRECT
$data = trim($input); // Just trim
$this->db->execute($sql, [':title' => $data]); // Save as UTF-8
echo htmlspecialchars($data); // Encode only for display
```

#### 2. Don't Use Wrong Functions
```php
// ❌ WRONG - These don't handle Turkish characters well
htmlentities($text, ENT_COMPAT, 'ISO-8859-1'); // Wrong charset
utf8_encode($text); // Don't use if already UTF-8
mb_convert_encoding($text, 'HTML-ENTITIES'); // Unnecessary

// ✅ CORRECT
htmlspecialchars($text, ENT_QUOTES, 'UTF-8'); // Use this!
```

#### 3. Don't Forget Charset in Forms
```html
<!-- ❌ WRONG - No charset specified -->
<form method="POST" action="...">

<!-- ✅ CORRECT -->
<form method="POST" action="..." accept-charset="UTF-8">
```

## Common Turkish Characters

### Lowercase
- ç (c with cedilla)
- ğ (g with breve)
- ı (dotless i)
- ö (o with diaeresis)
- ş (s with cedilla)
- ü (u with diaeresis)

### Uppercase
- Ç, Ğ, İ (capital dotted i), Ö, Ş, Ü

## Testing Turkish Characters

### Test String
```
Şimşek çarptı, ağaç düştü. Öğrenciler gülüştü.
```

### Test in Database
```bash
docker-compose exec database mysql -u root -proot_password spor_kulubu \
  -e "INSERT INTO news (title) VALUES ('Şimşek çarptı, ağaç düştü');"
```

### Test Display
```php
<?php
$text = "Şimşek çarptı, ağaç düştü";
echo htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
// Should display: Şimşek çarptı, ağaç düştü
?>
```

## Debugging Turkish Character Issues

### 1. Check Database Encoding
```sql
-- Show table charset
SHOW CREATE TABLE news;

-- Show column charset
SHOW FULL COLUMNS FROM news WHERE Field = 'title';

-- Check for HTML entities in data
SELECT * FROM news WHERE title LIKE '%&#%';
```

### 2. Check PHP Settings
```php
<?php
// In your PHP file
echo ini_get('default_charset'); // Should be UTF-8
echo mb_internal_encoding();     // Should be UTF-8
?>
```

### 3. Check HTTP Headers
```php
<?php
// In your controllers
header('Content-Type: text/html; charset=UTF-8');
?>
```

### 4. Browser Developer Tools
```
Network → Headers → Response Headers
Content-Type: text/html; charset=UTF-8
```

## Common Issues & Solutions

### Issue 1: Characters Show as ?????
**Problem:** Database or connection not UTF-8
**Solution:** Check database charset settings in `docker/mysql/my.cnf`

### Issue 2: Characters Show as Ã§ or similar
**Problem:** Page served as ISO-8859-1 but contains UTF-8
**Solution:** Add `<meta charset="UTF-8">` and `header('Content-Type: ...; charset=UTF-8')`

### Issue 3: &#039; shows literally
**Problem:** Data was HTML-encoded before storage
**Solution:** Run `FIX_TURKISH_CHARACTERS.sql` script

### Issue 4: &amp;#039; shows literally
**Problem:** Double-encoding (encoded twice)
**Solution:** Only use `htmlspecialchars()` in views, not before storage

## File Checklist

### ✅ Already Configured
- [x] `/docker/mysql/my.cnf` - UTF-8 database
- [x] `/docker/php/php.ini` - UTF-8 PHP
- [x] `/core/Database.php` - UTF-8 PDO connection
- [x] `/core/Controller.php` - No encoding on input
- [x] All view files - Have `<meta charset="UTF-8">`

### 🔍 When Adding New Code
- [ ] New view files: Add `<meta charset="UTF-8">`
- [ ] New forms: Add `accept-charset="UTF-8"`
- [ ] Display user data: Use `htmlspecialchars()`
- [ ] Store data: Just trim, don't encode

## Quick Command Reference

```bash
# Restart web server after changes
docker-compose restart web

# Check database charset
docker-compose exec database mysql -u root -proot_password \
  -e "SHOW VARIABLES LIKE 'character_set%';"

# Fix HTML entities in database
docker-compose exec -T database mysql -u root -proot_password spor_kulubu \
  < FIX_TURKISH_CHARACTERS.sql

# Clear PHP opcache
docker-compose exec web php -r "opcache_reset();"
```

## Summary

**Golden Rule:** Store raw UTF-8, encode only for display!

```
Input → trim() → Database → htmlspecialchars() → Browser
```

This ensures:
- ✅ Turkish characters preserved
- ✅ XSS protection maintained
- ✅ No double-encoding
- ✅ Clean database
