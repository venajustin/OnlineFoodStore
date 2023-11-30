# CMPE 131 Original Food Store Project

 CMPE 131 - Software Engineering 1 @ SJSU  
 Prof. Butt                               
 Fall Semester 2023                       
 Group 6                                   

---

## Hosting Local Copy
This project was developed using the xampp Apache distribution, but it should run on any php environment. An sql server will need to be hosted to store the database.

If you are hosting on xampp, it is reccomended that you clone this repo into the *htdocs* folder as a subfolder. The [index.php](./index.php) file can be copied into *htdocs* to make the website the default page when going to http://localhost (on windows machines).

In order to access a database you will need to put a file `credentials.php` in the *htdocs* folder as well. Set the variables to the login information for your mysql server.
```php credentials.php
<?php
$hostname = 'yourserver.serverhoster.com';
$dbuser = 'username';
$dbpass = 'password';
$dbname = 'onlinefoodstore';
?>
```
### Databse Setup
[database/tableinfo.sql](./database/tableinfo.sql) contains sql queries to generate all of the required tables for the OnlineFoodStore site to run. Create a new database and run all of the sql scripts included in the file. 
