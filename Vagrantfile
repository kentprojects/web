#
# @author: James Dryden <james.dryden@kentprojects.com>
# @license: Copyright KentProjects
# @link: http://kentprojects.com
#
# -*- mode: ruby -*-
# vi: set ft=ruby :
Vagrant.configure("2") do |config|
	config.vm.box = "kentprojects/web"
	config.vm.provider "virtualbox" do |v, override|
		override.vm.box = "ubuntu/trusty64"
		v.name = "kentprojects-web"
	end
	config.vm.provider "parallels" do |v, override|
		override.vm.box = "puphpet/ubuntu1404-x64"
		v.name = "kentprojects-web"
	end
	config.vm.hostname = "kentprojects"
	config.vm.network "forwarded_port", guest: 80, host: 8080
	config.vm.provision "shell", path: "vagrant/provision.sh"
end
