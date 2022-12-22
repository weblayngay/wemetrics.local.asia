<?php
define( 'DS', DIRECTORY_SEPARATOR );

/*
|-------------------------------------------------------
| ROOT ACCOUNT
|-------------------------------------------------------
*/
define('ROOT_USER_IDS', [1]);
define('ROOT_GROUP_IDS', [1]);

/*
|-------------------------------------------------------
| SEPERATOR
|-------------------------------------------------------
*/
define('SEPARATE', '-');
define('VERTICAL_BAR', '|');
define('SUFFIX_URL', '.htm');

/*
|-------------------------------------------------------
| TAXONOMY
|-------------------------------------------------------
*/
define('ADVERTGROUP_TAXONOMY', 'danh-sach-quang-cao');
define('ADVERT_TAXONOMY', 'quang-cao');

define('BANNERGROUP_TAXONOMY', 'danh-sach-banner');
define('BANNER_TAXONOMY', 'banner');

define('POSTGROUP_TAXONOMY', 'danh-sach-bai-viet');
define('POST_TAXONOMY', 'bai-viet');

define('NEWSGROUP_TAXONOMY', 'danh-sach-tin-tuc');
define('NEWS_TAXONOMY', 'tin-tuc');

define('PRODUCTGROUP_TAXONOMY', 'nhom-san-pham');
define('PRODUCT_TAXONOMY', 'san-pham');

define('SERVICEGROUP_TAXONOMY', 'nhom-dich-vu');
define('SERVICE_TAXONOMY', 'dich-vu');

define('CAMPAIGNGROUP_TAXONOMY', 'nhom-chien-dich');
define('CAMPAIGN_TAXONOMY', 'chien-dich');

/*
|-------------------------------------------------------
| CURRENCY
|-------------------------------------------------------
*/
define('MASTER_CURRENCY_SYMBOL', 'VND');
define('MASTER_CURRENCY_PREFIX', ' ₫');
define('MASTER_CURRENCY_DECIMALS', '0');
define('MASTER_CURRENCY_DECIMAL_SEPERATOR', '.');
define('MASTER_CURRENCY_THOUSANDS_SEPERATOR', ',');

/*
|-------------------------------------------------------
| PAGINATE LIMIT QUERY
|-------------------------------------------------------
*/
define('PAGINATE_PERPAGE', '15');
define('QUERY_LIMIT', '100');
define('FORMAT_DATE_QUERY', '%d-%m-%Y');

/*
|-------------------------------------------------------
| DATABASE TABLE CORE
|-------------------------------------------------------
 */
define('ADMIN_MENU_TBL', 'admin_menus');
define('ADMIN_USER_TBL', 'admin_users');
define('ADMIN_GROUP_TBL', 'admin_groups');
define('PRODUCT_TBL', 'products');
define('PRODUCT_CATEGORY_TBL', 'product_categories');
define('PRODUCT_COLOR_TBL', 'product_colors');
define('PRODUCT_SIZE_TBL', 'product_sizes');
define('PRODUCT_ODOROUS_TBL', 'product_odorous');
define('PRODUCT_COLLECTION_TBL', 'product_collections');
define('PRODUCT_NUTRITIONS_TBL', 'product_nutritions');
define('PRODUCT_USING_COLOR_TBL', 'product_using_colors');
define('PRODUCT_USING_SIZE_TBL', 'product_using_sizes');
define('PRODUCT_USING_ODOROUS_TBL', 'product_using_odorous');
define('PRODUCT_USING_NUTRITIONS_TBL', 'product_using_nutritions');
define('PRODUCT_USING_COLLECTIONS_TBL', 'product_using_collections');
define('MENU_GROUP_TBL', 'menu_groups');
define('MENU_TBL', 'menus');
define('CONFIG_TBL', 'configs');

