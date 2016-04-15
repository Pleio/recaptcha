<?php if (is_recaptcha_enabled()): ?>
    <?php elgg_load_js('recaptcha'); ?>
    <p>
        <div class="g-recaptcha" data-sitekey="<?php echo elgg_get_plugin_setting('site_key', 'recaptcha'); ?>"></div>
    </p>
<?php endif ?>