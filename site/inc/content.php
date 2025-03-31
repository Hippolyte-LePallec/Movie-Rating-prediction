<?php
$action = GETPOST('action') ?? 'index';
$element = GETPOST('element') ?? ".";
$target_c = (dirname(__FILE__) . "/../$element/controllers/$action.php");
$target_v = (dirname(__FILE__) . "/../$element/views/$action.php");
if (
    ($target_c && is_file($target_c))
    && ($target_v && is_file($target_v))
) {
    include($target_c);
    include($target_v);
} else
    include(dirname(__FILE__) . '/notfound.php');
