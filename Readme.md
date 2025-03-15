# Project Name

ECOMMERCE

## Description

This is a fully functional PHP-based website with user authentication, profile management, and an order tracking system. The website supports dynamic content retrieval from a MySQL database and includes secure session handling.

## Features

- User Registration & Login
- Profile Management
- Shopping Cart System
- Order Tracking
- Secure Logout
- Mobile Responsive Design

## Technologies Used

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP, MySQL
- **Libraries:** FontAwesome for icons
- **Database:** MySQL

## Installation

### Prerequisites

Ensure you have the following installed:

- PHP (>=7.4)
- MySQL Server
- Apache Server (or XAMPP/WAMP for local testing)
- Git (for version control)

### Steps to Run Locally

1. **Clone the Repository**

   ```sh
   git clone https://github.com/CleopasMMuchiri/ecommerce_website
   cd your-repo
   ```

2. **Create Database**

   - Open **phpMyAdmin** or MySQL CLI.
   - Create a new database:
     ```sql
     CREATE DATABASE your_database_name;
     ```
   - Import the SQL file located in the `database` folder.

3. **Configure Database Connection**

   - Open `private/config.php` and update:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root');
     define('DB_PASS', 'yourpassword');
     define('DB_NAME', 'your_database_name');
     ```

4. **Start Server**

   - If using XAMPP/WAMP, place the project inside `htdocs` (XAMPP) or `www` (WAMP).
   - Start Apache & MySQL.
   - Access via `http://localhost/your-project-folder`.

## Usage

- Register a new account or log in.
- Add items to the cart and proceed to checkout.
- Track orders via the **Orders** page.
- Logout securely when finished.

## License

This project is open-source and available under the [MIT License](LICENSE).

## Contact

For inquiries or contributions, feel free to reach out:

- **Email:** [your.email@example.com](cleopasmmuchiri@gmail.com)
- **GitHub:** [Your GitHub Profile](https://github.com/CleopasMMuchiri)

# ecommerce_website
