# P7_bilemo

# Prerequisites

PHP 8.1
Symfony CLI

# Install dependencies

Before running the project, you need to run the following commands in order to install the appropriate dependencies.

composer install

# Installation and configuration
 Clone or download the repository
Duplicate and rename the .env file to .env.local and modify the necessary information (APP_ENV, APP_SECRET, ...)
# Create a database
Now let's create our database. This will use the DATABASE_URL you've provided in .env.local file.

symfony console doctrine:database:create

# Downloading the project

DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4"
DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=14&charset=utf8"

# Generating the database schema
symfony console doctrine:schema:update --force

# Load fixtures (initial dummy data)
php bin/console doctrine:fixtures:load --append

# Running the webserver
The symfony serve command will start a PHP webserver. You can now go to your
localhost URL : http://127.0.0.1:8000 where the blog should be displayed.

