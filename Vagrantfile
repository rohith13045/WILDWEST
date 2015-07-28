# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
#Initial system CONFIG, we roll ubuntu
  config.vm.box = "ubuntu/trusty64"
  config.vm.box_check_update = true
	#Set these to your home dev directories for app
	WIN_DEVDIR     = "C:\\WildWest\\dev"
	MAC_DEVDIR     = "~/dev/ww"
	NIX_DEVDIR     = "~/dev/ww"

#OS Module
module OS
    def OS.windows?
        (/cygwin|mswin|mingw|bccwin|wince|emx/ =~ RUBY_PLATFORM) != nil
    end

    def OS.mac?
        (/darwin/ =~ RUBY_PLATFORM) != nil
    end

    def OS.unix?
        !OS.windows?
    end

    def OS.linux?
        OS.unix? and not OS.mac?
    end
end

  #private network
  config.vm.network "private_network", ip: "192.168.10.10"  #wild west web

  # public network, change this to the name of your network adaptor.
  config.vm.network "public_network", bridge: 'Intel(R) Dual Band Wireless-AC 7260', ip: "dhcp"


if OS.windows?
 
config.vm.synced_folder $WIN_DEVDIR, "/var/www/wildwest.local", :owner => 'vagrant', :group => 'www-data', :mount_options => ['dmode=777,fmode=774']

elsif OS.mac?

    config.vm.synced_folder $MAC_DEVDIR, "/var/www/wildwest.local", :owner => 'vagrant', :group =>'www-data', :mount_options => ['dmode=777,fmode=774']

elsif OS.unix?

    config.vm.synced_folder $NIX_DEVDIR, "/var/www/wildwest.local", :owner => 'vagrant', :group =>'www-data', :mount_options => ['dmode=777,fmode=774']

elsif OS.linux?
  
    config.vm.synced_folder $NIX_DEVDIR, "/var/www/wildwest.local", :owner => 'vagrant', :group =>'www-data', :mount_options => ['dmode=777,fmode=774']

else
    puts "Vagrant on unknown platform."
end



  config.vm.provider "virtualbox" do |vb|
     vb.gui    = false
     vb.memory  = 2048
     vb.cpus    = 4
  end


end
