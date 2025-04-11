<?php
/* add_ons_php */
// $dashboard = get_query_var('dashboard');
///SNAP SEO 2025

if(!isset($is_add_page)) $is_add_page = false;
if(!isset($is_edit_page)) $is_edit_page = false;

$current_user_id = get_current_user_id();

$notifications = get_user_meta( $current_user_id, ESB_META_PREFIX . 'notifications', true);
$indicators    = array(
    'new_invoice'     => 0,
    'order_completed' => 0,
    'listing_publish' => 0,
    'bookmarked'      => 0,
    'ad_completed'    => 0,
);
if (!empty($notifications) && is_array($notifications)) {
    foreach ($notifications as $key => $value) {
        $noti_type = townhub_addons_get_notification_type($key);
        switch ($noti_type) {

            case 'new_invoice':
                $indicators['new_invoice'] += 1;
                break;
            case 'order_completed':
                $indicators['order_completed'] += 1;
                break;
            case 'listing_publish':
                $indicators['listing_publish'] += 1;
                break;
            case 'bookmarked':
                $indicators['bookmarked'] += 1;
                break;
            case 'ad_completed':
                $indicators['ad_completed'] += 1;
                break;

        }
    }
}
$badges = array();
foreach ($indicators as $key => $value) {
    if ($value) {
        $badges[$key] = '<span>' . $value . '</span>';
    } else {
        $badges[$key] = '';
    }

}

