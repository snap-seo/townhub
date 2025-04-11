<?php

//Snap SEO


// townhub_addons_reset_user_notification_type('new_invoice');

$current_user = wp_get_current_user();    

if(is_front_page()) {
    $paged = (get_query_var('page')) ? get_query_var('page') : 1;
} else {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
}  

$author_orders = wc_get_orders(
        Esb_Class_Membership::is_author() ? array(
            'author'   => $current_user->ID,
            'page'      => $paged,
            'paginate'  => true,
        ) : array(
            'customer'   => $current_user->ID,
            'page'      => $paged,
            'paginate'  => true,
        )
);



// modify for pagination
if( !isset($author_orders->query_vars) ){
    $author_orders->query_vars = array('paged'=>$paged);
}

/* echo '<pre>';
 var_dump($author_orders);

$args = array(
'post_type'     => 'shop_order', 
'author'        =>  $current_user->ID, 
'orderby'       => 'date',
'order'         => 'DESC',
'paged'         => $paged,
'posts_per_page' => -1 // no limit

 double test for user invoice
'meta_key'      => ESB_META_PREFIX.'lauthor',
'meta_value'    => $current_user->ID,

 'post_status'   => 'publish',
 );

The Query
$posts_query = new WP_Query( $args ); */

?>
<div class="dashboard-content-wrapper dashboard-content-invoices">
    <div class="dashboard-content-inner">
        
        <div class="dashboard-title   fl-wrap">
            <h3><?php _e( 'Orders', 'townhub-add-ons' ); ?></h3>
        </div>
        
        <div class="dashboard-invoices-grid">
            <?php
            if( 0 < $author_orders->total ) : ?>
            <div class="dashboard-card card-has-content dis-block dashboard-table-wrap">
                <table class="cth-table cth-table-no-footer table-ads">
                    <thead>
                        <tr>
                            <th><?php _e( 'Order', 'townhub-add-ons' ); ?></th>
                            <th><?php _e( 'Date', 'townhub-add-ons' ); ?></th>
                            <th><?php _e( 'Status', 'townhub-add-ons' ); ?></th>
                            <th><?php _e( 'Amount', 'townhub-add-ons' ); ?></th>
                            <th><?php _e( 'Action', 'townhub-add-ons' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    foreach ( $author_orders->orders as $author_order ) {
                        // var_dump($author_order);
                        $order      = wc_get_order( $author_order );
                        // var_dump($order);die;
                        $order_id = $order->get_id();
                        // $item_count = $order->get_item_count() - $order->get_item_count_refunded();// error - Call to undefined method Automattic\WooCommerce\Admin\Overrides\OrderRefund::get_item_count_refunded
                        $item_count = $order->get_item_count();

                        $action_url = add_query_arg('view_order', $order_id, Esb_Class_Dashboard::screen_url('wooorders') );  
                        ?>
                        <tr id="lad-<?php echo $order_id; ?>" class="dashboard-list">
                            <td><a href="<?php echo esc_url( $action_url ); ?>" class="btn-link">#<?php echo $order_id; ?></a></td>
                            <td><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></td>
                            
                            <td><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></td>
                            <td><?php
                            /* translators: 1: formatted order total 2: total order items */
                            echo wp_kses_post( sprintf( _n( '%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'townhub-add-ons' ), $order->get_formatted_order_total(), $item_count ) );
                            ?></td>

                            <td><?php 
                            // $actions = wc_get_account_orders_actions( $order ); 
                            // if ( ! empty( $actions ) ) {
                            //     foreach ( $actions as $key => $action ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
                            //         echo '<a href="' . esc_url( $action['url'] ) . '" class="woocommerce-button button ' . sanitize_html_class( $key ) . '">' . esc_html( $action['name'] ) . '</a>';
                            //     }
                            // }

                            ?>


                            <a href="<?php echo esc_url( $action_url ); ?>" class="btn color-bg view-invoice-btn"><?php _e( 'View', 'townhub-add-ons' ); ?></a></td>
                        </tr>
                    <?php
                    } ?>
                    </tbody>
                </table>

                <?php
                    echo townhub_addons_custom_pagination($author_orders->max_num_pages,$range = 2, $author_orders);
                
                    /* Restore original Post Data 
                     * NB: Because we are using new WP_Query we aren't stomping on the 
                     * original $wp_query and it does not need to be reset with 
                     * wp_reset_query(). We just need to set the post data back up with
                     * wp_reset_postdata().
                     */
                    wp_reset_postdata();

                //endif; ?>
                <?php
                else: ?>
                <div class="dashboard-card card-has-no">
                    <div class="dashboard-card-content">
                        <?php _e( '<p>You have no order yet!</p>', 'townhub-add-ons' ); ?>
                    </div>
                <?php
                endif;?> 


            </div>
            

        </div>
    </div>
</div>
