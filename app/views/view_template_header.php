<!DOCTYPE html>
<html lang="ru">
    <head>
        <title><?php echo $_SESSION['titlename'];?></title>
        <meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo $_SESSION['titlename'];?>">
        <meta name="author" content="ALIK-UANIC">
        <meta http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"); ?> GMT">
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico?<?php echo rand(1111111111, 9999999999);?>">
<!--		<link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet">-->
        <link rel="stylesheet" type="text/css" href="../../css/<?php echo $_SESSION['bs_style'];?>/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="../../css/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="../../css/jquery-ui.theme.css">
		<!--		<link rel="stylesheet" type="text/css" href="../../css/jquery-ui.structure.css">
		<link rel="stylesheet" type="text/css" href="../../css/jqgrid/jquery-ui-1.10.3.custom.css">-->
<!--		<link rel="stylesheet" type="text/css" href="../../css/jqgrid/ui.jqgrid.css">-->
		<link rel="stylesheet" type="text/css" href="../../css/jqgrid/ui.jqgrid-bootstrap-ui.css">
		<link rel="stylesheet" type="text/css" href="../../css/jqgrid/ui.jqgrid-bootstrap.css">
<!--        <link rel="stylesheet" type="text/css" href="../../css/<?php echo $_SESSION['bs_style'];?>/bootstrap-theme.css">
		<link rel="stylesheet" type="text/css" href="../../css/signin.css">
		<link rel="stylesheet" type="text/css" href="../../css/alik-theme/jquery-ui-1.10.3.custom.css">
		<link rel="stylesheet" type="text/css" href="../../css/ui.jqgrid.css">
        <link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css">
		<link rel="stylesheet" type="text/css" href="../../css/slidorion.css">-->
		<link rel="stylesheet" type="text/css" href="/css/select2.css">
<!--		<link rel="stylesheet" type="text/css" href="/css/select24.css">-->
		<link rel="stylesheet" type="text/css" href="/css/flexslider.css">
        <link rel="stylesheet" type="text/css" href="../../css/fs.css">
<!--		<link rel="stylesheet" type="text/css" href="../../css/fs_A15.css">-->

<!--		<script src="../../js/jquery-1.11.3.js" type="text/javascript"></script>-->
		<script src="/js/jquery-2.1.4.js" type="text/javascript"></script>
		<script src="/js/bootstrap.js" type="text/javascript"></script>
		<script src="/js/jquery-ui.js" type="text/javascript"></script><!--
		<script src="/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>-->
		<script src="/js/i18n/grid.locale-ru.js" type="text/javascript"></script>
<!--		<script src="/js/jquery.jqGrid.min.js" type="text/javascript"></script>-->
		<script src="/js/jquery.jqGrid.js" type="text/javascript"></script>
		<script src="/js/jquery.jqGrid.setColWidth.js" type="text/javascript"></script>
		<script src="/js/select2.min.js" type="text/javascript"></script>
<!--		<script src="/js/select24full.js" type="text/javascript"></script>-->
		<script src="/js/bootstrap3-typeahead.js" type="text/javascript"></script>
<!--		<script src="/js/typeahead.jquery.js" type="text/javascript"></script>-->
		<script src="/js/jquery.flexslider.js" type="text/javascript"></script>
		<script src="/js/emulatetab.joelpurra.min.js" type="text/javascript"></script>
<!--		<script src="../../js/jquery.jqGrid.js" type="text/javascript"></script>-->
<!--
		<script src="../../js/i18n/grid.locale-en.js" type="text/javascript"></script>
		<script src="../../js/i18n/grid.locale-ru.js" type="text/javascript"></script>
		<script src="../../js/i18n/datepicker-ru.js" type="text/javascript"></script>
		<script src="../../js/jquery.jqGrid.min.js" type="text/javascript"></script>
		<script src="../../js/jquery.jqGrid.src.js" type="text/javascript"></script>
		<script src="../../js/jqgrid-filter.js" type="text/javascript"></script>
		<script src="../../js/jquery.dataTables.min.js" type="text/javascript"></script>
		<script src="../../js/dataTables.bootstrap.js" type="text/javascript"></script>
		<script src="../../js/jquery.easing.js" type="text/javascript"></script>
		<script src="../../js/jquery.slidorion.min.js" type="text/javascript"></script>-->
<?php
if ($content_view != 'view_login.php') {
?>
		<style type="text/css">
            body {
				background: url('/image/pattern.jpg') repeat-y;
            }
        </style>
<?php
}
?>
    </head>
	<body>
