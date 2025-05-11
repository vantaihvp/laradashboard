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

### Login & Dashboard Page
**Login Page**
![alt text][userLoginImage]

**Forget password Page (Dark mode)**
![alt text][userForgetPasswordImage]

**Dashboard Page Lite Mode**
![alt text][dashboardImage]

**Dashboard Page Dark Mode**
![alt text][dashboardDarkMode]

### Role Pages
**Role List**
![alt text][roleListImage]
**Role Create**
![alt text][roleCreateImage]
**Role Edit**
![alt text][roleEditImage]

### Users Pages
**Users List**
![alt text][userListImage]
**User Create**
![alt text][userCreateImage]

### Modules Page
**Module List**
![alt text][moduleListPage]

**Upload Module**
![alt text][moduleCreatePage]

### Settings Pages
**General Settings**
![alt text][generalSettingsImage]

**Site Appearance**
![alt text][siteAppearanceImage]

**Content Settings**
![alt text][contentSettingsImage]

**Integration Settings**
![alt text][integrationsSettingsImage]

### Monitoring Pages
**Action Logs**
![alt text][actionLogsPage]

**Laravel Pulse**
![alt text][laravelPulsePage]

### Other Pages
Custom Error Pages
![alt text][errorPageImage]


[dashboardImage]: /demo-screenshots/Dashboard%20Page%20white%20Mode.png "Dashboard Page Laravel Role Management"
[dashboardDarkMode]:  /demo-screenshots/Dashboard%20Page%20Dark%20Mode.png "Dashboard Page Dark Mode"
[roleListImage]: /demo-screenshots/Role%20List.png "2-Laravel-Manage-Roles"
[roleCreateImage]: /demo-screenshots/Role%20Create.png "3-Laravel-Role-Create"
[roleEditImage]: /demo-screenshots/Role%20Edit.png "4-Laravel-Role-Edit"
[userListImage]:  /demo-screenshots/Users%20List.png "5-Laravel-Users-Manage" 
[userCreateImage]: /demo-screenshots/User%20Create.png "6-Laravel-User-Create"
[userLoginImage]: /demo-screenshots/login.png "7-Login-Page"
[userForgetPasswordImage]: /demo-screenshots/Forget-password.png "Forget Password"
[errorPageImage]: /demo-screenshots/Custom%20Error%20Pages.png "8 - Error Page Handling"
[moduleListPage]: /demo-screenshots/Module%20List.png
[moduleCreatePage]: /demo-screenshots/Upload%20Module.png
[actionLogsPage]: /demo-screenshots/Action%20Log%20List.png
[laravelPulsePage]: /demo-screenshots/Laravel%20Pulse%20Dashboard%20for%20Monitoring.png
[generalSettingsImage]: /demo-screenshots/Settings-General.png "General Settings Page"
[siteAppearanceImage]: /demo-screenshots/Settings-Site-Appearance.png "Site Appearance Page"
[contentSettingsImage]: /demo-screenshots/Settings-Content.png "Content Settings Page"
[integrationsSettingsImage]: /demo-screenshots/Settings-Google-Analytics.png "Integrations Settings Page"

## Live Demo
https://demo.laradashboard.com

## Premium Features
Please visit at Lara Dashboard to get more premium moduels - https://laradashboard.com. Premium modules included CRM, HRM, Course Managements and so on.

## Core modules
- **User Avatar** - https://github.com/laradashboard/UserAvatar - A very simple module create an avatar for a user. Handle migration, entries/updates in user forms and so on. 

## Contributing

Want to contribute? Fork the project, make your changes, and submit a pull request. Even small improvements to documentation are appreciated!

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