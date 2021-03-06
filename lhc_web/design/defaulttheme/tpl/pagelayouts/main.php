<!DOCTYPE html>

<html <?php if (!isset($Result['anonymous']) && (int)erLhcoreClassModelUserSetting::getSetting('dark_mode',0) == 1) : ?>dark="true"<?php endif;?> lang="<?php echo erConfigClassLhConfig::getInstance()->getDirLanguage('content_language')?>" dir="<?php echo erConfigClassLhConfig::getInstance()->getDirLanguage('dir_language')?>" ng-app="lhcApp">
	<head>
		<?php include_once(erLhcoreClassDesign::designtpl('pagelayouts/parts/page_head.tpl.php'));?>
	</head>
<body id="admin-body" class="pr-0 <?php isset($Result['body_class']) ? print $Result['body_class'] : ''?>" ng-cloak ng-controller="LiveHelperChatCtrl as lhc" ng-init="lhc.getToggleWidget('pending_chats_sort',<?php (int)erLhcoreClassModelChatConfig::fetchCache('reverse_pending')->current_value == 1 ? print "'true'" : print "'false'"?>);">
<?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/page_top_content_multiinclude.tpl.php'));?>
<?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/top_head_multiinclude.tpl.php'));?>

<?php include_once(erLhcoreClassDesign::designtpl('pagelayouts/parts/top_menu.tpl.php'));?>

<div id="wrapper" ng-cloak ng-class="{toggled: lmtoggle, toggledr : lmtoggler}">

<?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/sidemenu/sidemenu.tpl.php'));?>

    <div id="page-content-wrapper">

        <?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/path.tpl.php'));?>

        <?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/can_use_chat.tpl.php'));?>
    
        <div class="row">
        
            <div id="middle-column-page" class="col-xl-<?php $canUseChat == true && (!isset($Result['hide_right_column']) || $Result['hide_right_column'] == false) ? print '9' : print '12'; ?> pb-1">
            	<?php echo $Result['content']; ?>
            </div>
            
            <?php if ($canUseChat == true && (!isset($Result['hide_right_column']) || $Result['hide_right_column'] == false)) :    
            $pendingTabEnabled = (int)erLhcoreClassModelUserSetting::getSetting('enable_pending_list',1);
            $activeTabEnabled = (int)erLhcoreClassModelUserSetting::getSetting('enable_active_list',1);
            $closedTabEnabled = (int)erLhcoreClassModelUserSetting::getSetting('enable_close_list',0);
            $mchatsTabEnabled = (int)erLhcoreClassModelUserSetting::getSetting('enable_mchats_list',1);
            $unreadTabEnabled = (int)erLhcoreClassModelUserSetting::getSetting('enable_unread_list',1); ?>
            <div class="columns col-xl-3 right-column-page-general" translate="no" id="right-column-page" ng-cloak>
            	
                <?php include(erLhcoreClassDesign::designtpl('lhchat/lists_panels/transfer_panel_container_pre.tpl.php'));?>
                
                <?php if ($transfer_panel_container_pre_enabled == true) : ?>
                	<?php include(erLhcoreClassDesign::designtpl('lhchat/lists_panels/transfer_panel_container.tpl.php'));?>
                <?php endif;?>
                
                <?php include(erLhcoreClassDesign::designtpl('lhchat/lists_panels/right_panel_container.tpl.php'));?>
            </div>
            <?php endif; ?>
        
        </div>
    
    </div>

</div>


<?php include_once(erLhcoreClassDesign::designtpl('pagelayouts/parts/page_footer.tpl.php'));?>

<?php include(erLhcoreClassDesign::designtpl('pagelayouts/parts/page_bottom_content_multiinclude.tpl.php'));?>

<?php if (erConfigClassLhConfig::getInstance()->getSetting( 'site', 'debug_output' ) == true) {
		$debug = ezcDebug::getInstance();
        echo "<div><pre class='bg-light text-dark m-2 p-2 border'>" . json_encode(erLhcoreClassUser::$permissionsChecks, JSON_PRETTY_PRINT) . "</pre></div>";
		echo $debug->generateOutput();
} ?>

</body>
</html>