<?php if (!defined('BASEPATH')) exit('no direct script access allowed');

ini_set("log_errors", 1);
ini_set("error_log", BASE_DIR.'storages/'. 'error.log');

include BASE_DIR.'lantergen.php';
include 'LanterSword/Global.php';
include 'LanterSword/Guild.php'; $guild = new Guild();
include 'LanterSword/Speak.php'; $speak = new Speak();
// include 'LanterSword/Quest.php'; $quest = new Quest();
include 'LanterSword/Confirmation.php'; $confirmation = new Confirmation();
include 'LanterSword/Friendlist.php'; $friendlist = new Friendlist();
include 'LanterSword/Trade.php'; $trade = new Trade();
include 'LanterSword/Map.php'; $map = new Map();
include 'LanterSword/Duel.php'; $duel = new Duel();
include 'LanterSword/Battle.php'; $battle = new Battle();
include 'LanterSword/Equipment.php'; $equipment = new Equipment();
include 'LanterSword/Inventory.php'; $inventory = new Inventory();
include 'LanterSword/ItemMall.php'; $item_mall = new ItemMall();
include 'LanterSword/Shop.php'; $shop = new Shop();
include 'LanterSword/Gen.php';

?>