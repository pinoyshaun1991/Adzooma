Adzooma Task
===============================

### How to test
1. Create table in database called adzooma.
2. Run `php artisan migrate` to migrate across the database schema.
3. Run `php artisan serve`. Once navigated to the localhost, you are presented with the default Laravel home page.
4. You are able to register or sign in from the options on the top right of the page.
5. Once logged in a dashboard can be present in which you are able to enter an RSS feed URL.
6. Once the url has been submitted the dashboard then reloads showing the relevant RSS feed content.

*If no classes seem to load please try and run `composer dump-autoload`.  
