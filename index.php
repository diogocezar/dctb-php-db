<?php
require_once('app/Oracle.php');
$o = new Oracle();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport"              content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="description"           content="">
    <link rel="canonical"              href="">
    <meta name="publisher"             content="">
    <meta name="author"                content="">
    <meta name="keywords"              content="">
    <meta property="og:url"            content="">
    <meta property="og:title"          content="">
    <meta property="og:site_name"      content="">
    <meta property="og:description"    content="">
    <meta property="og:image"          content="">
    <meta property="og:image:type"     content="image/">
    <meta property="og:image:width"    content="470">
    <meta property="og:image:height"   content="246">
    <meta name="twitter:card"          content="summary_large_image">
    <meta name="twitter:site"          content="@">
    <meta name="twitter:title"         content="">
    <meta name="twitter:url"           content="">
    <meta name="twitter:image:src"     content="">
    <meta name="twitter:description"   content="">
    <meta itemprop="name"              content="">
    <meta itemprop="description"       content="">
    <meta itemprop="image"             content="">
    <title>Simple Php Database</title>
    <link rel="stylesheet"       href="./assets/css/<?php echo $o->getDist(); ?>/base/base.css">
    <link rel="stylesheet"       href="./assets/css/<?php echo $o->getDist(); ?>/pages/index.css">
</head>
<body>
<?php print_R($o->getItem()); ?>
</body>
<script src="./js/<?php echo $o->getDist(); ?>/jquery/jquery.js"></script>
<script src="./js/<?php echo $o->getDist(); ?>/oracle/oracle.js"></script>
<script src="./js/<?php echo $o->getDist(); ?>/objects/index.js"></script>
</html>