<?php
$noyes_options = array(
    "no" => elgg_echo("option:no"),
    "yes" => elgg_echo("option:yes")
);
?>

<p>
    <label><?php echo elgg_echo('recaptcha:settings:site_key'); ?></label><br />
    <?php echo elgg_view('input/text', array(
        'name' => 'params[site_key]',
        'value' => $vars['entity']->site_key
    )); ?>
</p>
<p>
    <label><?php echo elgg_echo('recaptcha:settings:secret_key'); ?></label><br />
    <?php echo elgg_view('input/text', array(
        'name' => 'params[secret_key]',
        'value' => $vars['entity']->secret_key
    )); ?>
    <div class="elgg-subtext"><?php echo elgg_echo('recaptcha:settings:explanation'); ?>
    <?php
        echo elgg_view('output/url', array(
            'href' => 'https://www.google.com/recaptcha/',
            'target' => '_blank'
        ));
    ?>.</div>
</p>
<p>
    <label><?php echo elgg_echo('recaptcha:limit_registration'); ?></label><br />
    <?php echo elgg_view("input/dropdown", array(
        "name" => "params[limit_registration]",
        "value" => $vars['entity']->limit_registration,
        "options_values" => $noyes_options,
        "class" => "mls"
    )); ?>
    <div class="elgg-subtext"><?php echo elgg_echo('recaptcha:limit_registration:explanation'); ?>
</p>