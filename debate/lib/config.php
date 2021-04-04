<?php

/** 

myTalk © Arek Der-Sarkissian. All rights reserved.

This software is provided AS IS, meaning that, while I'm nice and will provide support, I'm not liable for anything.
Other than that, welcome to the future of debate booking and collaboration.

Please configure the variables below to begin using your installation.

*/


# MySQL host
$config['db']['host']='127.0.0.1';

# MySQL port (keep same for default)
$config['db']['port']=3306;

# Database name
$config['db']['name']='mytalk';

# MySQL user
$config['db']['user']='';

# MySQL password
$config['db']['pass']='';

# Email host (must be SMTP)
$config['email']['host']='';

# Email address
$config['email']['address']='';

# Email username
$config['email']['username']='';

# Email password
$config['email']['password']='';

# Email port (keep same for tls)
$config['email']['port']=587;

# Email type (tls/ssl/none)
$config['email']['type']='tls';

# Root administrators are set here (use user IDs, separate by commas)
$config['admins']='1';

# Code for staff members
$config['code']='';

# This is where you want people to contact you
$config['support']='';

# reCaptcha site key (needed for registrations)
$config['recaptcha']['sitekey']='';

# reCaptcha secret key, get both as the INVISIBLE kind from https://www.google.com/recaptcha
$config['recaptcha']['secret']='';







# DO NOT TOUCH THIS
$version['id']='the public';