define('PRODUCER_TBL', 'producers');
define('POST_TBL', 'posts');
define('POST_GROUP_TBL', 'post_groups');
define('ADVERT_TBL', 'adverts');
define('CONTACT_CONFIG_TBL', 'contactconfigs');
define('CONTACT_TBL', 'contacts');
define('CONTACT_EXTEND_TBL', 'contactextends');
define('ADVERT_GROUP_TBL', 'advert_groups');
define('IMAGE_TBL', 'images');
define('BANNER_TBL', 'banners');
define('BANNER_GROUP_TBL', 'banner_groups');
define('PERCEIVED_VALUE_TBL', 'perceived_values');
define('USER_TBL', 'users');
define('BLOCK_TBL', 'blocks');
define('ORDER_TBL', 'orders');
define('ORDER_ITEM_TBL', 'order_items');
define('WARD_TBL', 'wards');
define('DISTRICT_TBL', 'districts');
define('PROVINCE_TBL', 'provinces');
define('COMMENT_TBL', 'comments');
define('VOUCHER_TBL', 'vouchers');
define('VOUCHER_GROUP_TBL', 'voucher_groups');
define('CAMPAIGN_TBL', 'campaigns');
define('CAMPAIGN_GROUP_TBL', 'campaign_groups');
define('CAMPAIGN_TYPE_TBL', 'campaign_types');
define('CAMPAIGN_RESULT_TBL', 'campaign_results');

// Digital Ads
define('GGANALYTICS_TBL', 'gganalytics');
define('GGADWORDS_TBL', 'ggadwords');
define('FBADS_TBL', 'fbads');
define('FBINSIGHTS_TBL', 'fbinsights');
define('TIKTOKADS_TBL', 'tiktokads');

// Api
define('CTOKENIN_TBL', 'ctokenin');
define('CTOKENOUT_TBL', 'ctokenout');
define('CTOKENVENDOR_TBL', 'ctokenvendor');

// Client Tracking
define('CLIENTTRACKING_UTMSOURCE_TBL', 'client_tracking_utm_source');
define('CLIENTTRACKING_UTMMEDIUM_TBL', 'client_tracking_utm_medium');
define('CLIENTTRACKING_UTMCAMPAIGN_TBL', 'client_tracking_utm_campaign');
define('CLIENTTRACKING_TRAFFICILLEGAL_TBL', 'client_tracking_traffic_illegal');
define('CLIENTTRACKING_TRAFFICDETAILS_TBL', 'client_tracking_traffic_details');
define('CLIENTTRACKING_TRAFFICADS_TBL', 'client_tracking_traffic_ads');
define('CLIENTTRACKING_REPLACEREQURUI_TBL', 'client_tracking_replace_request_rui');
define('CLIENTTRACKING_REGION_TBL', 'client_tracking_region');
define('CLIENTTRACKING_REFERER_TBL', 'client_tracking_referer');
define('CLIENTTRACKING_TRACKINGPLATFORM_TBL', 'client_tracking_platform');
define('CLIENTTRACKING_ILLEGALREQUESTRUI_TBL', 'client_tracking_illegal_request_rui');
define('CLIENTTRACKING_GEOLITEDETAILS_TBL', 'client_tracking_geolite_details');
define('CLIENTTRACKING_EXCLUDEREQUESTRUI_TBL', 'client_tracking_exclude_request_rui');
define('CLIENTTRACKING_TRACKINGDEVICE_TBL', 'client_tracking_device');
define('CLIENTTRACKING_TRACKINGBROWSER_TBL', 'client_tracking_browser');
define('CLIENTTRACKING_TRACKINGBLOCKIP_TBL', 'client_tracking_block_ip');
define('CLIENTTRACKING_TRACKINGWHITELIST_TBL', 'client_tracking_whitelist_ip');

/*
|-------------------------------------------------------
| DATABASE TABLE WEBSITE INTERGRATION
|-------------------------------------------------------
 */
