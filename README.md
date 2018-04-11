This is an eCommerce work-in-progress project by my partner Brady Zhang (bwz3kt@virginia.edu and bwz3kt on GitHub) and I. Currently, it is an eCommerce website that integrates SQL with HTML and PHP. It is intended to be run with Apache and MySQL via XAMPP. The "purpose" of the site is to establish an online market with a unique product.

To view if XAMPP is installed on your computer: Unzip the file "htdocs.zip" that is on the same filepath as this readme. This would be /eCommerce Project/htdocs.zip, if the top level folder was unzipped normally. Copy the resulting htdocs folder post-unzip, and replace the /xampp/ folder titled "htdocs". Load up XAMPP, and make sure the Apache and MySQL modules are started. Open the web browser, and type in "localhost" (without quotes). 

The functionalities of the site, currently, are:
	Back-end server that stores user data
	Working login system with required field formats (for example, email address check using regex)
	Payment using BitCoin
		Live updating Bitcoin price relative to USD
	Shopping Cart with delete/add functionalities
	Contact Us form using PHPMailer, which is sent to a provided webmaster email
	Differing pages and purchasing functionality restricted to validated/logged in users
