##The Wild West Framework - Quick as a whip PHP development##
Version: Very Alpha, 0.1a
###Overview###

To get started, cd to your wild west directory and open up Vagrantfile and edit according
to your development environment, then vagrant up. For more information on Vagrant,
please visit http://docs.vagrantup.com/v2/vagrantfile/

After you have your vagrant box up, you can now run make buildconfig from
the wildwest root directory. It will ask you a few questions such as
database hostname, user, pass and db, so have those handy. This will
generate the config.core.php file needed to run wild west framework.