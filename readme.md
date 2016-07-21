#payload

i have try `GitLab` & `GitHub`, both can get payload in HTTP POST from remote by

	$payload = file_get_contents('php://input');
	#parse object/array base on second parameter false/true
	$payloadObj = json_decode($payload, true);

#www-data

when clone project, there are 2 types:

1. HTTPS

2. SSH

/var/www/.ssh, generate `ssh` without *passphrase*

	ssh-keygen -b 2048 -t rsa -f /var/www/.ssh/id_rsa -q -N ""

now look into /var/www/.ssh, `ls -la`

	+ id_rsa
	+ id_rsa.pub
 
[for safe] check *mod* of `id_rsa`, auto-deploy not work when id_rsa too open (chmod 0400|0600 is ok)

#permission

	chown -R www-data:www-data * on any file in /var/www

manually for .git
	
	chown -R www-data:www-data /var/www/:project/.git

#command
to git pull, only shell_exec|exec

	git pull origin master
	@WARN: "sudo -u www-data git pull origin master" is a STUPID command

if GitLab|Github config right, everything will work fine






