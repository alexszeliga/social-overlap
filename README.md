# About Social Overlaps

Social overlaps is the start of a social media web app built using Laravel 11.

## How to run Social Overlaps for Development

You will need to have all the pre-req's fulfilled to be able to run a Laravel 11 app, like PHP and a Database. You will have to make your own `.env` file, then the app can be served using your choice of development server set-up.

## Using Sail

I recomment using `artisan sail` to construct your development environment. The `.env.example` has default values that assume that you'll be using Redis, Mailtrap and the app server via Sail as described in the `/docker` folder. It assumes you'll be providing a separate DB running locally on the machine.

## The Laravel basics

After Getting the pre-reqs lined up and configuring your development server and DB, you can install the composer packages, install the node packages, run the migrations and seeds and go to the home page.
