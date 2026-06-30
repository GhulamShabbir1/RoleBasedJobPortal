# Quick Reference - Active/Deactivate Feature

## 🎯 What Was Added?

**Feature:** Admin can activate/deactivate users. Deactivated users cannot login.

**Default:** All users are **ACTIVE** by default.

---

## 🚀 How to Use (Admin Guide)

### Deactivate a User - Quick Toggle
1. Go to **User Management** dashboard
2. Find the user in the table
3. Click the **ban icon** (🚫) in the Actions column
4. Confirm when dialog appears
5. User status changes to **INACTIVE** (red)
6. ✅ User cannot login anymore

### Deactivate a User - Via Edit Modal
1. Go to **User Management** dashboard
2. Click **edit icon** (✏️) on the user
3. Scroll to **Status** section
4. **Uncheck** the checkbox
5. Text changes to: "INACTIVE - User blocked"
6. Click **Save**
7. ✅ User cannot login anymore

### Activate a User
1. Find the **inactive user** (red INACTIVE badge)
2. Click the **check icon** (✅) in the Actions column
3. Confirm when dialog appears
4. User status changes to **ACTIVE** (green)
5. ✅ User can login again

### Filter by Status
1. Use the **Status** dropdown filter
2. Select:
   - **All Status** = show all users
   - **Active** = show only active users
   - **Inactive** = show only inactive users
3. Combine with role filter and search

---

## 📊 Status Indicators

| Status     | Badge      | Color | Icon    | Can Login |
|-----------|-----------|-------|---------|-----------|
| **ACTIVE** | ✓ ACTIVE  | Green | ✓      | Yes ✅    |
| **INACTIVE** | ⊘ INACTIVE | Red   | ⊘      | No ❌     |

---

## 🔐 Login Behavior

### Active User Tries to Login
```
Email: user@email.com
Password: correct123
Result: ✅ SUCCESS - Login works, receives token
```

### Inactive User Tries to Login
```
Email: user@email.com  
Password: correct123
Result: ❌ FAILED - Account deactivated
Message: "Your account has been deactivated. 
         Please contact the administrator."
```

---

## 📡 API Endpoints

### Toggle User Active Status
```bash
# Deactivate
PUT /api/users/{id}/status
Authorization: Bearer {token}
Body: { "is_active": false }

# Activate
PUT /api/users/{id}/status
Authorization: Bearer {token}
Body: { "is_active": true }
```

### Response
```json
{
  "success": true,
  "message": "User activated/deactivated successfully",
  "data": {
    "id": "user-id",
    "name": "User Name",
    "is_active": true
  }
}
```

### Filter Users by Status
```bash
GET /api/users/filter?status=active
GET /api/users/filter?status=inactive
Authorization: Bearer {token}
```

---

## 💻 Developer Reference

### New Files
```
app/DTOs/User/UpdateUserStatusDTO.php
app/Features/User/UpdateUserStatusFeature.php
database/migrations/...add_is_active_to_users_table.php
```

### Modified Files
```
app/Models/User.php                          (added is_active)
app/Http/Controllers/UserController.php      (added updateStatus method)
app/Repositories/Eloquent/UserRepository.php (added updateStatus method)
app/Repositories/Eloquent/AuthRepository.php (check is_active on login)
app/Features/Auth/LoginUserFeature.php       (check is_active on login)
routes/api.php                               (added PUT /users/{id}/status)
resources/views/users/manage.blade.php       (UI updates)
```

### Database Change
```sql
-- Added column to users table
ALTER TABLE users ADD COLUMN is_active BOOLEAN DEFAULT 1;

-- Explanation
is_active = 1 (true)  → User can login (ACTIVE)
is_active = 0 (false) → User cannot login (INACTIVE)
```

---

## 🔄 Feature Flow

```
┌─────────────────────────────────────────────────────────┐
│ 1. Admin visits User Management                         │
│    ↓                                                    │
│ 2. Sees user list with status badges                   │
│    ├─ ACTIVE (green) users with ban icon              │
│    └─ INACTIVE (red) users with check icon            │
│    ↓                                                    │
│ 3. Clicks toggle button                                │
│    ├─ Ban icon (for active) → deactivate              │
│    └─ Check icon (for inactive) → activate            │
│    ↓                                                    │
│ 4. Confirms in dialog                                  │
│    ↓                                                    │
│ 5. Request sent to API                                │
│    PUT /api/users/{id}/status                          │
│    ↓                                                    │
│ 6. Database updated                                    │
│    is_active = true/false                             │
│    ↓                                                    │
│ 7. UI updates immediately                             │
│    Status badge and icon change                        │
│    ↓                                                    │
│ 8. Success message shown                              │
└─────────────────────────────────────────────────────────┘
```

---

## 🐛 Troubleshooting

### Problem: User still can login after deactivation
- **Solution:** Browser may have cached token. User needs to:
  1. Clear browser cache
  2. Logout completely
  3. Try login again

### Problem: Migration not running
- **Command:** `php artisan migrate`
- **Check:** `php artisan migrate:status`

### Problem: Inactive user shown as active in table
- **Reason:** Page not refreshed
- **Solution:** Click the **Refresh** button
- **Or:** Press F5 to reload page

### Problem: Toggle button not working
- **Check:** Are you logged in as admin?
- **Check:** Internet connection stable?
- **Try:** Refresh page and try again

---

## 📋 Checklist for Testing

- [ ] Create a test user
- [ ] Login as admin
- [ ] Go to User Management
- [ ] See the test user with "✓ ACTIVE" badge
- [ ] Click the ban icon
- [ ] Confirm deactivation
- [ ] See user status change to "⊘ INACTIVE"
- [ ] Try logging in as that user → Should fail
- [ ] Click check icon to reactivate
- [ ] Confirm activation
- [ ] Try logging in as that user → Should succeed

---

## 🎓 Key Points

✅ **Remember:**
- Default: Users are ACTIVE
- Deactivated users cannot login
- Status changes are instant
- Admin-only action (protected by auth)
- Works on both API and UI

⚠️ **Important:**
- This does NOT delete the user
- User data is preserved
- Can be reactivated anytime
- Existing sessions may still be valid (user sees error on refresh)

---

## 📚 Documentation Files

- **Full Details:** See `ACTIVE_DEACTIVATE_FEATURE.md`
- **Implementation:** See `IMPLEMENTATION_SUMMARY.md`
- **API Examples:** See `API_EXAMPLES.md`
- **UI Guide:** See `UI_CHANGES_GUIDE.md`
- **This File:** Quick Reference

---

## ⏱️ Quick Commands

```bash
# Run migration
php artisan migrate

# Check migration status
php artisan migrate:status

# Rollback if needed
php artisan migrate:rollback --step=1

# Test with Tinker
php artisan tinker
> $user = User::first();
> $user->is_active;  // Check status
> $user->update(['is_active' => false]);  // Deactivate
```

---

## 🆘 Support

**Error in UI?** → Check browser console (F12)
**Error in API?** → Check Laravel logs (`storage/logs/`)
**Database issue?** → Check migration ran: `php artisan migrate:status`
**Feature not showing?** → Clear cache: `php artisan cache:clear`

---

**Last Updated:** June 30, 2026
**Status:** ✅ Production Ready
