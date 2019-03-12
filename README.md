# LAPP-Security-Guide
A guide to securing a LAPP stack in regards to encrypting the PostgreSQL database, installing certificates, protecting against any web attacks, and other hardening techniques

## Setup of the stack
### Install Ubuntu 18.04	
* For the purposes of the manual, we will be using virtual box to install Ubuntu 18.04 into a virtual machine.
  * https://www.ubuntu.com/download/desktop
  * Download Ubuntu 18.04 desktop from here
* If you are installing this on a stand-alone system, create a bootable USB of Ubuntu 18.04
  * Rufus is recommended as the tool of use. Rufus can be downloaded from here:
    * https://rufus.ie/
  * Install Ubuntu on the system in your own way. You can skip the Virtualbox steps
### Virtual box steps:
1. Click "New" on Virtual Box:

![](screenshots/CreateNewVM.JPG)

2. Select your memory (recommended 4GB at least)
3. Create new virtual hard disk (VDI)
   - At least 15GB
4. Now that your VM is allocated, click Settings and click Storage:
   - Highlight the IDE disk controller, and click the CD on the right
   - Navigate to the Ubuntu 18.04 ISO image

![](screenshots/selectcd.JPG)

   
5. Boot your VM, and install Ubuntu

## Installing Apache, PostgreSQL, and PHP

### Install and update the system:
- Update the OS:

	```~$ sudo apt update```
		
- Install Apache:

	```~$ sudo apt install apache2 apache2-utils```
		
- Install PHP:

	```~$ sudo apt install php php-pgsql libapache2-mod-php```
	
- Install PostgreSQL:

	```~$ sudo apt install postgresql postgresql-contrib```

### Install files to correct place:
* Place the php and html files in the directory /var/www/html
* You will get errors if you try and test the page after this step because the database has not been created yet. However, the directory should look like this:

![](screenshots/installfilestocorrectplace.JPG)

### Configure PostgreSQL:
* Switch to the root user and set the password for the postgres user:
	
	```~$ sudo -i -u root```
	
	```~$ passwd postgres```
	

* Switch to the postgres user and perform the following commands to create a new password for the default postgres user's database:
```
~$ psql
psql (10.6 (Ubuntu 10.6-0ubuntu0.18.04.1))
Type "help" for help.
```
	
```postgres=# \password postgres
Enter new password:
Enter it again:
postgres=# \q
```
* Switch back to the user created originally or root, and edit the following config file:
	
	```~$ sudo subl /etc/postgresql/10/main/pg_hba.conf```
	
* Edit the instances that say "peer", and change them to "md5"
  - Your file should look like this:

![](screenshots/peertomd5.JPG)

**Take note of line 86 that has been added. This is to ensure the authentication of any other database users**

It is possible to install phppgadmin at this point to get a visual configuration of your database, but for the rest of this guide, we will be using the command line (psql)

Now that the system is configured, we can create the database

## PostgreSQL Database Creation and Role Configuration

### Create the database and userpass table:

* Create database: 
```
postgres=# CREATE DATABASE "userdb";
CREATE DATABASE
postgres=# GRANT ALL ON DATABASE "userdb" TO postgres;
GRANT
```
* Switch to the database:
```
postgres=# \connect userdb
You are now connected to database "userdb" as user "postgres".
userdb=# 
```
* Create Table:
```	
userdb=# CREATE TABLE userpass (
userdb(# uname VARCHAR (50) UNIQUE NOT NULL PRIMARY KEY,
userdb(# pass VARCHAR (60) NOT NULL
userdb(# );
CREATE TABLE
```
* Add the following constraints to ensure the attributes are configured correctly:
```	
userdb=# ALTER TABLE userpass ADD CONSTRAINT unameLengthCheck CHECK (char_length(uname) >= 3);
ALTER TABLE
userdb=# ALTER TABLE userpass ADD CONSTRAINT pwLengthCheck CHECK (char_length(pass) >= 8);
ALTER TABLE
userdb=# ALTER TABLE userpass ADD CONSTRAINT makeunique UNIQUE (uname);
ALTER TABLE
userdb=# 
```

* Create the users of the database:
  - We want to create two separate users:
    - PhpReader
    - PhpInserter
  - Grant both users the ability to connect to the database, and to use the database:

**BE SURE THAT THE USER NAME DOES NOT HAVE UPPERCASE CHARACTERS**
```	
postgres=# CREATE USER phpreader WITH PASSWORD 'readerPW';
CREATE ROLE
postgres=# CREATE USER phpinserter WITH PASSWORD 'inserterPW';
CREATE ROLE
postgres=# GRANT CONNECT ON DATABASE userdb TO phpreader;
GRANT
postgres=# GRANT CONNECT ON DATABASE userdb TO phpinserter;
GRANT
userdb=# GRANT USAGE ON SCHEMA public TO phpinserter;
GRANT
userdb=# GRANT USAGE ON SCHEMA public TO phpreader;
GRANT
```
* Grant phpReader only the ability to select on the userpass table, and phpInserter only the ability to insert on the userpass table:
```
userdb=# GRANT SELECT ON userpass TO phpreader;
GRANT
userdb=# GRANT INSERT ON userpass TO phpinserter;
GRANT
```
		
		
* Enable pgcrypto:
  - We need to enable pgcrypto so that the crypt function will work in php:
```
postgres=# CREATE EXTENSION pgcrypto;
```

* PHP config switches:
  - Make sure that in the php, the database, user, and password is entered correctly on the connect line:
    - In the create_user.php code:
```$dbconn = pg_connect("dbname=userdb user=phpinserter password=inserterPW");```
    - In the reader_user.php code:
```$dbconn = pg_connect("dbname=userdb user=phpreader password=readerPW");```
		
		
* Restart Postgresql:
		
	```~$ sudo systemctl restart postgresql```

## Testing a User and Password
* Go to 127.0.0.1 in Firefox:

![](screenshots/samplepage.JPG)

* Let's try to Register a new user:
  - Type in the username, and password
  - You should get the following message:
  
![](screenshots/accountcreated.JPG)

* We can check to see if the user is in the table by returning to the login page
* Type in your username and password. If entered correctly, the following message should display:

![](screenshots/authenticated.JPG)

* Let's view the entry in the database
  - Navigate to the database and enter the following query:
  
	```userdb=# Select * from userpass;```

