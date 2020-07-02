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

1. Install application libraries and compile
   ```shell script
   npm install
   npm run dev
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

## Debugging

### Install Xdebug

1. Install [Xdebug](https://xdebug.org/docs/install)
   ```shell script
   brew install autoconf automake m4
   pecl install xdebug
   ```
   Note: If you get an error like
   ```shell script
   autom4te: need GNU m4 1.4 or later: /opt/local/bin/gm4
   ``` 
   Then replace that version of gm4 with the latest version. I accomplished this via the following:
   ```shell script
   brew install m4
   sudo mv /opt/local/bin/gm4 /opt/local/bin/gm4.old
   sudo cp /usr/local/Cellar/m4/1.4.18/bin/m4 /opt/local/bin/gm4
   ```
   Now you should be able to run the `pecl` command.

1. Configure PHP
   
   Edit the `php.ini` file (mine was located at `/usr/local/etc/php/7.3/php.ini`). Add the following:
   ```text
   [xdebug]
   zend_extension="/usr/local/Cellar/php@7.3/7.3.19/pecl/20180731/xdebug.so"
   xdebug.remote_enable=true
   xdebug.idekey="PHPSTORM"
   ``` 
   Where `zend_extension` is the path to the `xdebug.so` the `pecl` command installed. If `pecl` added
  `zend_extension="xdebug.so"` to the top of the `php.ini`, make sure you delete this line. 

1. Install [Xdebug Browser Extension](https://www.jetbrains.com/help/phpstorm/browser-debugging-extensions.html) in your browser
   
   Once installed, go to the settings for the plugin and set the IDE key to `PHPSTORM`.
   
### Enable Debugging Blade templates

1. In PhpStorm, open the preferences by clicking PhpStorm->Preferences... in the menu bar

1. Go to Languages & Frameworks->PHP->Debug->Templates

1. Expand the "Blade Debug" section

1. Set the cache path to the `storage/framework/views` directory in the project directory

For more details, please see the [JetBrains Help article](https://www.jetbrains.com/help/phpstorm/laravel.html#blade-template-support) on this.

### Starting a debugging session

1. Start your PHP server via `php artisan serve`

1. Go to [http://localhost:8000](http://localhost:8000) in your browser

1. Click on the Xdebug plugin and select "Debug"

1. In PhpStorm, click Run->Start Listening for PHP Debug Connections

Now you should be able to set breakpoints in PhpStorm!

## TODO
This is a hobby app so there are a few things I would like to add:
* Create list of suggested CCC topics that launch a search when clicked
* Look into adding [DataTables](https://www.datatables.net/manual/installation)
* See if we can make seeding faster by eliminating the double query for Question
* Add automated testing
* Migrate to a VUE frontend so that the search does not reload the page
* Take a look at how a Laravel app gets deployed in production. There may be some steps I need to do to remove dev
dependencies.
* Figure out how to cache dependencies so `npm install` and `compose update` don't have to download from the internet
* Figure out mail hosting and enable forgot password and verify email

