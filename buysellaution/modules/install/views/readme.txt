/////////////////////////////////
///  Ndot Auction V1.1.x       ///
///  Install Instructions     ///
///  http://www.ndot.in      ///
////////////////////////////////


NOTE: THIS IS FOR NEW INSTALL ONLY!
IF UPGRADING YOUR EXISTING AUCTION SCRIPT, BE SURE TO READ THE UPGRADE.TXT FILE INSTEAD


-------
INSTALL
-------

1. Upload all the files and folders to your server from the required folder.
   This can be to anywhere of your choice.(root or subfolders)
2. If you are using localhost please update your base url in application/bootstrap.php 

Eg: File configured /var/www/development means give development as base URL.
Before Changes:

Kohana::init(array(
'base_url'   => '/','index_file' => FALSE ,
)); 

After Changes: 

Kohana::init(array(
'base_url'   => '/development/','index_file' => FALSE ,

)); 


3. If you have a Linux/Unix make sure the following folders and files are writable.
   chmod 0755 or 0777 application/cache
   chmod 0755 or 0777 application/logs
   chmod 0755 or 0777 application/config
   chmod 0755 or 0777 application/classes
   chmod 0755 or 0777 public/uploaded_files
   chmod 0755 or 0777 public/uploaded_files/products
   chmod 0755 or 0777 public/uploaded_files/users
   chmod 0755 or 0777 public/uploaded_files/site_logo
   chmod 0755 or 0777 public/uploaded_files/banner
   chmod 0755 or 0777 public/uploaded_files/testimonials


4. Make sure you have installed a MySQL Database which has a user assigned to it 
   DO NOT USE YOUR ROOT USERNAME AND ROOT PASSWORD

5.Run on your browser like http://yourhostname/

6. Follow the onscreen instructions.

7. Delete or Rename the application/classes/install.php install file after install is succesfully complete.

8. Hide or Delete the line 'install' => MODPATH.'install' in bootstrap.php.
   Eg:
   Before Changes: 
Kohana::modules(array(
'auth'       => MODPATH.'auth',       // Basic authentication
'commonfunction'  => MODPATH.'commonfunction', //common function added as module
'install' => MODPATH.'install', //for installation
   ));
   After changes:
Kohana::modules(array(
'auth'       => MODPATH.'auth',       // Basic authentication
'commonfunction'  => MODPATH.'commonfunction', //common function added as module
   ));

9. Visit our Demo homepage
   e.g. http://best-auction-software.com/ or http://best-auction-software.com/admin/login
   
For Developers support please contact velayutham.j@ndot.in

EOF
