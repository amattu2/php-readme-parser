<?php
/*
	Produced 2019
	By https://amattu.com/links/github
	Copy Alec M.
	License GNU Affero General Public License v3.0
*/

echo "<html><head><link rel='stylesheet' type='text/css' href='assets/css/style.css' /></head>";

// Files
require(dirname(__FILE__) . "/classes/mdparser.class.php");

// Test Cases
//test("parseString", MDParser::parseString("test string"), "test string", true);
test("parseFile", MDParser::parseFile(fopen(dirname(__FILE__) . "/tests/test_1.md", "r")), "File", true);
test("parseFile", MDParser::parseFile(fopen(dirname(__FILE__) . "/tests/test_2.md", "r")), "File", true);

// Test Function
function test($name, $value, $original, $last = false) {
	echo "<b>Test <i>MDParser::$name</i></b> Result<br/><br/>";
	echo "<pre>";
	echo $value;
	echo "</pre>";
	echo "<br/><br/><b>Test <i>MDParser::$name</i></b> Original Value<br/><br/>";
	echo "<textarea>$original</textarea>";
	echo ($last ? "<hr/>" : "<br/><br/>");
}
?>