define('FILTER_YEARS', ['2022']);
define('LT4_PRODUCTS', 'lt4_products');
define('LT4_PRODUCTS_CATEGORIES', 'lt4_products_categories');
define('LT4_PRODUCTS_ORDERS', 'lt4_products_orders');
define('LT4_PRODUCTS_ORDERS_DETAIL', 'lt4_products_orders_detail');
define('LT4_PRODUCTS_ORDERS_STATUS', 'lt4_products_orders_status');
define('LT4_PRODUCTS_PAYMENT_METHOD', 'lt4_products_payment_method');
define('LT4_PRODUCTS_ORDERS_USER_INFO', 'lt4_products_orders_user_info');
define('LT4_PRODUCTS_SHIPPING_CITIES', 'lt4_products_shipping_cities');
define('LT4_PRODUCTS_SHIPPING_DIST', 'lt4_products_shipping_dist');
define('LT4_RESELLER_CATEGORIES', 'lt4_reseller_categories');
define('LT4_RESELLER', 'lt4_resellers');

/*
|-------------------------------------------------------
| DATABASE TABLE AFFILIATE INTERGRATION
|-------------------------------------------------------
 */
define('TS_AFFILIATES', 'ts_affiliates');
define('TS_AFFILIATE_RESELLERS', 'ts_users');
define('TS_PAYMENTS', 'ts_payments');
define('TS_SALES', 'ts_sales');
define('TS_SALES_DELETED', 'ts_sales_deleted');
define('TS_ORDERS', 'ts_orders');
define('TS_ORDER_STATUS', 'ts_order_status');
define('TS_ORDER_ITEMS', 'ts_order_items');

/*
|-------------------------------------------------------
| LABEL ACTION
|-------------------------------------------------------
 */
define('ADD_LABEL', ' [Thêm]');
define('EDIT_LABEL', ' [Sửa]');
define('COPY_LABEL', ' [Copy]');
define('SHOW_LABEL', ' [Xem]');

define('STATISTIC_BUTTON_LABEL', ' Lọc');
define('SYNC_BUTTON_LABEL', ' Sync');
define('REFRESH_BUTTON_LABEL', ' Refresh');
define('FILTER_BUTTON_LABEL', ' Tìm');
define('SORT_BUTTON_LABEL', ' Sort');
define('ADD_BUTTON_LABEL', ' Thêm');
define('EDIT_BUTTON_LABEL', ' Sửa');
define('SHOW_BUTTON_LABEL', ' Xem');
define('DEL_BUTTON_LABEL', ' Xóa');
define('COPY_BUTTON_LABEL', ' Copy');
define('ACTIVE_BUTTON_LABEL', ' Bật');
define('INACTIVE_BUTTON_LABEL', ' Tắt');
define('EXIT_BUTTON_LABEL', ' Thoát');
define('SAVE_BUTTON_LABEL', ' Lưu');
define('SAVE_A_BUTTON_LABEL', ' Lưu và Thêm');
define('SAVE_E_BUTTON_LABEL', ' Lưu và Sửa');
define('EXPORT_DATA_LABEL', ' Export Data');
define('EXPORT_CUSTOMER_LABEL', ' Export Khách hàng');

/*
|-------------------------------------------------------
| TITLE
|-------------------------------------------------------
 */
