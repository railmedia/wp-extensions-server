<p align="center"><a href="https://www.cloudweb.ch" target="_blank" rel="noopener noreferrer"><img src="https://www.cloudweb.ch/wp-content/uploads/2023/02/cloudweb-10-jahre-logo.webp" width="400" alt="Laravel Logo" /></a></p>

## About the extensions server

Based on Laravel 10, the extensions server aims at providing a UI and wrapper for a custom WordPress extensions updates system. It provides a friendly interface along with user management. It also includes a requests manager, that is, sites that are requesting updates from the server, get logged in the database.

## Requirements

- PHP 8.2;
- MySQL;
- NodeJS 18+.

## Installation

- Copy repository to your server or local environment;
- Create a database to use with the app;
- Create an .env file based on the .env.example file;
- Run composer install;
- Run npm install;
- Run php artisan migrate;
- Run php artisan optimize;
- Run php artisan db:seed --class=FirstAdminSeeder

## Usage

- Login with email <strong>admin@admin.com</strong> and password <strong>password</strong>
- Navigate to /profile and change your password.
- /extensions/ - add extensions. Click Add extension to begin and add the details.
- /extensions/{extension_id}/upload - upload the extension file. ZIP files allowed only.
- /extensions/{extension_id}/manifest - create the manifest for your extension. The manifest is based on the following [template](https://gist.github.com/railmedia/ac5bb57a506dd27c9f225fd21eecb398)
- The manifest section is where you will change the version and trigger an update on the sites using your extension.
- /users section allows you to create admin users for the app.
- /requests section allows you to view and search for requests from remote sites.

## Configuring WordPress extensions (themes or plugins)

- In your extension add a file similar to [this file](https://gist.github.com/railmedia/3326fd650981fbacc2c272c12d947276)
- Make sure you replace the plugin slug and server URL to your own.

## About Us

- [cloudWEB GmbH](https://www.cloudweb.ch/agentur/)
