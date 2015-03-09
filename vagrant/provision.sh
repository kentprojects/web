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

patch /etc/apache2/envvars <<'EOT'
--- envvars     2014-01-03 14:48:41.000000000 +0000
+++ envvars.tmp        2015-03-02 16:11:44.851129129 +0000
@@ -13,8 +13,8 @@
 # Since there is no sane way to get the parsed apache2 config in scripts, some
 # settings are defined via environment variables and then used in apache2ctl,
 # /etc/init.d/apache2, /etc/logrotate.d/apache2, etc.
-export APACHE_RUN_USER=www-data
-export APACHE_RUN_GROUP=www-data
+export APACHE_RUN_USER=vagrant
+export APACHE_RUN_GROUP=vagrant
 # temporary state file location. This might be changed to /run in Wheezy+1
 export APACHE_PID_FILE=/var/run/apache2/apache2$SUFFIX.pid
 export APACHE_RUN_DIR=/var/run/apache2$SUFFIX
EOT
chgrp -R vagrant /var/log/apache2
rm /etc/apache2/sites-enabled/*
ln -s /vagrant/vagrant/apache.conf /etc/apache2/sites-enabled/10-KentProjects.conf
service apache2 restart