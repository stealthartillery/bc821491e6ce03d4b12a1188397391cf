<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

ini_set("log_errors", 1);
ini_set("error_log", BASE_DIR.'storages/sword/'. 'error.log');

include 'LanterSword/Global.php';
include 'LanterSword/Guild.php'; $guild = new Guild();
include 'LanterSword/Quest.php'; $quest = new Quest();
include 'LanterSword/Confirmation.php'; $confirmation = new Confirmation();
include 'LanterSword/Friendlist.php'; $friendlist = new Friendlist();
include 'LanterSword/Trade.php'; $trade = new Trade();
include 'LanterSword/Duel.php'; $duel = new Duel();
include 'LanterSword/Battle.php'; $battle = new Battle();
include 'LanterSword/Inventory.php'; $inventory = new Inventory();
include 'LanterSword/Gen.php';

?>