# Apostolate's Family Catechism Lookup
This app takes a list of paragraphs from the Catechism of the Catholic Church (CCC) and determines the corresponding
questions in the Apostolate's Family Catechism (AFC).

## Running the app
This application uses the Laravel framework, so it can be run a number of ways.

### From the command line:
1. Set up the environment
   ```shell script
   cp .env.example .env
   echo "DB_DATABASE=$(pwd)/database/database.sqlite" >> .env
   ```
   Note: The `DB_DATABASE` must be set to the fully qualified path to the `database.sqlite` in order
   for `migrate`, `db:seed`, and `serve` to work.  

1. Install application libraries
   ```shell script
   npm install
   composer update
   ```

1. Initialize the database
   ```shell script
   touch database/database.sqlite
   php artisan migrate
   php artisan db:seed
   ```
1. Start the server
   ```
   php artisan serve
   ```

The app will be accessible at [http://localhost:8080](http://localhost:8080).

Stop the app with a `CTRL+C`.

### As a container:
1. Build the container
   ```shell script
   docker-compose build
   ```
   
1. Start the container
   ```shell script
    docker-compose up
   ```

The app will be accessible at [http://localhost](http://localhost).

If you want the container to run detached from
the console, use `docker-compose up -d`. Stop the app with a `CTRL+C` or `docker-compose down` if running detached.

## TODO
This is a hobby app so there are a few things I would like to add:
* Show larger covers on mouseover for resources
* `npm run dev` is now required to compile SASS
* Add page for admin to disable account
* Change docker build to not include 'require-dev' dependencies
* Add "Copy to Clipboard" feature to copy search results
* See if we can make seeding faster by eliminating the double query for Question
* Add automated testing
* Migrate to a VUE frontend so that the search does not reload the page
* Create list of suggested CCC topics that launch a search when clicked
* Take a look at how a Laravel app gets deployed in production. There may be some steps I need to do to remove dev
dependencies.
* Figure out how to cache dependencies so `npm install` and `compose update` don't have to download from the internet
