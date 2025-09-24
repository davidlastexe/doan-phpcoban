<?php
const DEV = true;

// declare database config
const _HOST = "localhost";
const _PORT = "3306";
const _DB = "snack_shop_dev";
const _USER = "root";
const _PASS = "";
const _DRIVER = "mysql";

// error debug
const _DEBUG = true;

// host setup
const _DEV_HOST_URL = "https://fluffy-telegram-r79rvrrrr4h6gw-80.app.github.dev/doan-phpcoban";
const BASE_DIR = '/doan-phpcoban';

define('_HOST_URL', DEV ? _DEV_HOST_URL : "http://" . $_SERVER["HTTP_HOST"] . "/doan-phpcoban");
define('_HOST_URL_PUBLIC', _HOST_URL . "/public");
define('_HOST_URL_VIEWS', _HOST_URL . "/app/Views");

// path setup
define('_PROJECT_ROOT', __DIR__ . '/../..');
define('_PATH_URL_APP', _PROJECT_ROOT . '/app');
define('_PATH_URL_CONTROLLERS', _PROJECT_ROOT . '/app/Controllers');
define('_PATH_URL_CORE', _PROJECT_ROOT . '/app/Core');
define('_PATH_URL_VIEWS', _PROJECT_ROOT . '/app/Views');