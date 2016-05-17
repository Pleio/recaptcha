<?php
require_once(dirname(__FILE__) . "/../../vendor/autoload.php");

elgg_register_event_handler('init' , 'system', 'recaptcha_init');

function recaptcha_init() {
    if (!is_recaptcha_enabled()) {
        return;
    }

    elgg_register_js('recaptcha', 'https://www.google.com/recaptcha/api.js?hl=' . get_current_language());
    elgg_register_plugin_hook_handler('actionlist', 'captcha', 'image_captcha_actionlist_hook');

    $actions = array(
        'register',
        'user/requestnewpassword'
    );

    foreach ($actions as $action) {
        elgg_register_plugin_hook_handler('action', $action, 'recaptcha_action_hook');
    }
}

function is_recaptcha_enabled() {
    $key = elgg_get_plugin_setting('site_key', 'recaptcha');
    $secret = elgg_get_plugin_setting('secret_key', 'recaptcha');

    if ($key && $secret) {
        return true;
    }

    return false;
}

function recaptcha_action_hook($hook, $entity_type, $returnvalue, $params) {
    $response = get_input('g-recaptcha-response');

    if ($response && recaptcha_validate_code($response)) {
        return true;
    } else {
        register_error(elgg_echo('recaptcha:could_not_validate'));
        forward(REFERER);
    }
}

function recaptcha_validate_code($response) {
    $client = new GuzzleHttp\Client();

    try {
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', array(
            'body' => array(
                'secret' => elgg_get_plugin_setting('secret_key', 'recaptcha'),
                'response' => $response,
                'remoteip' => recaptcha_get_user_ip()
            )
        ));

        $data = $response->json();
        if (isset($data['success']) && $data['success'] === true) {
            return true;
        } else {
            return false;
        }
    } catch (RequestException $e) {
        return false;
    }
}

function recaptcha_get_user_ip() {
    if (isset($_SERVER['HTTP_X_REAL_IP'])) {
        return $_SERVER['HTTP_X_REAL_IP'];
    }

    return $_SERVER['REMOTE_ADDR'];
}