<?php

function cloud_init($php_version="5.4"){

if ($php_version=="5.4"){
exec_script("sudo cloud-init php54atualizado");
}

if ($php_version=="5.5"){
exec_script(" sudo add-apt-repository ppa:ondrej/php5
 sudo apt-get update");
} 

//pacotes
exec_script("
    sudo apt-get -y install apache2 libapache2-mod-php5 php5-mysql php5-mcrypt lynx lynx-cur php5-curl php5-dev php5-gd php5-mcrypt php5-memcache php5-memcached php5-mysql 
    sudo a2enmod ssl
    sudo a2enmod rewrite
    sudo apt-get -y install apachetop
    sudo apt-get -y install firebird2.1-super subversion git-core php5-interbase   
    sudo rm /etc/php5/conf.d/timezone.ini
    sudo mkdir /home/session;sudo chmod -R 777 /home/session");
    time_zone();
	

// ####################################################################################    
// ###### COMENTADO POIS O XDEBUG N�O FUNCIONA OS BREAKPOINTS     #####################
// ###### ENTRANDO NAS FUN��ES COM ALGUMA EXTENS�O DE CACHE ATIVA #####################
//eaccelerator
//exec_script("sudo cloud-init eaccelerator");
// ####################################################################################
    
//git clone
//exec_script("cd /home; sudo git clone git@github.com:Superlogica/cloud.git"); 
//firewall
exec_script("
         sudo ufw reset
         sudo ufw allow ssh
         sudo ufw allow http
         sudo ufw allow https
         sudo ufw enable");



//ativar app no apache
if ($php_version=="5.5")
	exec_script("sudo rm /etc/apache2/sites-enabled/*; sudo ln -s /home/cloud/conf/cloud.superlogica.com_php55 /etc/apache2/sites-enabled/001cloud.conf");
else
	exec_script("sudo rm /etc/apache2/sites-enabled/*; sudo ln -s /home/cloud/conf/cloud.superlogica.com /etc/apache2/sites-enabled/001cloud");

 exec_script("sudo rm -Rf /var/www
            sudo ln -s /home/cloud  /var/www
            sudo cloud-init cloudini
            sudo cloud-init phpini
            sudo bash /home/cloud/conf/deploy.sh
            sudo chmod -R 777 /home/cloud/var
            sudo chmod -R 777 /home/cloud/public/scripts/min
			update-rc.d apache2 defaults
         ");
 
 
 //cloud.lock
@unlink("/home/cloud/cloud.lock");

  //deploy_action("cloud");
  apache_tunning();

}
