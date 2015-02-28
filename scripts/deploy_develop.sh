#!/bin/sh
#
# @author: James Dryden <james.dryden@kentprojects.com>
# @license: Copyright KentProjects
# @link: http://kentprojects.com
#
ssh kentprojects@kentprojects.com <<'ENDSSH'
cd /var/www/kentprojects-web-dev && sudo -u www-data git pull
ENDSSH