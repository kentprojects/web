#!/usr/bin/env bash
#
# @author: James Dryden <james.dryden@kentprojects.com>
# @license: Copyright KentProjects
# @link: http://kentprojects.com
#

locale-gen en_GB.UTF-8

apt-get update
apt-get install -y apache2

if [ "$?" != "0" ]; then
	echo "Something went wrong trying to install the packages. Aborting."
	exit 1
fi

apt-get autoremove -y

ln -s /vagrant /srv/kentprojects

rm /etc/apache2/sites-enabled/*
ln -s /srv/kentprojects/vagrant/apache.conf /etc/apache2/sites-enabled/10-KentProjects.conf
service apache2 restart