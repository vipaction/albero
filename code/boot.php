<?php
	setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251');
	include('data/constants.php');
	require_once('init/model.php');
	require_once('init/view.php');
	require_once('init/controller.php');
	require_once('init/route.php');
	require_once('init/db_init.php');
	Dbase::reset();
	Route::start();
