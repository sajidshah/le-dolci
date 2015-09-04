<?php
global $hb_shortcodes;

$animations = array( "none","bounce","flash","pulse","rubberBand","shake","swing","tada","wobble","bounceIn","bounceInDown","bounceInLeft","bounceInRight","bounceInUp","fadeIn","fadeInDown","fadeInDownBig","fadeInLeft","fadeInLeftBig","fadeInRight","fadeInRightBig","fadeInUp","fadeInUpBig","flip","flipInX","flipInY","lightSpeedIn","rotateIn","rotateInDownLeft","rotateInDownRight","rotateInUpLeft","rotateInUpRight","rollIn","zoomIn","zoomInDown","zoomInLeft","zoomInRight","zoomInUp" );

#-----------------------------------------------------------------
# Column Layouts
#-----------------------------------------------------------------

$hb_shortcodes['headline_1'] 	= array( 'type'  	=>	's', 
										 'title'	=>	__('Layouts', 'hb_shortcodes' ));

$hb_shortcodes['hb_row'] 	= array( 'type'  	=>'c', 'title'=>__('Grid Row (wrapper)', 'hb_shortcodes' ), 
										 'attr'  	=> array( 'class' 	=> 	array( 	'type'  	=>	'input' , 
																					'title' 	=>	__('Optional Class','hb_shortcodes')
																				 ),
															 )
										);

$hb_shortcodes['hb_col'] 	= array( 'type'  	=>'c', 'title'=>__('Grid Column', 'hb_shortcodes' ), 
										 'attr'  	=> array( 	'column'    => array( 'type'  => 'range'  	 , 'title'  => __('Column' , 'hb_shortcodes'), 'def'=>'6', 'min' => '1', 'max' => '12', 'step' => '1', 'value' => '6') ,
										 						'offset'    => array( 'type'  => 'range'  	 , 'title'  => __('Offset' , 'hb_shortcodes'), 'def'=>'0', 'min' => '0', 'max' => '12', 'step' => '1', 'value' => '0') ,
										 						'hidetablet'=> array( 'type'  => 'radio'  	 , 'title'  => __('Hide from Tablet' , 'hb_shortcodes'), 'def'=>'0', 'opt' => array('1'=>'On', '0' => 'Off')) ,
										 						'hidemobile'=> array( 'type'  => 'radio'  	 , 'title'  => __('Hide from Mobile' , 'hb_shortcodes'), 'def'=>'0', 'opt' => array('1'=>'On', '0' => 'Off')) ,
										 						//'animation'=> array( 'type'   => 'select'  	 , 'title'  => __('Animation' , 'hb_shortcodes'), 'values' => $animations ),
										 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
															 )
										);


#-----------------------------------------------------------------
# Elements like Tabs & Toggle or Callout
#-----------------------------------------------------------------

$hb_shortcodes['headline_2'] = array( 	'type'	=>	's', 
										'title'	=>	__('Elements', 'hb_shortcodes' ));

$hb_shortcodes['hb_button'] 	= array( 'type'  	=>'c', 'title'=>__('Button', 'hb_shortcodes' ), 
										 'attr'  	=> array( 	'href'    => array( 'type'  => 'input'  	 , 'title'  => __('Link' , 'hb_shortcodes')),
										 						//'type'  => array( 'type'  => 'select' , 'title' => __('Type' , 'hb_shortcodes') , 'values' => array( "default","primary","success","info","warning","danger","link" ) ),
										 						//'size'  => array( 'type'  => 'select' , 'title' => __('Size' , 'hb_shortcodes') , 'values' => array( "default","large","small","extrasmall" ) ),
										 						//'icon'      		  => array( 'type'  => 'icon'   , 'title'  => __('Icon' , 'hb_shortcodes')) ,
										 						'target'  => array( 'type'  => 'select' , 'title' => __('Target (optional)' , 'hb_shortcodes') , 'values' => array( "_self", "_blank" ) ),
										 						//'block'  => array( 'type'  => 'select' , 'title' => __('Block (optional)' , 'hb_shortcodes') , 'values' => array( "on", "off" ) ),
										 						//'active'  => array( 'type'  => 'select' , 'title' => __('Active (optional)' , 'hb_shortcodes') , 'values' => array( "on", "off" ) ),
										 						//'disabled'  => array( 'type'  => 'select' , 'title' => __('Disabled (optional)' , 'hb_shortcodes') , 'values' => array( "on", "off" ) ),
										 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
															 )
										);
										

$hb_shortcodes['hb_space'] = array( 'type'=>'s', 'title'=>__('Spacer', 'hb_shortcodes'), 'attr'=>array( 'height' 		 => array( 'type'  => 'input'  	, 'title'  => __('Height' , 'hb_shortcodes') 	 , 'desc' => __('Example: 30px or 2em' , 'hb_shortcodes') ) ,
																											));

	
$hb_shortcodes['hb_ul'] = array( 'type'  => 'm', 'title' => __('Fancy List', 'hb_shortcodes' ), 'attr' 	=> array( 'fancyli' => array( 'type'  => 'custom' )));



$hb_shortcodes['hb_team_member'] 	= array( 'type'  	=>'s', 'title'=>__('Team Memeber', 'hb_shortcodes' ), 
										 'attr'  	=> array( 	'img'    => array( 'type'  => 'mediaacess' , 'title'  => __('Image' , 'hb_shortcodes')),
										 						'name'    => array( 'type'  => 'input'  	 , 'title'  => __('Name' , 'hb_shortcodes')),
										 						'title'    => array( 'type'  => 'input'  	 , 'title'  => __('Title' , 'hb_shortcodes')),
										 						'color'    => array( 'type'  => 'colorpicker'  	 , 'title'  => __('Color' , 'hb_shortcodes')),
										 						'class' 	=> 	array( 	'type'  	=>	'input' , 'title' 	=>	__('Optional Class','hb_shortcodes')),
															 )
										);