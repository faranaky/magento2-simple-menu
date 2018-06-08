# Magento Simple Menu

Compatible with Magento 2.1 +

###Installation
* Download zip file
* Extract it
* Put it in app/code/Fary directory on your magento project  
![image](/readme/images/module_directory.png?raw=true)
* Rename it to SimpleMenu
- Go to terminal on magento path and run these commands: 
`php bin/magento setup:upgrade`  
`php bin/magento cache:clean`  


###How it works
After installing module go to admin panel and category management page.  
You can see three new fields have been added to categories:  
![image](/readme/images/category_new_fields.png?raw=true)

If you wish to have your category as menu item same as before, do not touch these fields.  

####Navigation Type
Take a look at navigation type field, it has four options:
* Category
* CMS Page
* Link
* Attribute


##### Category
Creates a category and menu item with the link to that category (same as default category creation)  

##### CMS Page
When you choose this option, another field will be shown that you can select your cms page.
For example if you have about us CMS page and you wish to have it on top menu, you can simply select "CMS Page" as navigation type and then select "About us" from list of pages.

##### Static Link
This option is for when you want to have static link on your top menu no mather it's internal or external.  
Choose static link and another field will be appeared that you can write your address there.  
You need to write entire URL for example: http://faranakyazdanfar.com  
![image](/readme/images/static_link.png?raw=true)

##### Attribute
This option helps you have attribute filter on your topmenu.  
After choosing this option another field become visible which lists all filterable attributes.  
![image](/readme/images/attribute.png?raw=true)  
The link would be created category url filtered by selected attributes.
Let's see the result on frontend:  
![image](/readme/images/front_attributes.png?raw=true)  

There is another case which you choose just one attribute.  
In this case you don't have any extra sub menus the only one is options.  
![image](/readme/images/front_attribute.png?raw=true)  


### Open in New Tab
This field allows you to choose how customers open a link.  
If you set it to "No", current tab will navigate to another link, and if you select "Yes" menu item link will be open in a new tab.


### Mega Menu
When you set "Yes" to mega menu field, another field will be shown as "Mega Menu Block" which allows you to add image to your menu.  
![image](/readme/images/mega_menu.png?raw=true)  
And the result is:  
![image](/readme/images/front_mega_menu.png?raw=true)  

###Useful Information
- This module works with virtual categories as well.
- If you are frontend developer you can find each menu item has sufficient classes for having best experience of styling this menu.  

###### Help
If you need help please contact `yazdanfar.faranak@gmail.com`.

 



