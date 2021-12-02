<?php
require_once('../../private/initialize.php');
$page_title = 'Bird: Member Menu'; 
include(SHARED_PATH . '/member-header.php'); 
// require_login();
$members = Member::find_all();
$session->verify_user_level();
?>

<h2>Main Menu</h2>
<a href="index.php">Members</a><br>
<a href="../birds/index.php">Birds</a><br>

<?php include(SHARED_PATH . '/footer.php'); ?>