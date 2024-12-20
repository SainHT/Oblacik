<?php
require 'libs/Smarty.class.php';  # framework
require 'dbconnect.php';  # db_connection

$smarty = new \Smarty\Smarty;

$smarty->debugging = false;
$smarty->caching = false;

// demo
// $smarty->assign("Name", "Fred Irving Johnathan Bradley Peppergill", true);
// $smarty->assign("FirstName", array("John", "Mary", "James", "Henry"));
// $smarty->assign("LastName", array("Doe", "Smith", "Johnson", "Case"));
// $smarty->assign(
//     "Class",
//     array(
//         array("A", "B", "C", "L"),
//         array("o", "F", "G", "H"),
//         array("I", "J", "K", "L"),
//         array("M", "N", "O", "Q")
//     )
// );
// $smarty->assign(
//     "contacts",
//     array(
//         array("phone" => "1", "fax" => "2", "cell" => "3"),
//         array("phone" => "555-4444", "fax" => "555-3333", "cell" => "760-1234")
//     )
// );
// $smarty->assign("option_values", array("NY", "NE", "KS", "IA", "OK", "TX"));
// $smarty->assign("option_output", array("New York", "Nebraska", "Kansas", "Iowa", "Oklahoma", "Texas"));
// $smarty->assign("option_selected", "NE");

$smarty->display('index.tpl');
