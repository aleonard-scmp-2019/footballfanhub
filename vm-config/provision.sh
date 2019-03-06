#!/usr/bin/env bash

################################################################################
# Vagrant LAMP server provisioning script
#
# This script is designed to be used in conjunction with Vagrant
# to create and configure a LAMP server VM.
################################################################################

################################################################################
# Settings (Modify these values to customize your setup.)
################################################################################
# MySQL
MYSQL_ROOT_PASSWD="vagrant"
MYSQL_DB_NAME="wordpress"
MYSQL_USERNAME="wordpress"
MYSQL_USER_PASSWD="password"

# Apache
APACHE_WORDPRESS_VHOST_FILENAME="wordpress_apache_vhost"
APACHE_HTML_VHOST_FILENAME="html_apache_vhost"
APACHE_ENABLE_REWRITE=true

# Default Vagrant shared folder
VAGRANT_SHARE_PATH="/vagrant"

MYSQL_DEV_BACKUP="/vagrant/db/2019-01-18.sql.gz"

# Website install paths
DEFAULT_SITE_PATH="/var/www/wordpress/www"
INSTALLED_SITE_PATH="/opt/website"
# Website HTML install paths
DEFAULT_HTML_SITE_PATH="/var/www/wordpress/html"
INSTALLED_HTML_SITE_PATH="/opt/html"

mkdir /var/www
mkdir /var/www/wordpress
mkdir /var/www/wordpress/html
mkdir /var/www/wordpress/www

# User settings
APACHE_USER="www-data"
VM_USER="vagrant"

################################################################################
# Helper functions
################################################################################
function echo_done_or_failed {
    if [ $? -eq 0 ]; then
        echo "   ...done."
    else
        echo "   ...failed."
    fi
}

################################################################################
# Preparation
################################################################################
echo "Updating package cache..."
apt-get update -qq
echo_done_or_failed

################################################################################
# MySQL
################################################################################

# Preseed answers for the MySQL install.
debconf-set-selections <<EOF
mysql-server-5.6 mysql-server/root_password password $MYSQL_ROOT_PASSWD
mysql-server-5.6 mysql-server/root_password_again password $MYSQL_ROOT_PASSWD
EOF

echo "Installing MySQL..."
apt-get install -qq -y mysql-server
echo_done_or_failed


# Create database.
if [ ! -z "$MYSQL_DB_NAME" ]; then
    echo "Creating database $MYSQL_DB_NAME..."
    mysql -u root -p"$MYSQL_ROOT_PASSWD" <<EOF
CREATE DATABASE $MYSQL_DB_NAME;
EOF
    echo_done_or_failed
fi

# Create user.
if [ ! -z "$MYSQL_USERNAME" ]; then
    echo "Creating database user $MYSQL_USERNAME..."
    mysql -u root -p"$MYSQL_ROOT_PASSWD" <<EOF
CREATE USER '$MYSQL_USERNAME'@'localhost' IDENTIFIED BY '$MYSQL_USER_PASSWD';
EOF
    echo_done_or_failed

    echo "Creating database user permissions..."
    mysql -u root -p"$MYSQL_ROOT_PASSWD" <<EOF
GRANT ALL PRIVILEGES ON $MYSQL_DB_NAME.* TO '$MYSQL_USERNAME'@'localhost';
EOF
    echo_done_or_failed
fi

################################################################################
# Apache
################################################################################
echo "Installing Apache..."
apt-get install -qq -y apache2
echo_done_or_failed

# Use customized vhost.
if [ ! -z "$APACHE_WORDPRESS_VHOST_FILENAME" ]; then
    cp "$VAGRANT_SHARE_PATH/vm-config/$APACHE_WORDPRESS_VHOST_FILENAME" /etc/apache2/sites-available/wordpress.test.conf
    a2ensite "wordpress.test"
fi
# Use customized vhost.
if [ ! -z "$APACHE_HTML_VHOST_FILENAME" ]; then
    cp "$VAGRANT_SHARE_PATH/vm-config/$APACHE_HTML_VHOST_FILENAME" /etc/apache2/sites-available/html.wordpress.local.conf
    a2ensite "html.wordpress.local"
fi

# Enable mod_rewrite
if $APACHE_ENABLE_REWRITE ; then
    echo "Enabling Apache rewrite module..."
    a2enmod rewrite
    service apache2 restart
    echo_done_or_failed
fi

################################################################################
# PHP
################################################################################
echo "Installing PHP..."
apt-get install -qq -y php libapache2-mod-php
apt-get install -qq -y php-mysql php-curl php-gd php-intl php-pear php-imagick php-imap php-mcrypt php-memcache php-ming php-ps php-pspell php-recode php-snmp php-sqlite php-tidy php-xmlrpc php-xsl php-xdebug
echo_done_or_failed

################################################################################
# Site Setup
################################################################################
# Use symlinks to map custom files into the correct locations.
rm -rf "$DEFAULT_SITE_PATH"
ln -s "$INSTALLED_SITE_PATH" "$DEFAULT_SITE_PATH"

rm -rf "$DEFAULT_HTML_SITE_PATH"
ln -s "$INSTALLED_HTML_SITE_PATH" "$DEFAULT_HTML_SITE_PATH"

# Permissions
usermod -aG "$APACHE_USER" "$VM_USER"
chown -R "root:root" "$INSTALLED_SITE_PATH"
chown -R "$APACHE_USER:$APACHE_USER" "$INSTALLED_SITE_PATH/wp-content"
chown -R "$APACHE_USER:$APACHE_USER" "$INSTALLED_SITE_PATH/.htaccess"
chown -R "$APACHE_USER:$APACHE_USER" "$INSTALLED_HTML_SITE_PATH"

# Restoring database from dev backup if available
if [ ! -z "$MYSQL_DEV_BACKUP" ]; then
    zcat $MYSQL_DEV_BACKUP | mysql -u $MYSQL_USERNAME -p$MYSQL_USER_PASSWD $MYSQL_DB_NAME
fi


################################################################################
# PhpMyAdmin
################################################################################
# Install and link phpmyadmin to vagrant box
# echo "Installing phpmyadmin..."
# sudo apt-get install phpmyadmin
# sudo ln -s /usr/share/phpmyadmin/ /opt/website/phpmyadmin
# echo_done_or_failed


# Restart apache
service apache2 restart
