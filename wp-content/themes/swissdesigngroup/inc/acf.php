<?php

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Reminder Email Settings',
		'menu_title'	=> 'Email Reminder',
		'menu_slug' 	=> 'reminder-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	
}


// acf fields starts here...
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_55efeef079305',
	'title' => 'Email Reminder Settings',
	'fields' => array (
		array (
			'key' => 'field_55efef5fec78b',
			'label' => 'Sender Name',
			'name' => 'sender_name',
			'type' => 'text',
			'instructions' => 'This will be used for both reminder email and recipe emails',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_55efef3aec78a',
			'label' => 'Sender Email',
			'name' => 'sender_email',
			'type' => 'text',
			'instructions' => 'This will be used for both reminder email and recipe emails',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_55efeef9ec788',
			'label' => 'Email Subject',
			'name' => 'email_subject',
			'type' => 'text',
			'instructions' => 'Use {NAME} or {EVENT} to replace with actual receiver name and product name',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_55efef15ec789',
			'label' => 'Email Message',
			'name' => 'email_message',
			'type' => 'wysiwyg',
			'instructions' => 'Use {NAME} or {EVENT} to replace with actual receiver name and product name',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'reminder-general-settings',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => '',
));

endif;