# Online Store CRUD Operations with PHP

This project is a simple implementation of CRUD (Create, Read, Update, Delete) operations using PHP for an online store. It utilizes Object-Oriented Programming (OOP) principles to manage products, customers, and orders. This README provides an overview of the project and instructions for setting it up and using it.

## Features

- **Product Management**: Add, view, update, and delete products.
- **Customer Management**: Add, view, update, and delete customers.
- **Order Management**: Create, view, update, and delete orders.
- **Database Integration**: Data is stored in a MySQL database.

## Getting Started

Follow these steps to get the project up and running on your local machine.

### Prerequisites

- PHP (7.0 or higher)
- MySQL Database
- Web Server (e.g., Apache, Nginx)

### Installation

1. Clone the repository to your local machine:

   ```
   git clone https://github.com/yourusername/online-store-crud.git
   ```

2. Create a MySQL database for the project and import the included SQL file (`database.sql`) to set up the required tables.

3. Update the database configuration in `config.php` with your database credentials:

   ```php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'your_username');
   define('DB_PASSWORD', 'your_password');
   define('DB_NAME', 'your_database_name');
   ```

4. Start your web server to serve the PHP files.

5. Open a web browser and navigate to the project's URL (e.g., `http://localhost/online-store-crud`).


## Contributing

If you'd like to contribute to this project, please follow these steps:

1. Fork the repository to your GitHub account.

2. Create a new branch for your feature or bug fix:

   ```
   git checkout -b feature/your-feature-name
   ```

3. Commit your changes and push them to your forked repository:

   ```
   git commit -m "Your detailed description of changes"
   git push origin feature/your-feature-name
   ```

4. Open a pull request on the original repository, explaining your changes and improvements.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
