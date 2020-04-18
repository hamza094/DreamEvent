# DreamEvent [![Build Status](https://travis-ci.org/hamza094/Dream.svg?branch=master)](https://travis-ci.org/hamza094/Dream)

Create And Organize Events Linke Meetup and EventBrite 

# Installation
## Step 1.
To run this project, you must have PHP 7 installed as a prerequisite.

Begin by cloning this repository to your machine, and installing all Composer dependencies.

- git clone https://github.com/hamza094/DreamEvent.git
- cd dremevent && composer install
- php artisan key:generate
- mv .env.example .env

If you want use Redis as your cache driver you need to install the Redis Server. You can either use homebrew on a Mac or compile from source (https://redis.io/topics/quickstart).

Next, create a new database and reference its name and username/password within the project's .env file.

## Step 2. 
You'll see Third Party important keys that should be referenced in your .env file.

Third Party Api's User:
- Aws S3
- Facebook Google Social Login
- Google Map
- Pusher
- Stripe

## Step 4.
- For Admin Access Edit config/dream.php, and add any email address that should be marked as an administrator.
- 

For live view visit site 
