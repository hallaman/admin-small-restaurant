admin-sunflowercafe
===================

A small content management system for a restaurant website. This system is no longer in use, publically. 

The system allows a user to edit daily menu items and update the activities page. The updated activities page can be found at /activities.php. The file /to-go.php uses a javascript plugin (js/jquery-price-calculator-pro.js) to place orders, whose payment is sent using PayPal's API (disabled). The daily menu items for the current week can be perused on /to-go.php by clicking on the days listed in the list at the top of the page.

A MAMP setup was used to create this system. Open includes/dblib.php to edit the database settings. The db schema is included, which establishes a test login - username: test@gmail.com, password: test. The primary functions can be found in includes/lib.php.



