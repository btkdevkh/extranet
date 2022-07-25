<?php

require_once './app/config/config.php';
require_once APPROOT . '/Autoloader.php';

Autoloader::loadClass();
new Application;