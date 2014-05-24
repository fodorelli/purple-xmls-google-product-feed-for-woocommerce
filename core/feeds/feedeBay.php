<?php

  /********************************************************************
  Version 2.0
    An eBay Feed
	By: Keneto 2014-05-08

  ********************************************************************/

require_once 'basicfeed.php';

class PeBayFeed extends PBasicFeed {

  function __construct () {
	$this->providerName = 'eBay';
	$this->providerNameL = 'ebay';
	parent::__construct();
  }

  function formatProduct($product) {
  
	$output.= '
      <Product>';
	$output .= $this->formatLine('Product_Name', $product->title, true);
	$output .= $this->formatLine('Parent_Name', $product->parent_title, true);
	$output .= $this->formatLine('Product_Description', $product->description, true);
	$category = explode(":", $this->current_category);
	if (isset($category[1])) {$this_category = $category[1];} else {$this_category = '';}
	$output .= $this->formatLine('Category', $this_category, true);
	$output .= $this->formatLine('Product_Type', $this_category, true);
	$output .= $this->formatLine('Category_ID', $category[0]);
	$output .= $this->formatLine('Product_URL', $product->link, true);
	$output .= $this->formatLine('Image_URL', $product->feature_imgurl, true);
	$image_count = 0;
	foreach($product->imgurls as $imgurl) {
	  $output .= $this->formatLine('Alternative_Image_URL_' . $image_count++, $imgurl, true);
	}
	$output .= $this->formatLine('Condition', 'New');
	
	if ($product->stock_status == 1) {
	  $product->stock_status = 'in stock';
	} else {
	  $product->stock_status = 'out of stock';
	}
	$output.= $this->formatLine('Stock_Availability', $product->stock_status);
	$output.= $this->formatLine('Original_Price', $product->regular_price . ' ' . $this->currency);
	if ($product->has_sale_price) {
	  $output.= $this->formatLine('Current_Price', $product->sale_price . ' ' . $this->currency);
	}
	$output.= $this->formatLine('Merchant_SKU', $product->sku);

	
	if ($product->weight != "") {
	  $output.= $this->formatLine('Product_Weight', $product->weight);
	  $output.= $this->formatLine('Shipping_Weight', $product->weight);
	  $output.= $this->formatLine('Weight_Unit_of_Measure', $this->weight_unit);
	}
	$output.= $this->formatLine('Shipping_Rate', '0.00 ' . $this->currency);
				
	foreach($product->attributes as $key => $a) {
	  $output .= $this->formatLine($key, $a);
	}
    $output .= '
	  </Product>';
    return $output;
  }

  function getFeedFooter() {
    $output = null;
    $output.= '
  </Products>';
	return $output;
  }

  function getFeedHeader($file_name, $file_path) {
    $output = '<?xml version="1.0" encoding="UTF-8" ?>
  <Products>';
	return $output;
  }

}
?>