define('ADMIN_MENU_TITLE', '');
define('ADMIN_USER_TITLE', '');
define('ADMIN_GROUP_TITLE', '');
define('BANNER_TITLE', 'Banner ');
define('BANNER_GROUP_TITLE', 'Nhóm banner ');
define('PRODUCT_TITLE', '');
define('PRODUCT_CATEGORY_TITLE', '');
define('PRODUCT_COLOR_TITLE', '');
define('PRODUCT_SIZE_TITLE', '');
define('PRODUCT_ODOROUS_TITLE', '');
define('PRODUCT_COLLECTION_TITLE', '');
define('PRODUCT_NUTRITIONS_TITLE', '');
define('PRODUCT_USING_COLOR_TITLE', '');
define('PRODUCT_USING_SIZE_TITLE', '');
define('PRODUCT_USING_ODOROUS_TITLE', '');
define('PRODUCT_USING_NUTRITIONS_TITLE', '');
define('PRODUCT_USING_COLLECTIONS_TITLE', '');
define('MENU_GROUP_TITLE', 'Quản lý nhóm menu');
define('MENU_TITLE', 'Quản lý menu');
define('CONFIG_TITLE', '');
define('USER_TITLE', 'Quản lý người dùng');
define('CONTACT_CONFIG_TITLE', 'Cấu hình liên hệ ');
define('CONTACT_TITLE', 'Liên hệ ');
define('CONTACT_EXTEND_TITLE', 'Mở rộng liên hệ ');
define('PERCEIVEDVALUE_TITLE', 'Cảm nhận khách hàng ');
define('COMMENT_TITLE', 'Bình luận ');
define('POST_TITLE', 'Bài viết ');
define('POST_GROUP_TITLE', 'Nhóm bài viết ');
define('ADVERT_TITLE', 'Quảng cáo ');
define('ADVERT_GROUP_TITLE', 'Nhóm quảng cáo ');
define('VOUCHER_TITLE', 'Mã giảm giá');
define('VOUCHER_GROUP_TITLE', 'Nhóm mã giảm giá');
define('PRODUCER_TITLE', 'Nhà sản xuất ');
define('CAMPAIGN_TITLE', 'Chiến dịch ');
define('CAMPAIGN_GROUP_TITLE', 'Nhóm chiến dịch ');
define('CAMPAIGN_TYPE_TITLE', 'Loại chiến dịch ');
define('CAMPAIGN_RESULT_TITLE', 'Kết quả chiến dịch ');
define('CAMPAIGN_STATISTIC_TITLE', 'Thống kê chiến dịch ');
define('GGANALYTICS_TITLE', 'Google Analytics Dashboard');
define('GGADWORDS_TITLE', 'Google Adwords Dashboard');
define('FBADS_TITLE', 'Facebook Ads Dashboard');
define('FBINSIGHTS_TITLE', 'Facebook Insights Dashboard');
define('TIKTOKADS_TITLE', 'Tiktok Ads Dashboard');
define('CTOKENIN_TITLE', 'Tạo api bên trong');
define('CTOKENOUT_TITLE', 'Tạo api bên ngoài');
define('CTOKENVENDOR_TITLE', 'Tạo đối tượng api');
define('CLIENTTRACKING_TITLE', 'Quản lý Client Tracking');
define('CLIENTTRACKING_UTMSOURCE_TITLE', 'Tạo utm source');
define('CLIENTTRACKING_UTMMEDIUM_TITLE', 'Tạo utm medium');
define('CLIENTTRACKING_UTMCAMPAIGN_TITLE', 'Tạo utm campaign');
define('CLIENTTRACKING_TRACKINGBROWSER_TITLE', 'Kiểm soát trình duyệt');
define('CLIENTTRACKING_TRACKINGDEVICE_TITLE', 'Kiểm soát thiết bị');
define('CLIENTTRACKING_TRACKINGPLATFORM_TITLE', 'Kiểm soát nền tảng');
define('CLIENTTRACKING_TRACKINGREFERER_TITLE', 'Kiểm soát nguồn truy cập');
define('CLIENTTRACKING_TRACKINGREGION_TITLE', 'Kiểm soát địa điểm');
define('CLIENTTRACKING_BLOCKIP_TITLE', 'Chặn địa chỉ IP truy cập');
define('CLIENTTRACKING_WHITELISTIP_TITLE', 'Cho phép địa chỉ IP truy cập');
define('CLIENTTRACKING_EXCLUDEREQRUI_TITLE', 'Truy cập ưu tiên');
define('CLIENTTRACKING_ILLEGALREQRUI_TITLE', 'Truy cập không hợp lệ');
define('CLIENTTRACKING_REPLACEREQRUI_TITLE', 'Thay thế từ khóa truy cập');
//
define('ORDER_TITLE', 'Quản lý đơn hàng');
define('ORDER_STATISTIC_TITLE', 'Thống kê đơn hàng');
define('ORDER_WEBSITE_REPORT_OVERVIEW_TITLE', 'Thống kê tổng quan');
define('ORDER_WEBSITE_REPORT_RESELLER_TITLE', 'Thống kê theo cửa hàng');
define('ORDER_WEBSITE_REPORT_PAYONLINE_TITLE', 'Thống kê thanh toán Online'); 
define('ORDER_WEBSITE_REPORT_PRODUCT_TITLE', 'Thống kê theo sản phẩm');
//
define('AFFILIATE_SALES_REPORT_TITLE', 'Thống kê hoa hồng');
define('AFFILIATE_COMM_REPORT_TITLE', 'Thống kê cộng tác viên');
define('AFFILIATE_PAYMENTS_REPORT_TITLE', 'Thanh toán cộng tác viên');
define('AFFILIATE_PRODUCT_REPORT_TITLE', 'Thống kê theo sản phẩm');
//
define('KIOTVIET_TITLE', 'Quản lý kiotviet');
define('KIOTVIET_CUSTOMER_TITLE', 'Quản lý khách hàng kiotviet');
define('KIOTVIET_INVOICE_TITLE', 'Quản lý bill kiotviet');
define('KIOTVIET_PRODUCT_TITLE', 'Quản lý sản phẩm kiotviet');
define('KIOTVIET_INVOICE_REPORT_TITLE', 'Thống kê theo bill');
define('KIOTVIET_CUSTOMER_REPORT_TITLE', 'Thống kê theo khách hàng');
define('KIOTVIET_CATEPRODUCT_REPORT_TITLE', 'Thống kê theo nhóm sản phẩm');
define('KIOTVIET_PRODUCT_REPORT_TITLE', 'Thống kê theo sản phẩm');
//
define('ANALYTICS_TOOKIT_TITLE', 'Bộ phân tích dữ liệu');

