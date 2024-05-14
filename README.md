# Pharmacy Management App

## Introduction

This pharmacy software handles customer record management, drug inventory management, and authentication. 

## Technologies Used

- **Laravel Sanctum**: Provides a simple authentication system, which comes integrated with Laravel by default.
- **Laravel Policies**: Used to manage access control for various tasks performed by different users.
- **API Resources**: Transform models and model collections into JSON format for easy API integrations.
- **Resource Controllers and Routes**: Facilitate streamlined and organized CRUD operations for handling data efficiently.
- **Seeders**: Added seeders with dummy data to test the application easily.


## Installation

Provide step-by-step instructions on how to get a development environment running:

```bash
# Clone the repository
git clone https://github.com/vimuths123/pharmacyapp.git

# Navigate to the project directory
cd pharmacy-management-app

# Install dependencies
composer install

# Copy the example env file and make the necessary configuration changes in the .env file
cp .env.example .env

# Generate a new application key
php artisan key:generate

# Change this in .env and remove other db settings
DB_CONNECTION=sqlite

# Run the database migrations (This will create the sqlite database)
php artisan migrate

# Run seed command to add dummy data to database
php artisan db:seed

# Start the local development server
php artisan serve
```

## Usage

First you need to import the postman collection to the Postman. And you have to add variables. First add host variable. Then goes to user login url get token and update token variable

![image](https://github.com/vimuths123/pharmacyapp/assets/16515909/3f41825d-b336-4229-bd01-f7724dfbfdba)

After that you can run the application with postman collections.

## Notes

- Have created a restore method to restore soft deleted items. Only owner and manager has access to it.
- Haven't use Route Model binding for delete and restore methods since it will not consider soft deleted items.
- You can access all recoreds including thrashed recoreds using ?with_trashed=true query parameter.
  Eg: Get http://localhost:8000/api/medications?with_trashed=true
- And you can get only thrashed records using ?only_trashed=true parameter
  Eg: Get http://localhost:8000/api/medications?only_trashed=true
- Also I have added pagination.
