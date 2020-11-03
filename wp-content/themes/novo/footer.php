			<?php if(yprm_get_theme_setting('footer_social_buttons') == 'show' && $social_links = yprm_build_social_links('with-label')) { ?>
				<div class="footer-social-button">
					<?php echo $social_links ?>
				</div>
			<?php } ?>
			<?php if(yprm_get_theme_setting('footer') == 'show') { ?>
				<footer class="site-footer main-row">
					<div class="container">
						<div class="row">
              <div class="<?php echo esc_attr(yprm_get_theme_setting('footer_col_1')) ?>">
                <?php if(yprm_get_theme_setting('footer_logo') == 'show') { ?>
                  <div class="logo"><?php echo yprm_site_footer_logo(); ?></div>
								<?php } if(is_active_sidebar('footer-1')) { ?>
									<?php dynamic_sidebar('footer-1'); ?>
								<?php } ?>
							</div>
							<?php if(is_active_sidebar('footer-2')) { ?>
							<div class="<?php echo esc_attr(yprm_get_theme_setting('footer_col_2')) ?>">
								<?php dynamic_sidebar('footer-2'); ?>
							</div>
							<?php } if(is_active_sidebar('footer-3')) { ?>
							<div class="<?php echo esc_attr(yprm_get_theme_setting('footer_col_3')) ?>">
								<?php dynamic_sidebar('footer-3'); ?>
							</div>
							<?php } if(is_active_sidebar('footer-4')) { ?>
							<div class="<?php echo esc_attr(yprm_get_theme_setting('footer_col_4')) ?>">
								<?php dynamic_sidebar('footer-4'); ?>
							</div>
							<?php } ?>
            </div>
            <?php if(yprm_get_theme_setting('footer_scroll_up') == 'show') { ?>
              <div id="scroll-top" class="scroll-up-button basic-ui-icon-up-arrow"></div>
            <?php } ?>
					</div>
				</footer>
			<?php } if(yprm_get_theme_setting('use_gdpr') == 'true') { ?>
				<div class="gdpr-modal-block">
					<div class="close basic-ui-icon-cancel"></div>
					<div class="text"><?php echo wp_kses(yprm_get_theme_setting('gdpr_text'), 'post') ?></div>
				</div>
			<?php } ?>
		</div>
		
		<?php wp_footer(); ?>

	</body>
</html>
