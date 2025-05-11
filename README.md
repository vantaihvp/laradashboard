<a id="readme-top"></a>

[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![Unlicense License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]

<img width="100%" alt="Lara Dashboard" src="https://github.com/user-attachments/assets/c56009a4-718f-43dc-bd1e-caad5417b05b"  />

**Lara Dashboard** - A project which manages Role, Permissions and every actions of your Laravel application. A complete solution for Role based Access Control in Laravel with Tailwind CSS integrated with all starting features including dark/lite mode, charts, tables, logs, forms and so on...

**Demo:** https://demo.laradashboard.com/
```
Email - superadmin@example.com
password - 12345678
```

## Requirements:
- Laravel `7.x` | `9.7` | `11.x` | `12.x`
- Spatie role permission package  `^6.4`
- PHPUnit test package `^11.x`
- Tailwind CSS >= 4.x
- Laravel Modules - https://laravelmodules.com/docs/12/getting-started/introduction
- Laravel Events (A WordPress like action/filter hooks) - https://github.com/tormjens/eventy

### Built With

* [![PHP][PHP.com]][PHP-url]
* [![Laravel][Laravel.com]][Laravel-url]
* [![Tailwind CSS][TailwindCSS.com]][TailwindCSS-url]
* [![JavaScript][JavaScript.com]][JavaScript-url]
* [![Alpine JS][AlpineJS.com]][AlpineJS-url]
* [![React][React.js]][React-url]
* [![MySQL][MySQL.com]][MySQL-url]

## Changelog
**[v1.0.0] - 2025-04-21**
- **Feature - Forget Password Management**: Enhanced the forget password functionality for better reliability and user experience.
- **Feature - Settings Management**: Added comprehensive settings management features, including API support.
- **Enhancement - Role-Based Access Control (RBAC) Improvements**: Improved authorization mechanisms and role-based access control.
- **Feature - Admin Impersonation**: Administrators can now log in as other users and switch back to their original accounts seamlessly.
- **Enhancement - UI/UX Enhancements**: Updated the role create/edit form for a more intuitive and user-friendly experience.
- **Enhancement - User Profile and Management Enhancements**: Refactored user-related operations to utilize `UserService` and `RolesService` for better separation of concerns and maintainability.
- **Docs - Documentation and Configuration Updates**:
  - Updated `.env.example` to include a `GITHUB_LINK` variable for improved project visibility.

## Versions:
- Laravel `7.x` & PHP -`7.x`
    - Tag - https://github.com/ManiruzzamanAkash/laravel-role/releases/tag/Laravel7.x
    - Branch - https://github.com/ManiruzzamanAkash/laravel-role/tree/Laravel7.x

- Laravel `9.7` & PHP - `8.x`
    - Tag - https://github.com/ManiruzzamanAkash/laravel-role/releases/tag/Laravel9.x

- Laravel `11.x`
    - Tag - https://github.com/ManiruzzamanAkash/laravel-role/releases/tag/v11.x-main

- Laravel `12.x` & PHP >= `8.3`
    - Tag - https://github.com/ManiruzzamanAkash/laravel-role/releases/tag/Laravel12.x

- Laravel `12.x` & Tail Admin Template Integration
    - Tag - https://github.com/ManiruzzamanAkash/laravel-role/releases/tag/Laravel12.x-tailadmin

- Laravel `12.x` & Module & Action Log integration
    - Tag - https://github.com/ManiruzzamanAkash/laravel-role/releases/tag/Laravel12.x-module-logs

- v1.0.0 - Settings, Forget password and lots of refactorring
    - Tag - https://github.com/ManiruzzamanAkash/laravel-role/releases/tag/v1.0.0

## Project Setup
**Clone and Go Project**
```console
git clone git@github.com:laradashboard/laradashboard.git
cd laradashboard
```

**Install Composer & Node Dependencies**
```console
composer install
npm install
```

**Database & env creation**
- Create database called - `laradashboard`
- Create `.env` file by copying `.env.example` file

**Generate Artisan Key or necessary linkings**
```console
php artisan key:generate
php artisan storage:link
```

**Migrate Database with seeder**
```console
php artisan migrate:fresh --seed && php artisan module:seed
```

**Run Project**
```php
php artisan serve
npm run dev
```

So, You've got the project of Laravel Role & Permission Management on your http://localhost:8000

## Previously From laravel-role
We were previously at https://github.com/ManiruzzamanAkash/laravel-role, so you need to change the URL if you moved from there
```console
git remote set-url origin git@github.com:laradashboard/laradashboard.git
```

## How it works
1. Login using Super Admin Credential -
    1. Email - `superadmin@example.com`
    1. Password - `12345678`
1. Forget password - Password forget and reset will work if email is set up properly
1. Create User
1. Create Role
1. Assign Permission to Roles
1. Assign Multiple Role to an User
1. Check by login with the new credentials.
1. If you've not enough permission to do any task, you'll get a warning message.
1. Dashboard with Beautiful chart integrated
1. Module Based Development - Custom Module Add/Enable/Disable/Delete
1. Monitoring - Logging of every action of your application
1. Monitoring - Laravel Pulse

## Email setup
You can use mailtrap to test emails easily - https://mailtrap.io/ (first need to create mailtrap account and can )

```bash
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=mailtrap-username
MAIL_PASSWORD=mailtrap-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=youremail@example.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Documentation
https://laradashboard.com/docs/

## Screenshots

### Login & Authentication
<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
  <div style="flex: 1; min-width: 45%;">
    <strong>Login Page</strong><br/>
    <img width="100%" alt="Login Page" src="/demo-screenshots/login.png"/>
  </div>
  <div style="flex: 1; min-width: 45%;">
    <strong>Forget Password Page (Dark Mode)</strong><br/>
    <img width="100%" alt="Forget Password Page" src="/demo-screenshots/Forget-password.png"/>
  </div>
</div>

### Dashboard
<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
  <div style="flex: 1; min-width: 45%;">
    <strong>Dashboard (Light Mode)</strong><br/>
    <img width="100%" alt="Dashboard Light Mode" src="/demo-screenshots/Dashboard%20Page%20white%20Mode.png"/>
  </div>
  <div style="flex: 1; min-width: 45%;">
    <strong>Dashboard (Dark Mode)</strong><br/>
    <img width="100%" alt="Dashboard Dark Mode" src="/demo-screenshots/Dashboard%20Page%20Dark%20Mode.png"/>
  </div>
</div>

### Role Management
<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
  <div style="flex: 1; min-width: 45%;">
    <strong>Role List (Light Mode)</strong><br/>
    <img width="100%" alt="Role List" src="/demo-screenshots/Role%20List.png"/>
  </div>
  <div style="flex: 1; min-width: 45%;">
    <strong>Role List (Dark Mode)</strong><br/>
    <img width="100%" alt="Role List Dark" src="/demo-screenshots/Role%20List%20Dark.png"/>
  </div>
</div>

<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
  <div style="flex: 1; min-width: 45%;">
    <strong>Role Create</strong><br/>
    <img width="100%" alt="Role Create" src="/demo-screenshots/Role%20Create.png"/>
  </div>
  <div style="flex: 1; min-width: 45%;">
    <strong>Role Edit</strong><br/>
    <img width="100%" alt="Role Edit" src="/demo-screenshots/Role%20Edit.png"/>
  </div>
</div>

### User Management
<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
  <div style="flex: 1; min-width: 45%;">
    <strong>Users List (Light mode)</strong><br/>
    <img width="100%" alt="Users List (Light mode)" src="/demo-screenshots/Users%20List.png"/>
  </div>
  <div style="flex: 1; min-width: 45%;">
    <strong>Users List (Dark mode)</strong><br/>
    <img width="100%" alt="Users List (Dark mode)" src="/demo-screenshots/User List Dark.png" />
  </div>
  <div style="flex: 1; min-width: 45%;">
    <strong>User Create</strong><br/>
    <img width="100%" alt="User Create" src="/demo-screenshots/User%20Create.png"/>
  </div>
  <div style="flex: 1; min-width: 45%;">
    <strong>User Delete</strong><br/>
    <img width="100%" alt="User Delete" src="/demo-screenshots/User Delete.png" />
  </div>
</div>

### Module Management
<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
  <div style="flex: 1; min-width: 45%;">
    <strong>Module List</strong><br/>
    <img width="100%" alt="Module List" src="/demo-screenshots/Module%20List.png"/>
  </div>
  <div style="flex: 1; min-width: 45%;">
    <strong>Upload Module</strong><br/>
    <img width="100%" alt="Upload Module" src="/demo-screenshots/Upload%20Module.png"/>
  </div>
</div>

### Settings Pages
<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
  <div style="flex: 1; min-width: 45%;">
    <strong>General Settings</strong><br/>
    <img width="100%" alt="General Settings" src="/demo-screenshots/Settings-General.png"/>
  </div>
  <div style="flex: 1; min-width: 45%;">
    <strong>Site Appearance</strong><br/>
    <img width="100%" alt="Site Appearance" src="/demo-screenshots/Settings-Site-Appearance.png"/>
  </div>
</div>

<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
  <div style="flex: 1; min-width: 45%;">
    <strong>Content Settings</strong><br/>
    <img width="100%" alt="Content Settings" src="/demo-screenshots/Settings-Content.png"/>
  </div>
  <div style="flex: 1; min-width: 45%;">
    <strong>Integration Settings</strong><br/>
    <img width="100%" alt="Integration Settings" src="/demo-screenshots/Settings-Google-Analytics.png"/>
  </div>
</div>

### Translations Pages
<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
  <div style="flex: 1; min-width: 45%;">
    <strong>Translations List</strong><br/>
    <img width="100%" alt="Translations List" src="/demo-screenshots/Translations List.png" />
  </div>
  <div style="flex: 1; min-width: 45%;">
    <strong>Add Language</strong><br/>
    <img width="100%" alt="Create Translation" src="/demo-screenshots/Translations List Dark.png" />
  </div>
  <div style="flex: 1; min-width: 45%;">
    <strong>Language Switcher</strong><br/>
    <img width="100%" alt="Language Switcher" src="/demo-screenshots/Language switcher.png" />
  </div>
  <div style="flex: 1; min-width: 45%;"></div>
</div>

### Monitoring
<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
  <div style="flex: 1; min-width: 45%;">
    <strong>Action Logs</strong><br/>
    <img width="100%" alt="Action Logs" src="/demo-screenshots/Action%20Log%20List.png"/>
  </div>
  <div style="flex: 1; min-width: 45%;">
    <strong>Laravel Pulse</strong><br/>
    <img width="100%" alt="Laravel Pulse" src="/demo-screenshots/Laravel%20Pulse%20Dashboard%20for%20Monitoring.png"/>
  </div>
</div>

### Other Pages
<div style="display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px;">
  <div style="flex: 1; min-width: 45%;">
    <strong>Custom Error Pages</strong><br/>
    <img width="100%" alt="Custom Error Pages" src="/demo-screenshots/Custom%20Error%20Pages.png"/>
  </div>
  <div style="flex: 1; min-width: 45%;">
    <!-- Reserved for future screenshot -->
  </div>
</div>

## Live Demo
https://demo.laradashboard.com

## Premium Features
Please visit at Lara Dashboard to get more premium moduels - https://laradashboard.com. Premium modules included CRM, HRM, Course Managements and so on.

## Core modules
- **User Avatar** - https://github.com/laradashboard/UserAvatar - A very simple module create an avatar for a user. Handle migration, entries/updates in user forms and so on. 

## Contributing

Want to contribute? Fork the project, make your changes, and submit a pull request. Even small improvements to documentation are appreciated!

Please be sure to read our [Contribution Guide](CONTRIBUTING.md) before submitting your PR.

### Top contributors:
<a href="https://github.com/laradashboard/laradashboard/graphs/contributors">
  <img src="https://contrib.rocks/image?repo=laradashboard/laradashboard" alt="contrib.rocks image" />
</a>

## Support
If you like my work you may consider buying me a ☕ / 🍕

<a href="https://www.patreon.com/maniruzzaman" target="_blank" title="Buy Me A Coffee">
    Go to Patreon
</a>

## Contact

Maniruzzaman Akash - [@LinkedIn](https://www.linkedin.com/in/maniruzzamanakash) - manirujjamanakash@gmail.com


<p align="right">(<a href="#readme-top">back to top</a>)</p>


<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/laradashboard/laradashboard.svg?style=for-the-badge
[contributors-url]: https://github.com/laradashboard/laradashboard/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/laradashboard/laradashboard.svg?style=for-the-badge
[forks-url]: https://github.com/laradashboard/laradashboard/network/members
[stars-shield]: https://img.shields.io/github/stars/laradashboard/laradashboard.svg?style=for-the-badge
[stars-url]: https://github.com/laradashboard/laradashboard/stargazers
[issues-shield]: https://img.shields.io/github/issues/laradashboard/laradashboard.svg?style=for-the-badge
[issues-url]: https://github.com/laradashboard/laradashboard/issues
[license-shield]: https://img.shields.io/github/license/laradashboard/laradashboard.svg?style=for-the-badge
[license-url]: https://github.com/laradashboard/laradashboard/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/maniruzzamanakash
[product-screenshot]: images/screenshot.png
[Next.js]: https://img.shields.io/badge/next.js-000000?style=for-the-badge&logo=nextdotjs&logoColor=white
[Next-url]: https://nextjs.org/
[React.js]: https://img.shields.io/badge/React-20232A?style=for-the-badge&logo=react&logoColor=61DAFB
[React-url]: https://reactjs.org/
[Vue.js]: https://img.shields.io/badge/Vue.js-35495E?style=for-the-badge&logo=vuedotjs&logoColor=4FC08D
[Vue-url]: https://vuejs.org/
[Angular.io]: https://img.shields.io/badge/Angular-DD0031?style=for-the-badge&logo=angular&logoColor=white
[Angular-url]: https://angular.io/
[Svelte.dev]: https://img.shields.io/badge/Svelte-4A4A55?style=for-the-badge&logo=svelte&logoColor=FF3E00
[Svelte-url]: https://svelte.dev/
[Laravel.com]: https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white
[Laravel-url]: https://laravel.com
[Bootstrap.com]: https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white
[Bootstrap-url]: https://getbootstrap.com
[JQuery.com]: https://img.shields.io/badge/jQuery-0769AD?style=for-the-badge&logo=jquery&logoColor=white
[JQuery-url]: https://jquery.com
[PHP.com]: https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white
[PHP-url]: https://www.php.net
[JavaScript.com]: https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black
[JavaScript-url]: https://developer.mozilla.org/en-US/docs/Web/JavaScript
[MySQL.com]: https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white
[MySQL-url]: https://www.mysql.com
[TailwindCSS.com]: https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white
[TailwindCSS-url]: https://tailwindcss.com
[AlpineJS.com]: https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=black
[AlpineJS-url]: https://alpinejs.dev