/*
|-------------------------------------------------------
| PATH SEARCH
|-------------------------------------------------------
 */
define('ORDER_SEARCH', 'backend.elements.searchs.order.items');
define('VOUCHER_GROUP_SEARCH', 'backend.elements.searchs.vouchergroup.items');
define('VOUCHER_SEARCH', 'backend.elements.searchs.voucher.items');
define('CAMPAIGN_SEARCH', 'backend.elements.searchs.campaign.items');
define('CAMPAIGN_TYPE_SEARCH', 'backend.elements.searchs.campaigntype.items');
define('CAMPAIGN_GROUP_SEARCH', 'backend.elements.searchs.campaigngroup.items');
define('CAMPAIGN_RESULT_SEARCH', 'backend.elements.searchs.campaignresult.items');
define('CAMPAIGN_STATISTIC_SEARCH', 'backend.elements.searchs.campaignstatistic.items');
define('GGANALYTICS_SEARCH', 'backend.elements.searchs.gganalytics.items');
define('GGADWORDS_SEARCH', 'backend.elements.searchs.ggadwords.items');
define('FBADS_SEARCH', 'backend.elements.searchs.fbads.items');
define('FBINSIGHTS_SEARCH', 'backend.elements.searchs.fbinsights.items');
define('TIKTOKADS_SEARCH', 'backend.elements.searchs.tiktokads.items');
define('CTOKENIN_SEARCH', 'backend.elements.searchs.ctokenin.items');
define('CTOKENOUT_SEARCH', 'backend.elements.searchs.ctokenout.items');
define('CTOKENVENDOR_SEARCH', 'backend.elements.searchs.ctokenvendor.items');
define('CLIENTTRACKING_UTMSOURCE_SEARCH', 'backend.elements.searchs.utmsource.items');
define('CLIENTTRACKING_UTMMEDIUM_SEARCH', 'backend.elements.searchs.utmmedium.items');
define('CLIENTTRACKING_UTMCAMPAIGN_SEARCH', 'backend.elements.searchs.utmcampaign.items');
define('CLIENTTRACKING_TRACKINGBROWSER_SEARCH', 'backend.elements.searchs.clienttrackingbrowser.items');
define('CLIENTTRACKING_TRACKINGDEVICE_SEARCH', 'backend.elements.searchs.clienttrackingdevice.items');
define('CLIENTTRACKING_TRACKINGPLATFORM_SEARCH', 'backend.elements.searchs.clienttrackingplatform.items');
define('CLIENTTRACKING_TRACKINGREFERER_SEARCH', 'backend.elements.searchs.clienttrackingreferer.items');
define('CLIENTTRACKING_TRACKINGREGION_SEARCH', 'backend.elements.searchs.clienttrackingregion.items');
define('CLIENTTRACKING_BLOCKIP_SEARCH', 'backend.elements.searchs.clienttrackingblockip.items');
define('CLIENTTRACKING_WHITELISTIP_SEARCH', 'backend.elements.searchs.clienttrackingwhitelistip.items');
define('CLIENTTRACKING_EXCLUDEREQRUI_SEARCH', 'backend.elements.searchs.clienttrackingexcludereqrui.items');
define('CLIENTTRACKING_ILLEGALREQRUI_SEARCH', 'backend.elements.searchs.clienttrackingillegalreqrui.items');
define('CLIENTTRACKING_REPLACEREQRUI_SEARCH', 'backend.elements.searchs.clienttrackingreplacereqrui.items');
define('CLIENTTRACKING_REPORTOVERVIEW_SEARCH', 'backend.elements.searchs.clienttrackingreportoverview.items');
define('CLIENTTRACKING_REPORTSOURCE_SEARCH', 'backend.elements.searchs.clienttrackingreportsource.items');
define('CLIENTTRACKING_REPORTBROWSER_SEARCH', 'backend.elements.searchs.clienttrackingreportbrowser.items');
define('CLIENTTRACKING_REPORTDEVICE_SEARCH', 'backend.elements.searchs.clienttrackingreportdevice.items');
define('CLIENTTRACKING_REPORTPLATFORM_SEARCH', 'backend.elements.searchs.clienttrackingreportplatform.items');
define('CLIENTTRACKING_REPORTGEO_SEARCH', 'backend.elements.searchs.clienttrackingreportgeo.items');
define('CLIENTTRACKING_REPORTADS_SEARCH', 'backend.elements.searchs.clienttrackingreportads.items');

