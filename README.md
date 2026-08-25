# Laravel Admin & RBAC Boilerplate

A modular Laravel starter boilerplate featuring role-based access control (RBAC), activity logging, dynamic system settings, and an administration dashboard.

---

## 📁 Project Structure

```text
Laravel_Structure/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php                    <- Base Controller (Extends BaseController for $this->middleware())
│   │   │   ├── LanguageController.php            <- Switches app locale (en / kh)
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php      <- Admin KPI stats & recent activity
│   │   │       ├── UserController.php           <- User CRUD & role assignment
│   │   │       ├── RoleController.php           <- Role CRUD & permission binding
│   │   │       ├── PermissionController.php     <- Permission CRUD
│   │   │       ├── SettingController.php        <- System settings
│   │   │       ├── NotificationController.php   <- Alerts & notifications
│   │   │       └── ActivityLogController.php    <- Audit & activity trail
│   │   └── Middleware/
│   │       └── SetLocale.php                    <- Dynamic session locale handler
│   ├── Models/
│   │   ├── User.php                             <- HasRoles & HasApiTokens traits
│   │   └── Setting.php                          <- Key-value setting model
│   └── Providers/
│       └── AppServiceProvider.php               <- Gate::before super-admin bypass
│
├── database/
│   └── seeders/
│       ├── DatabaseSeeder.php                   <- Main seeder entry point
│       ├── RolesAndPermissionsSeeder.php        <- Spatie permissions & roles setup
│       └── AdminUserSeeder.php                  <- Initial super admin account
│
├── lang/
│   ├── en.json                                  <- English translation dictionary
│   └── kh.json                                  <- Khmer translation dictionary
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php                    <- Main app shell (Lucide icons CDN)
│       │   ├── sidebar.blade.php                <- Dynamic permission-guarded sidebar
│       │   └── navigation.blade.php             <- Top navbar & language switcher
│       └── admin/
│           ├── dashboard.blade.php              <- Admin dashboard metrics
│           ├── users/                           <- index, show, create, edit
│           ├── roles/                           <- index, show, create, edit
│           ├── permissions/                     <- index, create, edit
│           ├── settings/                        <- edit
│           └── activity-logs/                   <- index
│
└── routes/
    └── web.php                                  <- Resource routes & locale switchers
