<?php /* Smarty version 2.6.20, created on 2013-03-24 23:22:45
         compiled from notification-list.tpl */ ?>
<ul class="pm-notifications">
	<?php $_from = $this->_tpl_vars['notification_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['notification_id'] => $this->_tpl_vars['el']):
?>
		<?php if ($this->_tpl_vars['el']['activity_type'] == @ACT_TYPE_FOLLOW): ?>
			<?php $this->assign('main_href', $this->_tpl_vars['el']['metadata']['from_userdata']['profile_url']); ?>
		<?php else: ?>
			<?php $this->assign('main_href', $this->_tpl_vars['el']['metadata']['object']['video_href']); ?>
		<?php endif; ?>
		
		<li <?php if ($this->_tpl_vars['el']['seen'] == 0): ?> class="pm-notification-unread"<?php endif; ?>>
        	<div class="pm-n-avatar">
        		<?php if ($this->_tpl_vars['el']['metadata']['from_userdata']['id'] != 0): ?>
					<a href="<?php echo $this->_tpl_vars['el']['metadata']['from_userdata']['profile_url']; ?>
"><img src="<?php echo $this->_tpl_vars['el']['metadata']['from_userdata']['avatar_url']; ?>
" width="40" height="" border="0" /></a>
				<?php else: ?>
					<img src="<?php echo $this->_tpl_vars['el']['metadata']['from_userdata']['avatar_url']; ?>
" width="40" height="" border="0" />
				<?php endif; ?>
            </div>
            <div class="pm-n-activity">
	            <?php if ($this->_tpl_vars['el']['metadata']['from_userdata']['id'] != 0): ?>
					<a href="<?php echo $this->_tpl_vars['el']['metadata']['from_userdata']['profile_url']; ?>
"><?php echo $this->_tpl_vars['el']['metadata']['from_userdata']['name']; ?>
</a>
				<?php else: ?>
					<strong><?php echo $this->_tpl_vars['el']['metadata']['from_userdata']['name']; ?>
</strong>
				<?php endif; ?>
                <?php if ($this->_tpl_vars['el']['activity_type'] == @ACT_TYPE_LIKE): ?><?php endif; ?>
                <?php echo $this->_tpl_vars['el']['lang']; ?>

                <?php if ($this->_tpl_vars['el']['metadata']['object_type'] == @ACT_OBJ_VIDEO): ?>
                    <a href="<?php echo $this->_tpl_vars['el']['metadata']['object']['video_href']; ?>
"><?php echo $this->_tpl_vars['el']['metadata']['object']['video_title']; ?>
</a>
                <?php endif; ?>
                <div class="pm-ml-activity-date"><?php echo $this->_tpl_vars['el']['time_since']; ?>
 <?php echo $this->_tpl_vars['lang']['ago']; ?>
</div>
			</div>
            <div class="clearfix"></div>
		</li>
	<?php endforeach; else: ?>
		<li><?php echo $this->_tpl_vars['lang']['notification_list_empty']; ?>
</li>
	<?php endif; unset($_from); ?>
</ul>
<?php if ($this->_tpl_vars['total_notifications'] == 7): ?>
	<div class="clearfix"></div>
	<span name="notifications_load_more" id="btn_notifications_load_more"></span>
<?php endif; ?>