define('ORDER_REPORTOVERVIEW_SEARCH', 'backend.elements.searchs.orderwebsitereportoverview.items');
define('ORDER_REPORTRESELLER_SEARCH', 'backend.elements.searchs.orderwebsitereportreseller.items');
define('ORDER_REPORTPAYONLINE_SEARCH', 'backend.elements.searchs.orderwebsitereportpayonline.items');
define('ORDER_REPORTPRODUCT_SEARCH', 'backend.elements.searchs.orderwebsitereportproduct.items');

define('AFFILIATE_SALESREPORTOVERVIEW_SEARCH', 'backend.elements.searchs.affiliatesalesreportoverview.items');
define('AFFILIATE_COMMREPORTOVERVIEW_SEARCH', 'backend.elements.searchs.affiliatecommreportoverview.items');
define('AFFILIATE_PAYREPORTOVERVIEW_SEARCH', 'backend.elements.searchs.affiliatepaycommreportoverview.items');
define('AFFILIATE_PRODUCTREPORTOVERVIEW_SEARCH', 'backend.elements.searchs.affiliateproductreportoverview.items');

define('KIOTVIET_INVOICEREPORTOVERVIEW_SEARCH', 'backend.elements.searchs.kiotvietinvoicereportoverview.items');
define('KIOTVIET_CUSTOMERREPORTOVERVIEW_SEARCH', 'backend.elements.searchs.kiotvietcustomerreportoverview.items');
define('KIOTVIET_PRODUCTREPORTOVERVIEW_SEARCH', 'backend.elements.searchs.kiotvietproductreportoverview.items');
define('KIOTVIET_CATEPRODUCTREPORTOVERVIEW_SEARCH', 'backend.elements.searchs.kiotvietcateproductreportoverview.items');

