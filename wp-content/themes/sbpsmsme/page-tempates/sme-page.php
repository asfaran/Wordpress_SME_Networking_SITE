<?php

/*
  Template Name: SME Page Handler
 */
//$_GET['sme-type'] = "sme";
if (!empty($_GET['sme-type']))
{
    $sme_type = filter_var($_GET['sme-type'], FILTER_SANITIZE_STRING);
}
else
{
    header("location: /");
}

sbps_check_permission("sme-post");

get_header();
?>

<?php

switch ($sme_type)
{
    case 'sme':
        include "private/sme.php";
        break;
    case 'investment':
        include "private/investment.php";
        break;
    case 'partnership':
        include "private/partnership.php";
        break;
    case 'sp':
        include "private/service_providers.php";
        break;
}
?>

<?php get_footer() ?>