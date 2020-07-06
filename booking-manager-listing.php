<?php
/*
Plugin Name: Bokking Manager Listing
Plugin URI: #
Description: Used by millions, to add cutom dealboxes to any WordPress ecommerce site, as a cusotm Slider Collapse on frontend.
Version: 4.1.2
Author: Naeem Ahmed Junejo
Author URI: http://naeem.capitalsofttech.com/
License: GPLv2 or later
Text Domain: booking-manager-listing
*/




function dsc_register_boats_type() {
	
	    $labels = array( 
	        "name" 					=> "Boats",
	        "description" 			=> "",
	        "singular_name" 		=> "Boat",
	        "add_new" 				=> "Add Boat",
	        "add_new_item" 			=> "Add New Boat",
	        'edit' 					=> "Edit",
	        "edit_item" 			=> "Edit Boat",
	        "new_item" 				=> "New Boat",
	        "view" 					=> "View",
	        "view_item" 			=> "View Boat",
	        "search_items" 			=> "Search Boat",
	        "not_found" 			=> "No Boat found",
	        "not_found_in_trash" 	=> "No Boat found in Trash",
	        "parent" 				=> "Parent Boat:"
	    );
	
	    $args = array(
	        "labels" 				=> $labels,
	        "has_archive" 			=> false,
	        "menu_icon" 			=> "dashicons-media-text",
	        "menu_position"			=> 5,
	        "hierarchical" 			=> true,
	        "public" 				=> true,
	        "show_ui" 				=> true,
	        "show_in_menu" 			=> true,
	        "show_in_nav_menus" 	=> false,
	        "publicly_queryable" 	=> true,
	        "query_var" 			=> true,
	        "exclude_from_search"	=> false,
	        "can_export" 			=> true,
	        "capability_type"		=> "page",
	        "taxonomies" 			=> array(),
	        "rewrite" 				=> false,
			"supports" 				=> array( "title", "thumbnail" ),
	    );
	
	    register_post_type( "boat", $args );
	    
	}
	
	add_action( "init", "dsc_register_boats_type" );



class MySettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_submenu_page(
	    'edit.php?post_type=boat',
	    __( 'Settings Admin', 'menu-test' ),
	    __( 'API Settings', 'menu-test' ),
	    'manage_options',
	    'my-setting-admin',
	     array( $this, 'create_admin_page' )
	);
        
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <h1>Booking Manager API Settings</h1>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'my-setting-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'My Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

            

        add_settings_field(
            'api_url', 
            'API Url', 
            array( $this, 'api_url_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );  
         add_settings_field(
            'user_id', 
            'User Id', 
            array( $this, 'user_id_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );
         add_settings_field(
            'username', 
            'Username', 
            array( $this, 'username_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );  
         add_settings_field(
            'password', 
            'Password', 
            array( $this, 'password_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );  
         add_settings_field(
            'company_id', 
            'Company Id', 
            array( $this, 'company_id_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );         
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
       

        if( isset( $input['user_id'] ) )
            $new_input['user_id'] = sanitize_text_field( $input['user_id'] );

         if( isset( $input['api_url'] ) )
            $new_input['api_url'] = sanitize_text_field( $input['api_url'] );
         
         if( isset( $input['username'] ) )
            $new_input['username'] = sanitize_text_field( $input['username'] );
        
         if( isset( $input['password'] ) )
            $new_input['password'] = sanitize_text_field( $input['password'] );
         
         if( isset( $input['company_id'] ) )
            $new_input['company_id'] = sanitize_text_field( $input['company_id'] );
 
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
   

    /** 
     * Get the settings option array and print one of its values
     */
    public function user_id_callback()
    {
        printf(
            '<input type="text" id="user_id" name="my_option_name[user_id]" value="%s" />',
            isset( $this->options['user_id'] ) ? esc_attr( $this->options['user_id']) : ''
        );
    }
     public function company_id_callback()
    {
        printf(
            '<input type="text" id="company_id" name="my_option_name[company_id]" value="%s" />',
            isset( $this->options['company_id'] ) ? esc_attr( $this->options['company_id']) : ''
        );
    }
     public function api_url_callback()
    {
        printf(
            '<input type="text" id="api_url" name="my_option_name[api_url]" value="%s" />',
            isset( $this->options['api_url'] ) ? esc_attr( $this->options['api_url']) : ''
        );
    }
     public function username_callback()
    {
        printf(
            '<input type="text" id="username" name="my_option_name[username]" value="%s" />',
            isset( $this->options['username'] ) ? esc_attr( $this->options['username']) : ''
        );
    }
     public function password_callback()
    {
        printf(
            '<input type="text" id="password" name="my_option_name[password]" value="%s" />',
            isset( $this->options['password'] ) ? esc_attr( $this->options['password']) : ''
        );
    }
}

if( is_admin() )
    $my_settings_page = new MySettingsPage();

function books_register_ref_page() {
    add_submenu_page(
        'edit.php?post_type=boat',
        __( 'Books Shortcode Reference', 'textdomain' ),
        __( 'Resources Settings', 'textdomain' ),
        'manage_options',
        'booking-manager-ref',
        'books_ref_page_callback'
    );
}

/**
* Display callback for the submenu page.
*/
function books_ref_page_callback() { 
    if( isset($_POST[ 'submit-boat' ]) && $_POST[ 'submit-boat' ]!= '' ){
    	//use this to test iv curl is enabled, if it is not then you should enable it
		//echo 'Curl: ', function_exists('curl_version') ? 'Enabled' : 'Disabled';
		$soap_request = "<soapenv:Envelope
		xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
		xmlns:cbm=\"http://cbm.mmk.com\">\n";
		$soap_request .= "<soapenv:Header/>\n";
		$soap_request .= "<soapenv:Body>\n";
		$soap_request .= " <cbm:getResources>\n";
		$soap_request .= " <cbm:in0>". get_option('my_option_name')['user_id']."</cbm:in0>\n";
		$soap_request .= " <cbm:in1>". get_option('my_option_name')['username']."</cbm:in1>\n";
		$soap_request .= " <cbm:in2>". get_option('my_option_name')['password']."</cbm:in2>\n";
		$soap_request .= " <cbm:in3>". get_option('my_option_name')['company_id']."</cbm:in3>\n";


		$soap_request .= " </cbm:getResources>\n";
		$soap_request .= "</soapenv:Body>\n";
		$soap_request .= "</soapenv:Envelope>\n";
		$header = array(
		"Content-type: text/xml;charset=\"utf-8\"",
		"Accept: text/xml",
		"Cache-Control: no-cache",
		"Pragma: no-cache",
		"SOAPAction: \"run\"",
		"Content-length: ".strlen($soap_request),
		);
		$soap_do = curl_init();
		curl_setopt($soap_do, CURLOPT_URL,  get_option('my_option_name')['api_url']);
		curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($soap_do, CURLOPT_TIMEOUT, 60);
		curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($soap_do, CURLOPT_POST, true );
		curl_setopt($soap_do, CURLOPT_POSTFIELDS, $soap_request);
		curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
		$result = curl_exec($soap_do);
		if($result === false) {
		$err = 'Curl error: ' . curl_error($soap_do);
		curl_close($soap_do);
		//print $err;
		} else {
		curl_close($soap_do);
		$xml_input = $result;
		}
	$xml_input = preg_replace("/(&lt;)/i","<",$xml_input);
$xml_input = preg_replace("/(&#xd;)/i"," ",$xml_input);
$xml_input = preg_replace("/(&gt;)/i",">",$xml_input);
$xml_input = preg_replace('/(<soap:Envelope xmlns:soap="http:\/\/schemas.xmlsoap.org\/soap\/envelope\/" xmlns:xsd="http:\/\/www.w3.org\/2001\/XMLSchema" xmlns:xsi="http:\/\/www.w3.org\/2001\/XMLSchema-instance"><soap:Body><ns1:getResourcesResponse xmlns:ns1="http:\/\/cbm.mmk.com"><ns1:out>)/i',"",$xml_input);
$xml_input = preg_replace("/(<\/ns1:out><\/ns1:getResourcesResponse><\/soap:Body><\/soap:Envelope>)/i","",$xml_input);



   	 $xml=simplexml_load_string($xml_input) ;
  	
   	 $i = 0;
   	 foreach ($xml->resource as $resource) {
   	 	//echo $resource['id'];
   	 	$args = array(
		    // Arguments for your query.
			'post_type'=>'boat',
			 'meta_query'     => array(
			        array(
			            'key'       => '_resource_id',
			            'value'     => (string)$resource['id'],
			            'compare'   => '=='
			        )
			    ),
			
		);
		$query = new WP_Query( $args );
		 if ( $query->have_posts() ) {
		 	
		 }else{
		 	$i++;
		 	foreach ($resource->images->image as $image) {
		 			# code...
		 		 if( $image['comment'] =="Main image" )
		 		 $image_save =  (string)$image['href'];
		 		
		 		}
		 	foreach ($resource->prices->price as $price) {
		 			# code...
		 		$date_from = strtotime((string)$price['datefrom']);
		 		$date_to = strtotime((string)$price['dateto']);
		 		$price = (string)$price['price'];
		 		$currency = (string)$price['currency'];
		 		break;
		 		
		 	}

			$datediff = $date_to - $date_from;

			$days = round($datediff / (60 * 60 * 24));		
		 	$postarr = array( 
		 		//'ID' => 	(string)$resource['id'],
		 		'post_title' =>(string)$resource['name'], 
		 		'post_type' =>'boat',
		 		'post_status' =>'publish',
		 		'meta_input' => array(
						    '_resource_id' => (string)$resource['id'],
						    '_base' => (string)$resource['base'],
						    '_model' => (string)$resource['model'],
						    '_berths' => (string)$resource['berths'],
						    '_cabins' => (string)$resource['cabins'],
						    '_image' => $image_save,

						    '_days' =>$days,
						    '_price' => $price,
						    '_currency' => $currency,



						   
						)
		 	);
		 	//echo print_r($resource->images);
		 	
		 	 wp_insert_post(  $postarr, true );
		 }
   	 }

    }	


    ?>
    <div class="wrap">
        <h1><?php _e( 'Resources Settings', 'textdomain' ); ?></h1>
        <p><?php _e( 'Get Data From Booking Manager API', 'textdomain' ); ?></p>
        <p><?php _e( 'Please make sure you entered the API options in <a href="'.get_bloginfo('home').'/wp-admin/edit.php?post_type=boat&page=my-setting-admin">Api settings Page</a>', 'textdomain' ); ?></p>
        <form action="" method="post">
        	<p>No of Updated Resources: <?php echo $i;?></p>
        	<p><input class="button button-primary" type="submit" value="Update Data" name="submit-boat"></p>
        </form>

    </div>
    <?php
}

add_action("admin_menu","books_register_ref_page");


function global_notice_meta_box() {

    $screens = array( 'boat' );

	    foreach ( $screens as $screen ) {
	        add_meta_box(
	            'global-notice',
	            __( 'Reousce Info', 'sitepoint' ),
	            'global_notice_meta_box_callback',
	            $screen
	        );
	    }
	}

add_action( 'add_meta_boxes', 'global_notice_meta_box' );
function global_notice_meta_box_callback( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'resource_id_nonce', 'resource_id_nonce' );
     wp_nonce_field( 'base_nonce', 'base_nonce' );
     wp_nonce_field( 'model_nonce', 'model_nonce' );
     wp_nonce_field( 'berths_nonce', 'berths_nonce' );
     wp_nonce_field( 'cabins_nonce', 'cabins_nonce' );
     wp_nonce_field( 'image_nonce', 'image_nonce' );
     wp_nonce_field( 'days_nonce', 'days_nonce' );
     wp_nonce_field( 'price_nonce', 'price_nonce' );
     wp_nonce_field( 'currency_nonce', 'currency_nonce' );



    $resource_id = get_post_meta( $post->ID, '_resource_id', true );
    $base = get_post_meta( $post->ID, '_base', true );
     $model = get_post_meta( $post->ID, '_model', true );
     $berths = get_post_meta( $post->ID, '_berths', true );
     $cabins = get_post_meta( $post->ID, '_cabins', true );
     $image = get_post_meta( $post->ID, '_image', true );
     $days = get_post_meta( $post->ID, '_days', true );
     $price = get_post_meta( $post->ID, '_price', true );
     $currency = get_post_meta( $post->ID, '_currency', true );
    

    ?>
    <p>Resource ID:</p>
    <p><input disabled="disabled"  style="width: 100%" type="text" name="resource_id" id="resource_id" value="<?php echo esc_attr($resource_id);?>"></p>
   
    <p>Base:</p>
    <p><input style="width: 100%" type="text" name="base" id="base" value="<?php echo esc_attr($base);?>"></p>
     <p>Model:</p>
    <p><input type="text" style="width: 100%" name="model" id="model" value="<?php echo esc_attr($model);?>"></p>
   <p>Berths:</p>
    <p><input type="text" name="berths" style="width: 100%" id="berths" value="<?php echo esc_attr($berths);?>"></p>
     <p>Cabins:</p>
    <p><input type="text" name="cabins" id="cabins" style="width: 100%" value="<?php echo esc_attr($cabins);?>"></p>
      <?php if(isset( $image ) && $image!=""):?>
      <p>image:</p>
    <p>

    	<img  width="250" height="250" src="<?php echo $image;?>">
    	
     </p>
 <?php endif;?>
    <p>No of Days:</p>
    <p><input type="text" name="days" id="days"  value="<?php echo esc_attr($days);?>"></p>
    <p>Price:</p>
    <p><input type="text" name="price" id="price"  value="<?php echo esc_attr($price);?>"></p> 
    <p>Currency:</p>
    <p><input type="text" name="currency" id="currency"  value="<?php echo esc_attr($currency);?>"></p> 
     <!-- -->
    <?php
    
}


/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id
 */
function save_global_notice_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['resource_id'] ) 
    	 && ! isset( $_POST['base']  )
    	 && ! isset( $_POST['model']  )
    	 && ! isset( $_POST['berths']  )
       && ! isset( $_POST['cabins']  )
       && ! isset( $_POST['image']  )
       && ! isset( $_POST['days']  )
       && ! isset( $_POST['price']  )
       && ! isset( $_POST['currency']  )
    	
    	 ) {
        return;
    }


    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['resource_id_nonce'], 'resource_id_nonce' ) 
      &&  ! wp_verify_nonce( $_POST['base_nonce'], 'base_nonce' ) 
		 &&  ! wp_verify_nonce( $_POST['model_nonce'], 'model_nonce' )
		 &&  ! wp_verify_nonce( $_POST['berths_nonce'], 'berths_nonce' )
     &&  ! wp_verify_nonce( $_POST['cabins_nonce'], 'cabins_nonce' )
      &&  ! wp_verify_nonce( $_POST['image_nonce'], 'image_nonce' )
       &&  ! wp_verify_nonce( $_POST['days_nonce'], 'days_nonce' )
       &&  ! wp_verify_nonce( $_POST['price_nonce'], 'price_nonce' )
       &&  ! wp_verify_nonce( $_POST['currency_nonce'], 'currency_nonce' )

		) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    }
    else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if ( ! isset( $_POST['resource_id'] ) 
    	 && ! isset( $_POST['baee'] )
    	 && ! isset( $_POST['model'] )
    	 && ! isset( $_POST['berths'] )
       && ! isset( $_POST['cabins'] )
       && ! isset( $_POST['image'] )
       && ! isset( $_POST['days'] )
       && ! isset( $_POST['price'] )
       && ! isset( $_POST['currency'] )
    	
      ) {
        return;
    }

    // Sanitize user input.
    $base = sanitize_text_field( $_POST['base'] );
     $model = sanitize_text_field( $_POST['model'] );
     $berths = sanitize_text_field( $_POST['berths'] );
     $cabins = sanitize_text_field( $_POST['cabins'] );
     $image = sanitize_text_field( $_POST['image'] );
     $days = sanitize_text_field( $_POST['days'] );
     $price = sanitize_text_field( $_POST['price'] );
     $currency = sanitize_text_field( $_POST['currency'] );


    // Update the meta field in the database.
    update_post_meta( $post_id, '_base', $base );
     update_post_meta( $post_id, '_model', $model );
     update_post_meta( $post_id, '_berths', $berths );
     update_post_meta( $post_id, '_cabins', $cabins );
     update_post_meta( $post_id, '_image', $image );
     update_post_meta( $post_id, '_days', $days );
     update_post_meta( $post_id, '_price', $price );
     update_post_meta( $post_id, '_currency', $currency );


}

add_action( 'save_post', 'save_global_notice_meta_box_data' );
add_shortcode("print_boat_listing","print_boat_listing_callback");

function print_boat_listing_callback(){
  $return_content = '';

          $args = array(
		    // Arguments for your query.
			'post_type'=>'boat',
			'posts_per_page'=>-1,
			
		);
		$query = new WP_Query( $args );

        if ( $query->have_posts() ) {
        		$i = 0;
        		$return_content = '<div class="boat-listing">';
        		 while ( $query->have_posts() ) { $query->the_post();

        		 	 $image = get_post_meta(  get_the_ID(), '_image', true );
        			$return_content .= '<div class="boat-card" data-position="0">
        			<a class="boat-card__img-container" href="'.get_the_permalink().'" target="_blank" rel="noreferrer">
        			<img src="'.$image.'" width="250" height="250"/>       			
        			</a>
        			<div class="boat-card__content">
        			<a class="boat-card__name" href="'.get_the_permalink().'" target="_blank" rel="noreferrer">'.get_the_title().'</a>
        			<span class="boat-card__location">Portisco-Sardinia › Italy</span>
        			<span class="boat-card__spec false">Optional skipper</span>
        			<span class="boat-card__spec false">Cabins: "'.get_post_meta(get_the_ID(), '_cabins', true).'"</span>
        			<span class="boat-card__spec last">Guests: 7</span>
        			<div class="boat-card__footer">
        			<div class="boat-card__price">
        			<span class="boat-card__price__prefix">From</span>
        			<span class="boat-card__price__amount">€'. get_post_meta(get_the_ID(), '_price', true) .'</span>
        			<span class="boat-card__price__suffix">for '. get_post_meta(get_the_ID(), '_days', true) .' Night</span>
        			</div>
        			<div class="boat-card__cta">
        			<a class="button button--brand-dark button--medium false false btn-cta" href="'.get_the_permalink().'" target="_blank" aria-label="'.get_the_title().'">
        			<span class="button__content">
        			<span>View Details</span>
        			<i class="icon-right"></i></span>
        			</a>
        			</div>
        			</div>
        			</div>
        			</div>';


        			$return_content .= '</div>';

        		 }
        		$return_content .= '</div>';

        }
  
  return $return_content;
}
?>