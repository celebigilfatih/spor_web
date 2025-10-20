# Match Display Issue: 4 Matches in Admin but Only 2 on Frontend

## Problem
Admin panel shows 4 matches at http://localhost:8090/admin/matches, but frontend homepage only displays 2 matches.

## Root Cause
The `getUpcomingMatches()` query filters by `match_date > NOW()` to show only **future** matches.

**Current Date**: October 20, 2025

**Matches in Database**:
| ID | Home Team | Away Team | Match Date | Status | Displays? |
|----|-----------|-----------|------------|--------|-----------|
| 11 | Kocaeli | Göztepe | 2025-02-20 22:22:00 | scheduled | ❌ Past (8 months ago) |
| 10 | Özlüce | Yeni Karaman | 2025-10-10 21:00:00 | scheduled | ❌ Past (10 days ago) |
| 7 | Fenerbahçe | Galatasaray | 2025-11-11 19:00:00 | scheduled | ✅ Future (22 days) |
| 9 | Nilüferspor | Yıldırımspor | 2025-11-11 22:22:00 | scheduled | ✅ Future (22 days) |

**Query Result**: Only 2 matches (IDs 7 and 9) are in the future, so only 2 display on frontend.

## Solution Options

### Option 1: Update Past Match Dates (RECOMMENDED) ✅

Update the past matches to have future dates so they display on the homepage.

#### Using phpMyAdmin:
1. Go to: **http://localhost:8091**
2. Select `spor_kulubu` database
3. Click **SQL** tab
4. Paste and run:

```sql
-- Update Kocaeli vs Göztepe to future date
UPDATE matches 
SET match_date = '2025-11-15 20:00:00' 
WHERE id = 11;

-- Update Özlüce vs Yeni Karaman to future date
UPDATE matches 
SET match_date = '2025-11-21 21:00:00' 
WHERE id = 10;
```

5. Click **Go**

#### Using Admin Panel:
1. Go to: **http://localhost:8090/admin/matches**
2. Click **Edit** on each match
3. Change the date to a future date (e.g., November 2025)
4. Save

**After Update**: All 4 matches will show on frontend!

---

### Option 2: Remove Date Filter (NOT RECOMMENDED)

Change the query to show all scheduled matches regardless of date.

**File**: `/app/models/MatchModel.php`

```php
public function getUpcomingMatches($limit = 5)
{
    $sql = "SELECT * FROM {$this->table} 
            WHERE status = 'scheduled' 
            ORDER BY match_date ASC";  // Removed: AND match_date > NOW()
    
    if ($limit) {
        $sql .= " LIMIT {$limit}";
    }
    
    $result = $this->db->query($sql);
    return is_array($result) ? $result : [];
}
```

**Issue**: This would show past matches as "upcoming" which is misleading.

---

### Option 3: Mark Past Matches as Finished

If the past matches were already played, update their status to 'finished' and add scores.

```sql
-- Mark past matches as finished
UPDATE matches 
SET status = 'finished', home_score = 2, away_score = 1
WHERE id = 11;

UPDATE matches 
SET status = 'finished', home_score = 3, away_score = 0
WHERE id = 10;
```

These will then appear in the "Tamamlanan" (Finished) section instead of upcoming.

---

## Recommended Solution

**Use Option 1**: Update the match dates to future dates via admin panel or SQL.

### Quick Fix via SQL:

Run this in phpMyAdmin (http://localhost:8091):

```sql
UPDATE matches SET match_date = '2025-11-15 20:00:00' WHERE id = 11;
UPDATE matches SET match_date = '2025-11-21 21:00:00' WHERE id = 10;
```

### Verify:

After updating, check:

```bash
# Should show 4 matches
curl -s http://localhost:8090/ | grep -o "horizontal-match-card" | wc -l
```

---

## Why This Happens

The `getUpcomingMatches()` method is working correctly - it's designed to show only **future** matches. The issue is that 2 of your 4 matches have dates in the past:

```php
// This query correctly filters future matches
$sql = "SELECT * FROM matches 
        WHERE status = 'scheduled' AND match_date > NOW()
        ORDER BY match_date ASC";
```

This is the expected behavior for an "upcoming matches" feature.

---

## Summary

| Issue | 4 matches in admin, 2 on frontend |
|-------|-----------------------------------|
| Cause | 2 matches have past dates |
| Solution | Update past matches to future dates |
| Method | Admin panel or SQL UPDATE |
| File | UPDATE_MATCH_DATES.sql |

**Status**: Working as designed - just need to update match dates!
