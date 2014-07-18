<?php
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT'] . "/../config/lork/items_text.php");
	require_once($_SERVER['DOCUMENT_ROOT'] . "/lork/includes/textengine.php");    
	
	define("WELCOME", "Lork v0.1");
	define("CNF", "This is what you sound like, 'Blah, blah, blah.' I have no idea what you are saying! Try <b>HELP</b>.");
	define("THATDOESNTWORK", "That doesn't work.");
	define("SWPAG", "SHALL WE PLAY A GAME?");

	define("ALLOWEDTAGS", "<BR><B><TABLE><TR><TD><FONT>");
	define("BR", "<BR />");
	define("PROMPT", "&gt;&nbsp;");

	define("MAXSTRLEN", 45);

	define("DBG", "BWAHAHAHA! You were <font color='#FE2E2E'>eaten by a GRUE</font><font color='#ccc'>!</font>");
	define("RESTART", "GAME OVER. Feel free to <b>RESTART</b>.");
	define("NOINVENTORY", "You don't have anything in your inventory.");
	define("LAW", "Oh yes. That is interesting isn't it. I've never seen an object like before. Maybe we could look at other unspecified objects together or you could specify what you want to look at!");
	define("GRUE", "It's dark. You feel something breathing on your shoulder. It's breath smells of decaying flesh and blood. You begin to start a thought about what you could have done to prevent this, but that thought is interrupted by the monster attacking and killing you.");
	define("YCTT", "You can't take that.");

	define("ON", "ON");
	define("OFF", "OFF");
	define("LIT", "LIT");
	define("UNLIT", "UNLIT");
	define("MOVED", "MOVED");
	define("UNMOVED", "UNMOVED");

	define("LOOKDIRECTION", "NOPE. No looking in directions in this game. You have to go that way first if you want to see what's there!");
	
	$txt = new textengine();	
?>