# Modern Student Portal

An interactive, social-media-like college portal built with PHP, MySQL, and Bootstrap. This project demonstrates a modern, role-based web application where Students, Alumni, Teachers, and Admins can interact, share posts, and manage user information.

## Key Features

- Role-based access: `Student`, `Alumni`, `Teacher`, `Admin`.
- Posts, likes, and comments with admin moderation.
- User profiles with configurable public badge visibility.
- Admin badge management: assign badges to users from the admin UI.
- Curriculum, schedules, grades, and messaging components.
- Lightweight APIs under `/api/` for single-purpose endpoints.

## Project Structure (high level)

- `public/` — front-end entry points and role-based pages.
  - `admin/`, `student/`, `teacher/`, `alumni/`, `visitors/`
- `api/` — server endpoints used by the front-end (JSON responses).
- `database/laragondatabase.sql` — schema and sample data dump.
- `includes/` — shared configuration (DB connection, env files).
- `public/backend/` — server handlers for form submissions and updates.

## Badge System Overview

The portal includes a badge system:

- Table: `badges(badge_id, badge_icon, user_id, badge_description, date_given)`
- Admins can create badges using `api/giveBadge.php` and manage them via the admin UI.
- Users can toggle badge visibility (`badge_visibility` in `user_information`) so badges can be private or public.
- Badges are fetched via `api/getUserBadges.php` which enforces visibility rules.

## Setup (local using Laragon / XAMPP)

1. Place the project folder in your web root (e.g., `C:\laragon\www\Modern Student Portal`).
2. Import `database/laragondatabase.sql` into MySQL.
3. Update `includes/db_connect.php` or `includes/database.env` with your DB credentials.
4. Start your local server and open: `http://localhost/Modern%20Student%20Portal/public/visitors/LoginPage.php`.

## Quick API Tests (curl examples)

- Fetch badges for user 67 (as admin or allowed user):

```bash
curl "http://localhost/Modern%20Student%20Portal/api/getUserBadges.php?user_id=67" \
	-b cookies.txt -c cookies.txt
```

- Assign a badge (Admin session required):

```bash
curl -X POST "http://localhost/Modern%20Student%20Portal/api/giveBadge.php" \
	-d "user_id=67" -d "badge_icon=bi-award-fill" -d "badge_description=Dean's Lister" \
	-b cookies.txt -c cookies.txt
```

Note: Use cookie jar (`-b`/`-c`) to include session authentication (login first).

## Admin workflow for badges
Sample Admin Account: TRCAdmin@gmail.com; Password: 123
1. Go to `public/admin/Pages/UserManagement.php` (Admin only).
2. Click the award icon in the Actions column to open the Badge Manager modal.
3. Create a badge (icon, description, date) and assign it; the modal lists assigned badges.
