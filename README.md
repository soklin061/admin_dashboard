# Laravel Admin & RBAC Boilerplate

A modular Laravel starter boilerplate featuring role-based access control (RBAC), activity logging, dynamic system settings, and an administration dashboard.

---

## 📁 Project Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── ActivityLogController.php   # System audit & event log viewer
│   │   │   ├── DashboardController.php      # Main admin overview & metrics
│   │   │   ├── NotificationController.php  # Admin alert & notification management
│   │   │   ├── PermissionController.php    # Granular permission management
│   │   │   ├── RoleController.php          # Role definitions & capability mapping
│   │   │   ├── SettingController.php       # Dynamic application configuration
│   │   │   └── UserController.php          # User lifecycle & role assignments
│   │   └── ProfileController.php           # Account profile management (Breeze)
│   └── Providers/
│       └── AppServiceProvider.php
└── Models/
    ├── Setting.php
    └── User.php

database/
└── migrations/
    ├── 0001_01_01_000000_create_users_table.php
    ├── create_activity_log_table.php       # Spatie Activitylog migration
    ├── create_permission_tables.php        # Spatie Permission migration
    └── create_settings_table.php

resources/
└── views/
    ├── admin/
    │   ├── activity-logs/
    │   │   └── index.blade.php
    │   ├── dashboard.blade.php
    │   ├── notifications/
    │   │   └── index.blade.php
    │   ├── permissions/
    │   │   ├── create.blade.php
    │   │   └── index.blade.php
    │   ├── roles/
    │   │   ├── create.blade.php
    │   │   ├── edit.blade.php
    │   │   └── index.blade.php
    │   ├── settings/
    │   │   └── edit.blade.php
    │   └── users/
    │       ├── create.blade.php
    │       ├── edit.blade.php
    │       └── index.blade.php
    ├── layouts/
    │   ├── app.blade.php
    │   └── navigation.blade.php
    └── profile/
        └── edit.blade.php

routes/
└── web.php                                 # Admin route group & auth middleware definitions