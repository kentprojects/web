#!/usr/bin/env sh
#
# @author: James Dryden <james.dryden@kentprojects.com>
# @license: Copyright KentProjects
# @link: http://kentprojects.com
#
locale-gen en_GB.UTF-8

apt-get update &&
apt-get install -y apache2 &&
apt-get install -y php5 php5-cli php5-curl php5-json

if [ $? -gt 0 ]; then
	echo "Something went wrong trying to install the packages. Aborting."
	exit 1
fi

apt-get autoremove -y

rm /etc/apache2/sites-enabled/*
ln -s /vagrant/vagrant/apache.conf /etc/apache2/sites-enabled/10-KentProjects.conf
service apache2 restart