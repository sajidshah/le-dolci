jQuery('document').ready(function($){

    if( $('a.add_account_note').length ){
        $( '#woocommerce-order-notes' ).on( 'click', 'a.add_account_note', function () {
            if ( ! $( 'textarea#add_order_note' ).val() ) {
                return;
            }

            $( '#woocommerce-order-notes' ).block({
                message: null,
                overlayCSS: {
                    background: '#fff',
                    opacity: 0.6
                }
            });

            var data = {
                action:    'woocommerce_crm_add_account_note',
                post_id:   woocommerce_admin_meta_boxes.post_id,
                note:      $( 'textarea#add_order_note' ).val(),
                note_type: $( 'select#order_note_type' ).val(),
                security:  woocommerce_admin_meta_boxes.add_order_note_nonce,
            };

            $.post( woocommerce_admin_meta_boxes.ajax_url, data, function( response ) {
                $( 'ul.order_notes' ).prepend( response );
                $( '#woocommerce-order-notes' ).unblock();
                $( '#add_order_note' ).val( '' );
            });

            return false;
        });
        /*$( '#woocommerce-order-notes' ).on( 'click', 'a.delete_note', function () {

        });*/
        
    }
});