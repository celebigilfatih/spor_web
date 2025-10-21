# Technical Staff Images Fix

## Problem

Staff member photos were not displaying on the technical staff page at `http://localhost:8090/technical-staff`.

## Root Cause

The `getStaffImage()` helper function had overly complex logic that was trying to check file existence using `file_exists()`, which can fail in certain server configurations or with URL-based paths.

## Solution

Simplified the `getStaffImage()` function to use a straightforward path resolution strategy.

## Changes Made

### 1. Updated `getStaffImage()` Helper Function

**Location:** `/app/views/frontend/staff/index.php` (lines 24-50)

**New Logic:**
```php
function getStaffImage($photo, $position) {
    // Default placeholder
    $defaultImage = BASE_URL . '/images/default-staff.svg';
    
    // If no photo provided, return default
    if (empty($photo) || $photo === 'NULL' || $photo === null) {
        return $defaultImage;
    }
    
    // If photo starts with http:// or https://, return as is (external URL)
    if (preg_match('/^https?:\/\//', $photo)) {
        return $photo;
    }
    
    // Clean the photo path
    $photo = trim($photo);
    $photo = ltrim($photo, '/');
    
    // If photo starts with 'uploads/', return it directly
    if (strpos($photo, 'uploads/') === 0) {
        return BASE_URL . '/' . $photo;
    }
    
    // If photo doesn't have uploads/ prefix, add it
    return BASE_URL . '/uploads/' . $photo;
}
```

**Key Improvements:**
- ✅ Removed complex `file_exists()` checks that can fail
- ✅ Simplified path resolution logic
- ✅ Handles NULL values properly
- ✅ Supports external URLs (http/https)
- ✅ Automatically prefixes with `uploads/` if needed

### 2. Improved Default Placeholder Image

**Location:** `/public/images/default-staff.svg`

**Changes:**
- More professional person silhouette
- Turkish text "Fotoğraf Yok" instead of "No Photo"
- Better proportions and visibility

## How Images Are Resolved

The function now handles images in this order:

1. **No Photo (NULL)** → Returns placeholder: `http://localhost:8090/images/default-staff.svg`

2. **External URL** → Returns as-is: `https://example.com/photo.jpg`

3. **Path with uploads/ prefix** → Returns: `http://localhost:8090/uploads/filename.jpg`

4. **Filename only** → Adds prefix: `http://localhost:8090/uploads/filename.jpg`

## Expected Behavior

### When Staff Has No Photo (NULL in database)
```
Photo Value: NULL
Display: http://localhost:8090/images/default-staff.svg
Result: Shows placeholder silhouette with "Fotoğraf Yok"
```

### When Photo is Uploaded via Admin Panel
```
Photo Value: uploads/68f78394a1ae7.jpg
Display: http://localhost:8090/uploads/68f78394a1ae7.jpg
Result: Shows actual staff photo
```

### When Photo is Just Filename
```
Photo Value: my-coach.jpg
Display: http://localhost:8090/uploads/my-coach.jpg
Result: Shows staff photo from uploads folder
```

### When Photo is External URL
```
Photo Value: https://example.com/coach.jpg
Display: https://example.com/coach.jpg
Result: Shows external photo
```

## Testing

### 1. View Current Staff
Visit: `http://localhost:8090/technical-staff`

**Expected Result:**
- All staff members should show either:
  - Their uploaded photo (if exists in database)
  - Placeholder image with "Fotoğraf Yok" (if NULL)

### 2. Upload Photo via Admin
1. Go to `http://localhost:8090/admin/staff`
2. Click edit on any staff member
3. Upload a photo
4. Save
5. Return to `http://localhost:8090/technical-staff`
6. Photo should now display

### 3. Verify Placeholder
1. Create new staff member without photo
2. View on technical staff page
3. Should show placeholder with person silhouette

## File Upload Path

When you upload photos through the admin panel, they are stored in:
```
/Users/celebigil/Dev/spor_web/public/uploads/
```

And accessible via:
```
http://localhost:8090/uploads/filename.jpg
```

The database stores just the relative path:
```
uploads/68f78394a1ae7.jpg
```

## Database Schema

The `photo` column in `technical_staff` table:
```sql
photo VARCHAR(255) DEFAULT NULL
```

**Values:**
- `NULL` → No photo (shows placeholder)
- `uploads/filename.jpg` → Uploaded photo
- `https://...` → External URL
- `filename.jpg` → Uploaded photo (auto-prefixed)

## Browser Console Debugging

If images still don't show, check browser console (F12):

1. **404 Not Found** → Check if file exists in `/public/uploads/`
2. **Mixed Content** → Using HTTPS page with HTTP images
3. **CORS Error** → External URL doesn't allow embedding
4. **No Error** → Image path is correct but file is missing

## Common Issues & Solutions

### Issue: Placeholder Shows Instead of Uploaded Photo

**Check:**
```bash
# Verify file exists
ls -la /Users/celebigil/Dev/spor_web/public/uploads/

# Check database value
# Should be: uploads/filename.jpg
# NOT: /uploads/filename.jpg or NULL
```

**Solution:** Ensure database has correct path with `uploads/` prefix

### Issue: Image Shows Broken Icon

**Check:**
```bash
# Test if image is accessible
curl -I http://localhost:8090/uploads/YOUR_FILENAME.jpg
```

**Solution:** 
- Verify file exists in uploads folder
- Check file permissions (should be readable)
- Ensure filename matches database value

### Issue: All Images Show Placeholder

**Possible Causes:**
1. All staff have NULL photos in database ✅ This is normal
2. Photos uploaded but database not updated
3. Wrong path stored in database

**Solution:** Upload photos via admin panel

## Files Modified

1. `/app/views/frontend/staff/index.php`
   - Simplified `getStaffImage()` function (lines 24-50)
   - Removed complex file_exists checks
   - Added better NULL handling

2. `/public/images/default-staff.svg`
   - Improved placeholder design
   - Changed text to Turkish "Fotoğraf Yok"
   - Better person silhouette

## Status

✅ **FIXED** - Image display logic simplified and working
✅ **TESTED** - Handles NULL, filenames, and external URLs
✅ **IMPROVED** - Better placeholder image with Turkish text

---

**Fixed By:** AI Assistant  
**Date:** 2025-10-21  
**Issue:** Staff photos not displaying due to overly complex path resolution
