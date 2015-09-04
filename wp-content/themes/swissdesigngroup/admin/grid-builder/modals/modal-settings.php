<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div id="grid-settings-dialog" title="<?php esc_attr_e('Item Settings', HB_DOMAIN_TXT); ?>" style="display:none;">
	<table>
		<tr>
			<td>
				<label for="hb-title"><?php _e('Title', HB_DOMAIN_TXT); ?></label>
				<input id="hb-title" type="text">
			</td>
		</tr>
		<tr>
			<td>
				<label for="hb-width"><?php _e('Width', HB_DOMAIN_TXT); ?></label>
				<select id="hb-width">
					<option value="1">10%</option>
					<option value="2">20%</option>
					<option value="3">30%</option>
					<option value="4">40%</option>
					<option value="5">50%</option>
					<option value="6">60%</option>
					<option value="7">70%</option>
					<option value="8">80%</option>
					<option value="9">90%</option>
					<option value="10">100%</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<label for="hb-height"><?php _e('Height', HB_DOMAIN_TXT); ?></label>
				<select id="hb-height">
					<option value="1">10%</option>
					<option value="2">20%</option>
					<option value="3">30%</option>
					<option value="4">40%</option>
					<option value="5">50%</option>
					<option value="6">60%</option>
					<option value="7">70%</option>
					<option value="8">80%</option>
					<option value="9">90%</option>
					<option value="10">100%</option>
				</select>
			</td>
		</tr>
		<tr>
			<td class="grid-media-picker">
<div class="option-tree-ui-upload-parent">
				<label for="hb-image"><?php _e('Image', HB_DOMAIN_TXT); ?></label>
	<input type="text" id="hb-image"  class="option-tree-ui-upload-input">
	<a href="javascript:void(0);" class="ot_upload_media option-tree-ui-button button button-primary light" rel="22" title="Add Media">
		<span class="icon ot-icon-plus-circle"></span>
	</a>
</div>

			</td>
		</tr>
		<tr>
			<td>
				<label for="hb-content"><?php _e('Content', HB_DOMAIN_TXT); ?></label>
				<?php //wp_editor( '', 'hb-content' ); ?> 
				<textarea id="hb-content"></textarea>
			</td>
		</tr>
	</tabel>
</div>