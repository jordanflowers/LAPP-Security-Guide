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
	```root@jjf3f-VirtualBox:~$```
	```~$ passwd postgres```
	

* Switch to the 
