# Symfony Application

This is a sample Symfony application built with Symfony 6, using controllers and repositories, along with Doctrine for the database.

## Getting Started

### Prerequisites

- PHP (version 7.4 or higher)
- Composer (version 2 or higher)
- MySQL or any other compatible database server

### Installation

1. Clone the repository:
   git clone https://github.com/fatimaabadi98/ExpenseManagementBE

2. Navigate to the project directory:
   cd your_directory

3. Install the dependencies:
    composer install

4. Configuration
   Configure the database connection by updating the .env file with your database credentials:
   
   1. DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
   2. Replace db_user, db_password, 127.0.0.1, 3306, and db_name with your actual database credentials.

4. Create the database schema using Doctrine:

 1. php bin/console doctrine:database:create
 2. php bin/console doctrine:migrations:migrate
 3. This will create the necessary database and apply any pending migrations.

4. Development
  To start the development server and run the application locally, use the following command:
  symfony server:start
