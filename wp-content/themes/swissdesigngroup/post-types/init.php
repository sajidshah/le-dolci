<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

foreach (  glob( dirname(__FILE__) . "/types/*.php" ) as $filename )

	load_template ( $filename );