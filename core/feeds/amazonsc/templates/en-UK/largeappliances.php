<?php
	//********************************************************************
	//UK Amazon Seller Template
	//2015-02
	//********************************************************************

/*** Basic ***/
	//Beer,Beverages,Food,Spirits,Wine
	$this->addAttributeMapping('feed_product_type', 'feed_product_type',true,true)->localized_name = 'Product type';
	$this->addAttributeMapping('', 'model',true,false)->localized_name = 'Model Number';
	
/** Offer **/
	//Indicates how many items are in the package.  For example, a box of 12 health bars, each of which can be sold individually, would have a count of 12.
	$this->addAttributeMapping('', 'item_package_quantity',true,false)->localized_name = 'Package Quantity'; 
	$this->addAttributeMapping('regular_price', 'standard_price',true,true)->localized_name = 'Standard Price';
	$this->addAttributeMapping('currency', 'currency',true,true)->localized_name = 'Currency';  //GBP
	$this->addAttributeMapping('quantity', 'quantity',true,true)->localized_name = 'Quantity';
	$this->addAttributeMapping('condition', 'condition_type',true,false)->localized_name = 'Condition Type'; 

/*** Some more preferred/optional attributes ***/
	$this->addAttributeMapping('', 'voltage',true,false)->localized_name = 'Voltage';  
	$this->addAttributeMapping('', 'wattage',true,false)->localized_name = 'Wattage';
	//$this->addAttributeMapping('', 'size_map',true,false)->localized_name = 'Wig Length';  
	//$this->addAttributeMapping('', 'item_gender',true,false)->localized_name = 'Item gender'; 

?>