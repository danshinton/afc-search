# Apostolate's Family Catechism Lookup
This app takes a list of paragraphs from the Catechism of the Catholic Church (CCC) and determines the corresponding
questions in the Apostolate's Family Catechism (AFC).

## Running the app
This application uses the Laravel v7.17 framework, so it can be run a number of ways.

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

## Debugging SQL

If you want to know what SQL is being executed by Eloquent, add the following code in the method
making the call, just above the SQL query:

```php
DB::listen(function($sql) {
    Log::info($sql->sql);
    Log::info($sql->bindings);
    Log::info($sql->time);
});
```

Don't forget the imports:

```php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
```

This will log SQL queries to `storage/logs/laravel.log`.

## Deploying to Heroku

### Initial setup

This only has to be done once to install the app on [Heroku](https://www.heroku.com/). For these examples, I am assuming that you
have already created a new Hobby Dyno on Heroku called `afc-search` which is configured to auto-build when you
push to the `heroku` git branch. Also, I am assuming that you have created a [SendGrid](https://sendgrid.com/) account.

1. Install the [Heroku CLI](https://devcenter.heroku.com/categories/command-line) and authenticate
   ```shell script
   brew tap heroku/brew && brew install heroku
   heroku login
   ```

1. Tell the Heroku CLI which app to use
   ```shell script
   export HEROKU_APP=afc-search
   ```

1. Install the build packs
   ```shell script
   heroku buildpacks:add heroku/nodejs
   heroku buildpacks:add heroku/php
   ```
   This will run the `npm` and `php composer` commands to build the app

1. Install PostgreSQL
   ```shell script
   heroku addons:create heroku-postgresql:hobby-dev
   ```
   PostgreSQL is used because Heroku does not support sqlite. Take note of the database URL it gives you.

1. Configure SendGrid
   * Create [an API Key](https://app.sendgrid.com/settings/api_keys) for the `afc-search` application
   * Review the Laravel variables in the `.env.production` file to ensure they match
     [SendGrid's recommendations](https://sendgrid.com/docs/for-developers/sending-email/laravel/)
     * Note: If you need to override variables in the `.env.production` file (e.g. `MAIL_FROM_ADDRESS`), you
       don't need to edit that file. Just use `config:set` commands in the next step.
   * Make sure you have [verified the email address](https://sendgrid.com/docs/ui/sending-email/sender-verification)
     you will be using for the `MAIL_FROM_ADDRESS`. 

1. Configure dyno environment 
   ```shell script
   heroku config:set APP_ENV=production
   heroku config:set LOG_CHANNEL=stderr
   heroku config:set DATABASE_URL=<The Database URL from above>
   heroku config:set MAIL_PASSWORD=<The SendGrid API Key created above>
   ```
   
1. Configure domain
   
   Assuming we want to expose our app as `afc.shinton.net`:
   ```shell script
   heroku domains:add afc.shinton.net 
   ```
   Take note of the DNS target it produces. On the `shinton.net` domain, add a new `CNAME` record for `afc`
   with that target.

1. Push what is on `master` to the `heroku` branch
   ```shell script
   git pull
   git checkout heroku
   git rebase origin/master
   git push
   ```
   This will automatically trigger Heroku to build and deploy the new dyno.

1. Initialize the database
   Check to see if the app is done deploying by going to app webpage, monitoring the deploy log on the activity
   tab of the dashboard, or using the `heroku releases` to see if the new release is deployed. Once the dyno
   is deployed, do the following:
   
   ```shell script
   heroku run bash
   php artisan migrate
   php artisan db:seed
   exit
   ```

The application should be up and available at [https://afc.shinton.net](https://afc.shinton.net).

### Deploying App Updates

1. Push what is on `master` to the `heroku` branch
   ```shell script
   git pull
   git checkout heroku
   git rebase origin/master
   git push
   ```
   This will automatically trigger Heroku to build and deploy the new dyno.

### Useful Heroku CLI commands
If you don't have the `HEROKU_APP` environment variable set, then you will have to use the `-a <appname>` paramater
for all the Heroku CLI calls.

| Command                   | Description                 |
|---------------------------|-----------------------------|
| `heroku dyno:restart web` | Restart web app             |
| `heroku run bash`         | Get a shell on the app dyno |
| `heroku logs`             | View app logs               |

## TODO
This is a hobby app so there are a few things I would like to add:
* Create a downloading landing page with a link back to the main interface
* Add [testing](https://laravel.com/docs/7.x/testing) for search
* Migrate to a VUE frontend so that the search does not reload the page
* Figure out how to cache dependencies so `npm install` and `compose update` don't have to download from the internet
