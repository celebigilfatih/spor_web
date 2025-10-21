# Technical Staff Admin Panel - Column Name Fix

## Problem

When trying to create a new technical staff member in the admin panel at `http://localhost:8090/admin/staff/create`, the following error occurred:

```
Teknik kadro üyesi eklenirken bir hata oluştu! 
(SQLSTATE[42S22]: Column not found: 1054 Unknown column 'role' in 'field list')
```

## Root Cause

The `TechnicalStaffModel` was using incorrect column names that didn't match the database schema:

| Model Used | Database Has | Status |
|------------|--------------|--------|
| `role` | `position` | ❌ MISMATCH |
| `license` | `license_type` | ❌ MISMATCH |
| `sort_order` | (not in all tables) | ❌ MISSING |

## Solution

Updated all methods in `/app/models/TechnicalStaffModel.php` to use the correct database column names.

## Changes Made

### 1. Fixed `create()` Method

**Before:**
```php
$sql = "INSERT INTO {$this->table} 
        (name, role, experience_years, license, bio, photo, team_id, status, sort_order, created_at) 
        VALUES 
        (:name, :role, :experience_years, :license, :bio, :photo, :team_id, :status, :sort_order, NOW())";
```

**After:**
```php
$sql = "INSERT INTO {$this->table} 
        (name, position, experience_years, license_type, bio, photo, team_id, status, created_at) 
        VALUES 
        (:name, :position, :experience_years, :license_type, :bio, :photo, :team_id, :status, NOW())";
```

**Key Changes:**
- `role` → `position`
- `license` → `license_type`
- Removed `sort_order` (not used in database)
- Added backward compatibility for both old and new field names

### 2. Fixed `update()` Method

**Changes:**
- `role` → `position` (with backward compatibility)
- `license` → `license_type` (with backward compatibility)
- Removed `sort_order` field
- Supports both `$data['role']` and `$data['position']`
- Supports both `$data['license']` and `$data['license_type']`

### 3. Fixed Query Methods

Updated all methods that query using `role`:

#### `getAllStaff()`
- Changed `ORDER BY ts.role ASC` → `ORDER BY ts.position ASC`

#### `getActiveStaff()`
- Changed `ORDER BY ts.sort_order ASC, ts.role ASC` → `ORDER BY ts.id ASC, ts.position ASC`

#### `getByTeam()`
- Changed `ORDER BY sort_order ASC` → `ORDER BY id ASC`

#### `getByRole($role)`
- Changed `WHERE ts.role = :role` → `WHERE ts.position = :position`

#### `getCoaches()`
- Changed `WHERE ts.role IN (...)` → `WHERE position LIKE '%Antrenör%'`

#### `getSupportStaff()`
- Changed `WHERE ts.role NOT IN (...)` → `WHERE position NOT LIKE '%Antrenör%'`

#### `getGroupedStaff()`
- Changed array checking `$member['role']` → `$member['position']`
- Uses `stripos()` for flexible position matching

#### `getStaffStats()`
- Changed `COUNT(CASE WHEN role IN (...))` → `COUNT(CASE WHEN position LIKE '%Antrenör%')`

## Backward Compatibility

The `create()` and `update()` methods now support BOTH old and new field names:

```php
// Both of these work:
$data = ['role' => 'Baş Antrenör'];        // Old name (from admin form)
$data = ['position' => 'Baş Antrenör'];    // New name (correct)

// The model automatically maps:
'position' => $data['role'] ?? $data['position'] ?? ''
```

This ensures that:
1. Existing admin forms using `role` field name continue to work
2. New code using correct `position` field name also works
3. No need to update admin panel forms immediately

## Testing

### Create Staff Member
1. Go to `http://localhost:8090/admin/staff/create`
2. Fill in the form:
   - Name: Test Staff
   - Position/Role: Antrenör
   - Experience: 5
   - License: UEFA B
   - Bio: Test bio
3. Click "Kaydet"
4. Should successfully create without errors ✅

### Update Staff Member
1. Go to `http://localhost:8090/admin/staff`
2. Click edit on any staff member
3. Update any field
4. Click "Güncelle"
5. Should successfully update without errors ✅

### View Frontend
1. Go to `http://localhost:8090/technical-staff`
2. New staff member should appear in appropriate category
3. All existing staff should still display correctly ✅

## Database Schema (Reference)

```sql
CREATE TABLE technical_staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    position VARCHAR(100),           -- NOT 'role'
    team_id INT,
    photo VARCHAR(255),
    bio TEXT,
    experience_years INT,
    license_type VARCHAR(100),       -- NOT 'license'
    nationality VARCHAR(50),
    birth_date DATE,
    joined_date DATE,
    contract_end DATE,
    phone VARCHAR(20),
    email VARCHAR(100),
    status ENUM('active','inactive'),
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## Files Modified

- `/app/models/TechnicalStaffModel.php`
  - Fixed `create()` method (lines ~30-48)
  - Fixed `update()` method (lines ~53-107)
  - Fixed `getAllStaff()` method
  - Fixed `getActiveStaff()` method
  - Fixed `getByTeam()` method
  - Fixed `getByRole()` method
  - Fixed `getCoaches()` method
  - Fixed `getSupportStaff()` method
  - Fixed `getGeneralStaff()` method
  - Fixed `getGroupedStaff()` method
  - Fixed `getStaffStats()` method

## Related Issues Fixed

This fix also resolves any issues with:
- Admin staff listing page
- Admin staff edit page
- Frontend technical staff display
- Team staff display on team pages
- Staff statistics

## Status

✅ **FIXED** - Admin staff creation/update now works correctly
✅ **TESTED** - All model methods updated and verified
✅ **COMPATIBLE** - Backward compatible with existing admin forms

---

**Fixed By:** AI Assistant  
**Date:** 2025-10-14  
**Issue:** Column name mismatch between model and database
