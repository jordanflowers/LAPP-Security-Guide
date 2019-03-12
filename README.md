# LAPP-Security-Guide
A guide to securing a LAPP stack in regards to encrypting the PostgreSQL database, installing certificates, protecting against any web attacks, and other hardening techniques

## Setup of the stack
	### Install Ubuntu 18.04	
	* For the purposes of the manual, we will be using virtual box to install Ubuntu 18.04 into a virtual machine.
	* https://www.ubuntu.com/download/desktop
		○ Download Ubuntu 18.04 desktop from here
	* If you are installing this on a stand-alone system, create a bootable USB of Ubuntu 18.04
		○ Rufus is recommended as the tool of use. Rufus can be downloaded from here:
			§ https://rufus.ie/
		○ Install Ubuntu on the system in your own way. You can skip the Virtualbox steps
	### Virtual box steps:
	1. Click "New" on Virtual Box:
!["Create new VM"](screenshots/CreateNewVM.jpg)
