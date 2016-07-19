<?php

require 'Onyx/autoloader.php';

use Onyx\DataProviders\JSONFileDb;
use Onyx\Libs\User;
use Onyx\Onyx;

$app = new Onyx();

$app->set_db(new JSONFileDb(
    'data.json'
));

$app->set_user_roles(function (User $user, JSONFileDb $db) use ($app) {
    if (!$user->is_authenticated()) return;
    $user->set_roles($db->get('users')[$user->id]['roles']);
});

$app
    ->route('/^login/')
    ->via(['GET', 'POST', 'DELETE']);

$app
    ->route('/^home/')
    ->via(['GET']);

$app
    ->route('/^internal/')
    ->via(['GET'])
    ->roles(['user']);

$app->run();