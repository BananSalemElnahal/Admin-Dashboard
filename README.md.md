
# Admin Dashboard Project

This project is a simple Admin Dashboard implemented using PHP. It provides basic functionalities such as user login, user management, settings, and logout. The dashboard displays important statistics such as total users, active sessions, revenue, and recent users. The settings page allows the admin to change their password.

## Features

- **Login**: Users can log in with their credentials.
- **Admin Dashboard**: The dashboard shows vital statistics, including the total number of users, active sessions, revenue, and a list of recent users.
- **User Management**: The "Users" page lists all users with their details and status (Active/Inactive).
- **Settings**: The "Settings" page allows the admin to change their password.
- **Logout**: Admins can log out to terminate the session.

## Project Structure

1. **login.php**: The login page where the user provides credentials.
2. **logout.php**: The logout functionality that ends the admin session.
3. **db_connect.php**: Contains the database connection logic.
4. **Admin Dashboard (admin_dashboard.php)**: The main dashboard page with key statistics.
5. **settings.php**: Page for changing the admin password.
6. **update_settings.php**: Logic for updating the password after form submission.
7. **users.php**: Page that lists users and their statuses.
8. **users_home.php**: Home page for users, showing a list of recent users.

## How to Use

1. Clone or download this project.
2. Set up a PHP server and a MySQL database.
3. Edit the `db_connect.php` file to include your database credentials.
4. Navigate to the `login.php` page and log in as the admin.
5. Access the dashboard and manage users or update settings as needed.

## Database Setup

- Create a database named `admin_dashboard`.
- Create a `users` table with the following columns:
  - `id` (Primary Key)
  - `name`
  - `email`
  - `status` (Active/Inactive)
  - `password`

## Dependencies

- PHP 7.4 or higher
- MySQL

## License

This project is licensed under the MIT License.
