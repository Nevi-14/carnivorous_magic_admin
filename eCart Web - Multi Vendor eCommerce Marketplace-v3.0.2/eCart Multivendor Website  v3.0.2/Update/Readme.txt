--------------------------------------
	eCart Multivendor Web by WRTeam
---------------------------------------
Thanks for showing your love & support
---------------------------------------

Read this before you UPDATE ( Auto Update ) the system code from older version
to newer version than this is for you.
-----------------------------------------------------------------------
Common Steps to update the system from older version to newer version
-----------------------------------------------------------------------
1. Download the updated code from the codecanyon.net
2. Find and locate the 'update' folder
3. upload this 'update' folder into your eKart's website's main directory
	
	For example : If your ekart website is inside `public_html/` 
					and your panel URL is webekart.wrteam.in
		than update folder should be uploaded like
			`public_html/update/`
		
4. Now open the just uploaded 'update' folder from any of the browser
	For example : webekart.wrteam.in/update/
	( If you can see the auto update page than folder is uploaded successfully )
5. Now click on 'Update Now to v X.X' button. You'll be asked to confirm the update. Click 'OK'.
6. And That's all your system updated successfully to latest version.

	Note : Please use this Auto Update script only to upgrade your system to the next version only. 
	If you've missed more than one of the updates than do not directly use this script. Find all previous Auto update scripts and 
	update each version one by one.

________________________________________________________________________________________________________________________


Still, Have a query or questions visit our site now?
https://wrteam.in

	--> please change firebase script code in footer.blade.php file
		file path : resources/views/themes/eCart/common/footer.blade.php
		
	--> please change jwt_secret_key in ekart.php
		file path : config/ekart.php
		
	--> if website break, please replace vendor folder in root directory


Thanks regards