$loggedin_is_author = Esb_Class_Membership::is_author();
?>
<div class="mob-nav-content-btn color2-bg init-dsmen fl-wrap"><i class="fal fa-bars"></i><?php _e( 'Dashboard menu', 'townhub-add-ons' ); ?></div>
<div class="clearfix"></div>
<div class="fixed-barss fl-wrap" id="dash_menu">
    <div class="user-profile-menu-wrap fl-wrap block_box">
        <!-- user-profile-menu-->
        <div class="user-profile-menu">
            <h3><?php _e('Main', 'townhub-add-ons');?></h3>
            <ul class="no-list-style">
                <?php 
                    Esb_Class_Dashboard::menu_item($screen = '', $title = _x( 'Dashboard', 'Sidebar menu', 'townhub-add-ons' ), $icon = 'fal fa-chart-line', $badge = '', $is_add_page, $is_edit_page);
                    
                    
                    if ( $loggedin_is_author && townhub_addons_get_option('db_show_dokan') == 'yes' && function_exists('dokan_get_option') ){
                        $dkpage_id = dokan_get_option( 'dashboard', 'dokan_pages' );
                        if( $dkpage_id ):
                    ?>
                        <li class="dashboard-menu-li dbscreen-dokan">
                            <a href="<?php echo get_permalink( $dkpage_id ); ?>" class="dashboard-menu-link"><i class="fal fa-tachometer-alt-slow"></i><?php _ex( 'Dokan dashboard', 'Dashboard', 'townhub-add-ons' ); ?></a>
                        </li>
                    <?php
                        endif;
                    }
                    

                    if( $loggedin_is_author ) Esb_Class_Dashboard::menu_item($screen = 'feed', $title = __( 'Your Feed', 'townhub-add-ons' ), $icon = 'fal fa-rss', $badge = '', $is_add_page, $is_edit_page);
                    
                    Esb_Class_Dashboard::menu_item($screen = 'profile', $title = __( 'Edit profile', 'townhub-add-ons' ), $icon = 'fal fa-user-edit', $badge = '', $is_add_page, $is_edit_page);
                    
                    if (townhub_addons_get_option('admin_chat') == 'yes') 
                        Esb_Class_Dashboard::menu_item($screen = 'chats', $title = __( 'Chats', 'townhub-add-ons' ), $icon = 'fal fa-comment-dots', $badge = '', $is_add_page, $is_edit_page);
                    
                    if (townhub_addons_get_option('db_hide_messages') != 'yes')
                        Esb_Class_Dashboard::menu_item($screen = 'messages', $title = __( 'Messages', 'townhub-add-ons' ), $icon = 'fal fa-envelope', get_user_meta( $current_user_id, ESB_META_PREFIX . 'messages_count', true) , $is_add_page, $is_edit_page);

                    Esb_Class_Dashboard::menu_item($screen = 'changepass', $title = __( 'Change Password', 'townhub-add-ons' ), $icon = 'fal fa-key', $badge = '', $is_add_page, $is_edit_page);
                ?>
            </ul>
        </div>
        <!-- user-profile-menu end-->
        <!-- user-profile-menu-->
        <div class="user-profile-menu">
            <h3><?php _e('Listings', 'townhub-add-ons');?></h3>
            <ul class="no-list-style">
                <?php 
                    if( $loggedin_is_author ) Esb_Class_Dashboard::menu_item($screen = 'listings', $title = __( 'My Listings', 'townhub-add-ons' ), $icon = 'fal fa-th-list', $badge = '', $is_add_page, $is_edit_page);
                    // woo products
                    // if( $loggedin_is_author && townhub_addons_get_option('db_hide_products') != 'yes' ) Esb_Class_Dashboard::menu_item($screen = 'products', $title = __( 'WooCommerce Products', 'townhub-add-ons' ), $icon = 'fal fa-box-usd', $badge = '', $is_add_page, $is_edit_page);
                    
                    
                    if ( $loggedin_is_author && townhub_addons_get_option('db_show_dokan_products') == 'yes' && function_exists('dokan_get_navigation_url') ){
                        $permalink    = dokan_get_navigation_url( 'products' );
                    ?>
                        <li class="dashboard-menu-li dbscreen-dokan">
                            <a href="<?php echo $permalink; ?>" class="dashboard-menu-link"><i class="fal fa-briefcase"></i><?php _ex( 'Dokan products', 'Dashboard', 'townhub-add-ons' ); ?></a>
                        </li>
                    <?php
                        
                    }
                    if (townhub_addons_get_option('db_hide_bookmarks') != 'yes'){
                        Esb_Class_Dashboard::menu_item($screen = 'bookmarks', $title = _x( 'Bookmarks', 'Dashboard', 'townhub-add-ons' ), $icon = 'fal fa-bookmark', $badge = '', $is_add_page, $is_edit_page);
                    }


                    if ( $loggedin_is_author && townhub_addons_get_option('db_hide_ical') != 'yes' ){
                        Esb_Class_Dashboard::menu_item($screen = 'ical', $title = _x( 'iCal Sync', 'Dashboard', 'townhub-add-ons' ), $icon = 'fal fa-calendar-edit', $badge = '', $is_add_page, $is_edit_page);
                    }
                    
                    if ( $loggedin_is_author && townhub_addons_get_option('db_hide_ads') != 'yes' ){
                        Esb_Class_Dashboard::menu_item($screen = 'ads', $title = __( 'AD Campaigns', 'townhub-add-ons' ), $icon = 'fal fa-bullhorn', $badge = '', $is_add_page, $is_edit_page);
                    }
                    if (townhub_addons_get_option('db_hide_bookings') != 'yes'){
                        Esb_Class_Dashboard::menu_item($screen = 'bookings', $title = __( 'Bookings', 'townhub-add-ons' ), $icon = 'fal fa-calendar-check', get_user_meta( $current_user_id, ESB_META_PREFIX . 'bookings_count', true), $is_add_page, $is_edit_page);
                    }
                    

                    if (townhub_addons_get_option('db_show_inquiries') == 'yes'){
                        Esb_Class_Dashboard::menu_item($screen = 'inquiries', $title = _x( 'Inquiries','Front-end dashboard', 'townhub-add-ons' ), $icon = 'fal fa-envelope-open-dollar', '', $is_add_page, $is_edit_page);
                    }
                    ////SNAP SEO CHANGED
                    if (townhub_addons_get_option('db_show_woo_orders') == 'yes'){
                        Esb_Class_Dashboard::menu_item($screen = 'wooorders', $title = _x( 'Orders','Front-end dashboard', 'townhub-add-ons' ), $icon = 'fal fa-bags-shopping', '', $is_add_page, $is_edit_page);
                    }

                    if (townhub_addons_get_option('db_hide_invoices') != 'yes'){
                        Esb_Class_Dashboard::menu_item($screen = 'invoices', $title = __( 'Invoices', 'townhub-add-ons' ), $icon = 'fal fa-file-invoice-dollar', $badge = '', $is_add_page, $is_edit_page);
                    }
                    if (townhub_addons_get_option('db_hide_reviews') != 'yes'){
                        Esb_Class_Dashboard::menu_item($screen = 'reviews', $title = __( 'Reviews', 'townhub-add-ons' ), $icon = 'fal fa-comments-alt', $badge = '', $is_add_page, $is_edit_page);
                    }
                    if ( $loggedin_is_author && townhub_addons_get_option('db_hide_withdrawals') != 'yes'){
                        Esb_Class_Dashboard::menu_item($screen = 'withdrawals', $title = __( 'Withdrawals', 'townhub-add-ons' ), $icon = 'fal fa-usd-square', $badge = '', $is_add_page, $is_edit_page);
                    }
                    // Esb_Class_Dashboard::menu_item($screen = 'packages', $title = __( 'Packages', 'townhub-add-ons' ), $icon = 'fal fa-briefcase', $badge = '', $is_add_page, $is_edit_page);
                    
                    
                    // Esb_Class_Dashboard::menu_item($screen = 'bookmarks', $title = __( 'Bookmarks', 'townhub-add-ons' ), $icon = 'fal fa-bookmark', $badge = '', $is_add_page, $is_edit_page);
                    do_action( 'cth_listing_dashboard_sidebar_menu', $is_add_page, $is_edit_page );
                ?>
                <?php if( $loggedin_is_author && townhub_addons_get_option('db_hide_adnew') != 'yes'  ): ?>
                <li class="dashboard-menu-li"><a class="dashboard-menu-link<?php if($is_add_page) echo ' user-profile-act'; ?>" href="<?php echo townhub_addons_add_listing_url(); ?>"><i class="fal fa-file-plus"></i><?php _e( 'Add New', 'townhub-add-ons' ); ?></a></li>
                <?php endif; ?>
            </ul>
        </div>
        <!-- user-profile-menu end-->
        <a href="<?php echo wp_logout_url(townhub_addons_get_current_url()); ?>" class="logout_btn color2-bg"><?php _e('Log Out', 'townhub-add-ons');?><i class="fas fa-sign-out"></i></a>
    </div>
</div>
<a class="back-tofilters color2-bg custom-scroll-link fl-wrap dashboard-to-top" href="#dash_menu"><?php _e( 'Back to Menu', 'townhub-add-ons' ); ?><i class="fas fa-caret-up"></i></a>
