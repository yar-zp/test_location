#!/bin/bash

# Laravel Application Readme

# Set the environment variables
ENV_FILE=".env"
ENV_EXAMPLE_FILE=".env.example"

# Step 1: Copy the contents of .env.example to .env

# Step 2: Install PHP dependencies
composer install

# Step 3: Install Node.js dependencies
npm install

# Step 4: Start the development server and generate a new application key
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate

# Step 5: Build the front-end assets
npm run dev

# Print the access URL
echo "The Laravel application is now accessible at http://localhost"
