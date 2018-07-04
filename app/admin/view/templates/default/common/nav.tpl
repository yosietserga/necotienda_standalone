<?php if ($logged) { ?>
<div id="sidr" class="sidr left" style="display: none;">
    <div class="center">
        <a id="header_logo" href="<?php echo $Url::createAdminUrl('common/home'); ?>"></a>
    </div>
    
    <div class="clear"></div>
    
    <div class="center">
        <img class="avatar" src="<?php echo $avatar; ?>" alt="<?php echo $this->user->getUserName(); ?>" />
        <p><?php echo $this->user->getUserName(); ?></p>
    </div>
       
    <div class="clear"></div>
    <!--
    <div class="center">
        <div class="grid_1" style="margin:0px;margin-left:15px;">
            <i class="fa fa-envelope fa-3x"></i>
            <span class="numberTop">3</span>
        </div>
        <div class="grid_1" style="margin:0px;">
            <span class="numberTop">3</span>
            <i class="fa fa-bell fa-3x"></i>
        </div>
        <div class="grid_1" style="margin:0px;">
            <span class="numberTop">3</span>
            <i class="fa fa-shopping-cart fa-3x"></i>
        </div>
    </div>
        
    <div class="clear"></div>
    -->
    <h2><?php echo $Language->get('tab_menu'); ?></h2>
    <ul class="menu">
        <li>
            <a href="<?php echo $Url::createAdminUrl('common/home'); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_home'); ?></a>
        </li>
        <li>
            <a><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_store'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/category'); ?>"><?php echo $Language->get('text_category'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/product'); ?>"><?php echo $Language->get('text_product'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/attribute'); ?>"><?php echo $Language->get('Product Attributes'); ?></a>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/manufacturer'); ?>"><?php echo $Language->get('text_manufacturer'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/download'); ?>"><?php echo $Language->get('text_download'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/review'); ?>"><?php echo $Language->get('text_review'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/store'); ?>"><?php echo $Language->get('text_shops'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-desktop"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_content'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/page'); ?>"><?php echo $Language->get('text_page'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/post_category'); ?>"><?php echo $Language->get('text_post_category'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/post'); ?>"><?php echo $Language->get('text_post'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/menu'); ?>"><?php echo $Language->get('text_menu'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/banner'); ?>"><?php echo $Language->get('text_banner'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/file'); ?>"><?php echo $Language->get('text_filemanager'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-book"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_admon'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <!--
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/sale'); ?>"><?php echo $Language->get('text_sale'); ?></a>
                </li>
                -->
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/order'); ?>"><?php echo $Language->get('text_order'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/payment'); ?>"><?php echo $Language->get('text_payment'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/coupon'); ?>"><?php echo $Language->get('text_coupon'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/customer'); ?>"><?php echo $Language->get('text_customer'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/customergroup'); ?>"><?php echo $Language->get('text_customer_group'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/balance'); ?>"><?php echo $Language->get('text_balances'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/bank'); ?>"><?php echo $Language->get('text_bank'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/bank_account'); ?>"><?php echo $Language->get('text_bank_account'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-book"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_tools'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('tool/backup'); ?>"><?php echo $Language->get('text_backup'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('tool/backup'); ?>"><?php echo $Language->get('text_restore'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('extension/module'); ?>"><?php echo $Language->get('text_module'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('extension/shipping'); ?>"><?php echo $Language->get('text_shipping'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('extension/payment'); ?>"><?php echo $Language->get('text_payment'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('extension/total'); ?>"><?php echo $Language->get('text_total'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_report'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/product/see'); ?>"><?php echo $Language->get('text_product'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/customer/see'); ?>"><?php echo $Language->get('text_customer'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/category/see'); ?>"><?php echo $Language->get('text_category'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/manufacturer/see'); ?>"><?php echo $Language->get('text_manufacturer'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/page/see'); ?>"><?php echo $Language->get('text_page'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/post/see'); ?>"><?php echo $Language->get('text_post'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/post_category/see'); ?>"><?php echo $Language->get('text_post_category'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-book"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_marketing'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('marketing/contact'); ?>"><?php echo $Language->get('text_contacts'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('marketing/list'); ?>"><?php echo $Language->get('text_contacts_lists'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('marketing/newsletter'); ?>"><?php echo $Language->get('text_newsletters'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('marketing/campaign'); ?>"><?php echo $Language->get('text_email_campaigns'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('marketing/message'); ?>"><?php echo $Language->get('text_email_associations'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('marketing/mailserver'); ?>"><?php echo $Language->get('SMTP Mail Servers'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-cloud-upload"></i>&nbsp;&nbsp;CPanel<i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('cpanel/email'); ?>"><?php echo $Language->get('Email Accounts'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-book"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_style'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('style/views'); ?>"><?php echo $Language->get('text_views'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('style/theme'); ?>"><?php echo $Language->get('text_themes'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('style/template'); ?>"><?php echo $Language->get('text_templates'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('style/editor'); ?>"><?php echo $Language->get('text_html_editor'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('style/widget'); ?>"><?php echo $Language->get('text_widgets'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-book"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_system'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('setting/setting'); ?>"><?php echo $Language->get('text_setting'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('user/user'); ?>"><?php echo $Language->get('text_user'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('user/user_permission'); ?>"><?php echo $Language->get('text_user_group'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/language'); ?>"><?php echo $Language->get('text_language'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/currency'); ?>"><?php echo $Language->get('text_currency'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/order_status'); ?>"><?php echo $Language->get('text_order_status'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/stock_status'); ?>"><?php echo $Language->get('text_stock_status'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/tax_class'); ?>"><?php echo $Language->get('text_tax_class'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/geo_zone'); ?>"><?php echo $Language->get('text_geo_zone'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/weight_class'); ?>"><?php echo $Language->get('text_weight_class'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/length_class'); ?>"><?php echo $Language->get('text_length_class'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('tool/update'); ?>"><?php echo $Language->get('Updates'); ?></a>
                </li>
            </ul>
        </li>
    </ul>
</div>


<div id="sidr-right" class="sidr right" style="display: none;">
    <div class="center">
        <a id="header_logo" href="<?php echo $Url::createAdminUrl('common/home'); ?>"></a>
    </div>
    
    <div class="clear"></div>
    
    <div class="center">
        <img class="avatar" src="<?php echo HTTP_IMAGE; ?>data/profiles/avatar.png" alt="Me" />
        <p><?php echo $this->user->getUserName(); ?></p>
    </div>
       
    <div class="clear"></div>
    
    <div class="center">
        <div class="grid_1" style="margin:0px;margin-left:15px;">
            <i class="fa fa-envelope fa-3x"></i>
            <span class="numberTop">3</span>
        </div>
        <div class="grid_1" style="margin:0px;">
            <span class="numberTop">3</span>
            <i class="fa fa-bell fa-3x"></i>
        </div>
        <div class="grid_1" style="margin:0px;">
            <span class="numberTop">3</span>
            <i class="fa fa-shopping-cart fa-3x"></i>
        </div>
    </div>
        
    <div class="clear"></div>

    <h2><?php echo $Language->get('tab_menu'); ?></h2>
    <ul class="menu">
        <li>
            <a href="<?php echo $Url::createAdminUrl('common/home'); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_home'); ?></a>
        </li>
        <li>
            <a><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_store'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/category'); ?>"><?php echo $Language->get('text_category'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/product'); ?>"><?php echo $Language->get('text_product'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/attribute'); ?>"><?php echo $Language->get('Product Attributes'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/manufacturer'); ?>"><?php echo $Language->get('text_manufacturer'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/download'); ?>"><?php echo $Language->get('text_download'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/review'); ?>"><?php echo $Language->get('text_review'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/store'); ?>"><?php echo $Language->get('text_shops'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-desktop"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_content'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/page'); ?>"><?php echo $Language->get('text_page'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/post_category'); ?>"><?php echo $Language->get('text_post_category'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/post'); ?>"><?php echo $Language->get('text_post'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/menu'); ?>"><?php echo $Language->get('text_menu'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/banner'); ?>"><?php echo $Language->get('text_banner'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/file'); ?>"><?php echo $Language->get('text_filemanager'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-book"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_admon'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/sale'); ?>"><?php echo $Language->get('text_sale'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/order'); ?>"><?php echo $Language->get('text_order'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/payment'); ?>"><?php echo $Language->get('text_payment'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/coupon'); ?>"><?php echo $Language->get('text_coupon'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/customer'); ?>"><?php echo $Language->get('text_customer'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/customergroup'); ?>"><?php echo $Language->get('text_customergroup'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/balance'); ?>"><?php echo $Language->get('text_balances'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/bank'); ?>"><?php echo $Language->get('text_bank'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/bank_account'); ?>"><?php echo $Language->get('text_bank_account'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-book"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_tools'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('tool/backup'); ?>"><?php echo $Language->get('text_backup'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('tool/backup'); ?>"><?php echo $Language->get('text_restore'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('extension/module'); ?>"><?php echo $Language->get('text_module'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('extension/shipping'); ?>"><?php echo $Language->get('text_shipping'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('extension/payment'); ?>"><?php echo $Language->get('text_payment'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('extension/total'); ?>"><?php echo $Language->get('text_total'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_report'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/product/see'); ?>"><?php echo $Language->get('text_product'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('sale/customer/see'); ?>"><?php echo $Language->get('text_customer'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/category/see'); ?>"><?php echo $Language->get('text_category'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('store/manufacturer/see'); ?>"><?php echo $Language->get('text_manufacturer'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/page/see'); ?>"><?php echo $Language->get('text_page'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/post/see'); ?>"><?php echo $Language->get('text_post'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('content/post_category/see'); ?>"><?php echo $Language->get('text_post_category'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-book"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_marketing'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('marketing/contact'); ?>"><?php echo $Language->get('text_contacts'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('marketing/list'); ?>"><?php echo $Language->get('text_contacts_lists'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('marketing/newsletter'); ?>"><?php echo $Language->get('text_newsletters'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('marketing/campaign'); ?>"><?php echo $Language->get('text_email_campaigns'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('marketing/message'); ?>"><?php echo $Language->get('text_email_associations'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-book"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_style'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('style/views'); ?>"><?php echo $Language->get('text_views'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('style/theme'); ?>"><?php echo $Language->get('text_themes'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('style/template'); ?>"><?php echo $Language->get('text_templates'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('style/editor'); ?>"><?php echo $Language->get('text_html_editor'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('style/widget'); ?>"><?php echo $Language->get('text_widgets'); ?></a>
                </li>
            </ul>
        </li>
        <li>
            <a><i class="fa fa-book"></i>&nbsp;&nbsp;<?php echo $Language->get('tab_system'); ?><i class="fa fa-arrow-circle-right" style=float:right;margin-top:13px;margin-right:5px;"></i></a>
            <ul>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('setting/setting'); ?>"><?php echo $Language->get('text_setting'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('user/user'); ?>"><?php echo $Language->get('text_user'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('user/user_permission'); ?>"><?php echo $Language->get('text_user_group'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/language'); ?>"><?php echo $Language->get('text_language'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/currency'); ?>"><?php echo $Language->get('text_currency'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/order_status'); ?>"><?php echo $Language->get('text_order_status'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/stock_status'); ?>"><?php echo $Language->get('text_stock_status'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/tax_class'); ?>"><?php echo $Language->get('text_tax_class'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/geo_zone'); ?>"><?php echo $Language->get('text_geo_zone'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/weight_class'); ?>"><?php echo $Language->get('text_weight_class'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('localisation/length_class'); ?>"><?php echo $Language->get('text_length_class'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('setting/cache'); ?>"><?php echo $Language->get('Manage Cache'); ?></a>
                </li>
                <li>
                    <a href="<?php echo $Url::createAdminUrl('tool/update'); ?>"><?php echo $Language->get('Updates'); ?></a>
                </li>
            </ul>
        </li>
    </ul>
</div>

<script>
$(document).ready(function() {
    $('#simple-menu').sidr();
    $('#sidr ul ul').slideUp();
    $('#sidr > ul > li a').on('click', function(e){
        $(this).parent('li').find('ul').slideToggle();
    }).children().click(function(e) {
        e.stopPropagation();
    });
    
    $('#right-menu').sidr({
      name: 'sidr-right',
      side: 'right'
    });
});
</script>

<div class="clear"></div>
<?php } ?>