define('KIOTVIET_CUSTOMER_SEARCH', 'backend.elements.searchs.kiotvietcustomer.items');
define('KIOTVIET_INVOICE_SEARCH', 'backend.elements.searchs.kiotvietinvoice.items');
define('KIOTVIET_PRODUCT_SEARCH', 'backend.elements.searchs.kiotvietproduct.items');
define('KIOTVIET_BRANCH_SEARCH', 'backend.elements.searchs.kiotvietbranch.items');

/*
|-------------------------------------------------------
| PARENT/SUB
|-------------------------------------------------------
 */
define('BANNER_PARENT', 'backend.elements.parent.banner.index');
define('BANNER_SUB', 'backend.elements.parent.banner.sub');
define('BANNER_GROUP_PARENT', 'backend.elements.parent.bannergroup.index');
define('BANNER_GROUP_SUB', 'backend.elements.parent.bannergroup.sub');

define('POST_PARENT', 'backend.elements.parent.post.index');
define('POST_SUB', 'backend.elements.parent.post.sub');
define('POST_GROUP_PARENT', 'backend.elements.parent.postgroup.index');
define('POST_GROUP_SUB', 'backend.elements.parent.postgroup.sub');

define('VOUCHER_PARENT', 'backend.elements.parent.voucher.index');
define('VOUCHER_SUB', 'backend.elements.parent.voucher.sub');
define('VOUCHER_GROUP_PARENT', 'backend.elements.parent.vouchergroup.index');
define('VOUCHER_GROUP_SUB', 'backend.elements.parent.vouchergroup.sub');

define('ADVERT_PARENT', 'backend.elements.parent.advert.index');
define('ADVERT_SUB', 'backend.elements.parent.advert.sub');
define('ADVERT_GROUP_PARENT', 'backend.elements.parent.advertgroup.index');
define('ADVERT_GROUP_SUB', 'backend.elements.parent.advertgroup.sub');

define('MENU_PARENT', 'backend.elements.parent.menu.index');
define('MENU_SUB', 'backend.elements.parent.menu.sub');

define('CAMPAIGN_PARENT', 'backend.elements.parent.campaign.index');
define('CAMPAIGN_SUB', 'backend.elements.parent.campaign.sub');
define('CAMPAIGN_GROUP_PARENT', 'backend.elements.parent.campaigngroup.index');
define('CAMPAIGN_GROUP_SUB', 'backend.elements.parent.campaigngroup.sub');

/*
|-------------------------------------------------------
| ADMINISTRATOR
|-------------------------------------------------------
 */
define('ADMIN_ROUTE', 'admins');
define('ADMIN_CSS_AND_JAVASCRIPT_VERSION', 26);
define('ADMIN_CSS_AND_JAVASCRIPT_PATH', '/public/admin/');

/*
|-------------------------------------------------------
| FRONTEND
|-------------------------------------------------------
 */
define('FRONTEND_ROUTE', 'release');
define('FRONTEND_CSS_AND_JAVASCRIPT_VERSION', 26);
define('FRONTEND_CSS_AND_JAVASCRIPT_PATH', '/public/release/');

/*
|-------------------------------------------------------
| SESSION KEY
|-------------------------------------------------------
*/
define('SESSION_SUCCESS_KEY', 'success_41led9myproductbeat2686new78');
define('SESSION_ERROR_KEY', 'error_12slow6061save99moment45mecentury');

/*
|-------------------------------------------------------
| INTERGRATION KEY
|-------------------------------------------------------
*/
define('INTERGRATION_SOURCE_NAME', 'leeandteevn');

/*
|-------------------------------------------------------
| URL
|-------------------------------------------------------
*/
define( 'PUBLIC_URL'        , '/public/' );
define( 'ADMIN_URL'         , PUBLIC_URL  . 'admin/' );
define( 'ADMIN_DIST_URL'    , ADMIN_URL  . 'dist/' );
define( 'ADMIN_DIST_ICON_URL', ADMIN_DIST_URL  . 'icons/' );

