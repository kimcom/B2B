<?php
//session_save_path("d:\\sites\\Session");
session_start();
	$_SESSION['bs_style'] = 'bs-default';
	//$_SESSION['bs_style'] = 'bs-cerulean'; //A15

//	$_SESSION['bs_style'] = 'bs-journal';
//	$_SESSION['bs_style'] = 'bs-paper';
//	$_SESSION['bs_style'] = 'bs-readable';
//	$_SESSION['bs_style'] = 'bs-simplex';
	$_SESSION['nav_style'] = 'default';
	//$_SESSION['nav_style'] = 'inverse'; //A15

	$_SESSION['server_port'] = '3306';
	$_SESSION['server_user'] = 'b2b';
	$_SESSION['server_pass'] = '149521';

if (!isset($_SESSION['sitename']))
    $_SESSION['sitename'] = 'Система для оптовых клиентов'.'&trade;';
if (!isset($_SESSION['titlename']))
    $_SESSION['titlename'] = 'Система для оптовых клиентов компании Сузирье'.'&trade;';
if (!isset($_SESSION['company']))
	$_SESSION['company'] = 'Сузирье™';
if (!isset($_SESSION['dbname']))
	$_SESSION['dbname'] = 'b2b';
if (!isset($_SESSION['siteEmail']))
	$_SESSION['siteEmail'] = 'b2b@priroda.ua';
if (!isset($_SESSION['adminEmail']))
	$_SESSION['adminEmail'] = 'kimcom@ukr.net';
if (!isset($_SESSION['UserID']))
    $_SESSION['UserID'] = 0;
if (!isset($_SESSION['UserName']))
    $_SESSION['UserName'] = "";
if (!isset($_SESSION['UserEMail']))
    $_SESSION['UserEMail'] = "";
if (!isset($_SESSION['UserPost']))
    $_SESSION['UserPost'] = "";
if (!isset($_SESSION['ClientID']))
    $_SESSION['ClientID'] = 0;
if (!isset($_SESSION['ClientName']))
    $_SESSION['ClientName'] = "";
if (!isset($_SESSION['access']))
    $_SESSION['access'] = false;
if (!isset($_SESSION['AccessLevel']))
    $_SESSION['AccessLevel'] = 0;
if (!isset($_SESSION['CurrentOrderID']))
    $_SESSION['CurrentOrderID'] = 0;
?>