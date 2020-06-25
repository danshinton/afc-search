# Apostolate's Family Catechism Lookup
This app takes a list of paragraphs from the Catechism of the Catholic Church (CCC) and determines the corresponding
questions in the Apostolate's Family Catechism (AFC).

## Running the app
This application uses the Laravel framework, so it can be run a number of ways.

1. From the command line:
   ```shell script
   cp .env.example .env
   npm install
   composer update
   php artisan serve
   ```
   The app will be accessible at [http://localhost:8080](http://localhost:8080). Stop the app with a `CTRL+C`.
    
2. As a container:
   ```shell script
   docker-compose build
   docker-compose up
   ```
   The app will be accessible at [http://localhost](http://localhost). If you want the container to run detached from
   the console, use `docker-compose up -d`. Stop the app with `docker-compose down`.

## TODO
This is a hobby app so there are a few things I would like to add:
* Check this project into a private github repo
  * Don't commit node_modules. Add to `.gitignore`.
  * This means npm install will have to be run on a fresh project checkout
* Check to ensure I don't have to add `npm install` to the Docker build
* Use sqlite to store and query the data
* Add links to the PDF versions of the AFC
* Add "Copy to Clipboard" feature to copy search results
* Migrate to a VUE frontend so that the search does not reload the page
* Create list of suggested CCC topics that launch a search when clicked
* Take a look at how a Laravel app gets deployed in production. There may be some steps I need to do to remove dev
dependencies.
* Set the favicon to the AFC symbol