/*
|-------------------------------------------------------
| META TAGS
|-------------------------------------------------------
*/
define('META_TITLE', 'Lee&Tee - Túi xách thương hiệu Việt - Túi da thời trang');
define('META_DESCRIPTION', 'Túi da thời trang LeeAndTee phong cách cổ điển, dễ phối đồ, phù hợp với mọi đối tượng, thương hiệu Việt Nam');
define('META_KEYWORD', 'túi xách da, cặp sách, túi bác hồ, balo laptop, túi Ipad, bóp ví, túi da thời trang, túi dành cho nữ, túi nam, cửa hàng túi xách');


/*
|-------------------------------------------------------
| ORDER STATUS
|-------------------------------------------------------
*/
define('ORDER_STATUS', [
    'new' => 'Mới đặt',
    'pending' => 'Đang xử lý',
    'processing' => 'Đang giao hàng',
    'paid' => 'Đã thanh toán',
    'cancelled' => 'Đơn hàng hủy',
]);


/*
|-------------------------------------------------------
| VOUCHER TYPE
|-------------------------------------------------------
*/
define('VOUCHER_TYPE', [
    'percent' => '% giảm giá',
    'value' => 'Giá trị giảm',
]);

/*
|-------------------------------------------------------
| INTERGRATE KIOTVIET
|-------------------------------------------------------
*/
// General
define('KIOTVIET_DEFAULT_PAGESIZE', 100);
define('KIOTVIET_DEFAULT_LIMIT', 10);
define('KIOTVIET_DEFAULT_LIMIT_ARR', [20 => '20 Items', 30 => '30 Items', 40 => '40 Items', 50 => '50 Items']);
define('KIOTVIET_DEFAULT_ORD_DIRECTION', 'desc');
define('KIOTVIET_DEFAULT_ORD_BY', 'createdDate');

// Invoices
define('KIOTVIET_INC_DELIVERY', 0);
define('KIOTVIET_INC_PAYMENT', 0);
define('KIOTVIET_INVOICE_PAGINATE', 500);

// Customers
define('KIOTVIET_INC_CUST_GROUP', 0);
define('KIOTVIET_INC_CUST_SOCIAL', 0);
define('KIOTVIET_INC_CUST_TOTAL', 1);
define('KIOTVIET_CUSTOMER_PAGINATE', 500);
define('KIOTVIET_CUSTOMER_SPLT', '241357918'); // So sánh với khách hàng khởi tạo vào ngày 01/01/2022

// Products
define('KIOTVIET_INC_PROD_INV', 1);
define('KIOTVIET_INC_PROD_PRICEBOOK', 1);
define('KIOTVIET_INC_PROD_SERIAL', 1);
define('KIOTVIET_INC_PROD_BATCH', 1);
define('KIOTVIET_INC_PROD_QTY', 1);
define('KIOTVIET_INC_PROD_MATERIAL', 1);
define('KIOTVIET_PRODUCT_PAGINATE', 500);

// 
define('KIOTVIET_LEAD_BOPVI_QUANTITY', 90); // Sản lượng bán trung bình bóp ví
define('KIOTVIET_LEAD_BALO_QUANTITY', 40); // Sản lượng bán trung bình balo
define('KIOTVIET_LEAD_CAPXACH_QUANTITY', 20); // Sản lượng bán trung bình cặp xách
define('KIOTVIET_LEAD_DAYNIT_QUANTITY', 40); // Sản lượng bán trung bình dây nịt
define('KIOTVIET_LEAD_PHUKIEN_QUANTITY', 60); // Sản lượng bán trung bình phụ kiện
define('KIOTVIET_LEAD_TUIDEO_QUANTITY', 80); // Sản lượng bán trung bình túi đeo
define('KIOTVIET_LEAD_TUIDULICH_QUANTITY', 5); // Sản lượng bán trung bình túi du lịch
define('KIOTVIET_LEAD_TUIQUANG_QUANTITY', 10); // Sản lượng bán trung bình túi quàng
define('KIOTVIET_LEAD_TUIXACH_QUANTITY', 5); // Sản lượng bán trung bình túi xách