<?php
error_reporting(false);
date_default_timezone_set('Europe/Moscow');

require (__DIR__ . '/lib/VKApplication.Class.php');
require (__DIR__ . '/lib/VK.Class.php');

use VKApplication as App;

VK::setup('access_token');

App::run();

App::type('confirmation', function () : void {
    App::close('confirmation_code');
});

App::type('message_new', function (array $json) : void {
   App::on('Привет', function (array $json) : void {
      VK::sendMessage([
          'user_ids' => $json['object']['message']['from_id'],
          'message' => 'Привет!',
      ]);
   });

   VK::sendMessage([
      'user_ids' => $json['object']['message']['from_id'],
      'message' => 'Неизвестное сообщение.',
   ]);

   App::close();
});
