# P7_bilemo

# Description
BileMo API is webservice exposing an API.

This project aims to developp a REST API to provide mobile phones for clients catalog. 
This first version was developped according to the first client needs:

Consult BileMo products
Consult product details
Consult customers list related to the client
Consult customer details related to the client
Add a new customer related to a client
Delete a customer related to a client
API access is restricted to referenced and authenticated clients.

# Prerequisites

PHP 8.1
Symfony CLI


# Installation and configuration
1 - Git clone the project

https://github.com/LeaVc11/P7_bilemo

# Install dependencies

Before running the project, you need to run the following commands in order to install the appropriate
dependencies.

composer install

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

