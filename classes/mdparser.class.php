<?php
/*
	Produced 2019
	By https://amattu.com/links/github
	Copy Alec M.
	License GNU Affero General Public License v3.0
*/

/*
	Notes:
	https://help.github.com/en/github/writing-on-github/basic-writing-and-formatting-syntax#ignoring-markdown-formatting
	https://github.com/erusev/parsedown/blob/master/Parsedown.php
 */

class MDParser {
	/**
	* Parse a README.md markup string and convert it to HTML markup
	*
	* @param string $input
	* @return string parsed
	* @throws TypeError
	**/
	public static function parseString(string $input) : string {
		// Checks
		if (strlen($input) <= 0 || empty($input)) {
			return "";
		}

		// Variables
		$readme = new README($input);

		// Return
		return $readme;
	}

	/**
	* Parse a file containing README.md content and convert it to HTML markup
	*
	* @param resource $file
	* @return string parsed
	* @throws InvalidArgumentException
	**/
	public static function parseFile($file) : string {
		// Checks
		if (is_resource($file) !== true) {
			throw new InvalidArgumentException("Invalid type passed to parseFile");
		}

		// Variables
		$size = fstat($file)['size'];
		$input = fread($file, $size);

		// Parse & Return
		return self::parseString($input);
	}
}

class README {
	// Class Variables
	private $open_tags = Array();
	private $lines = Array();

	/**
	 * Class constructor
	 *
	 * @param string $input
	 * @return README new instance
	 * @throws TypeError
	 * @date 2019-12-26T16:59:28-050
	 */
	public function __construct(string $input) {
		// Variables
		$this->lines = explode("\n", $input);

		// Parse Lines
		foreach ($this->lines as $index => $line) {
			// Variables
			$line = $this->parseBlocks($line);
			$line = $this->parseHeaders($line);
			$this->lines[$index] = $line;
		}
	}

	/**
	 * Class tostring method
	 *
	 * @param None
	 * @return string $string
	 * @throws None
	 * @date 2019-12-26T17:05:58-050
	 */
	public function __tostring() : string {
		return implode("\n", $this->lines);
	}

	/**
	 * Parse README.md code block formatting
	 *
	 * Includes:
	 * <code>
	 *
	 * @param string $line
	 * @return string formatted $line
	 * @throws TypeError
	 */
	private function parseBlocks(string $line) : string {
		// Checks
		if (strpos($line, "```") !== false && !$this->tagOpen("code")) {
			$line = str_replace("```", "<code>", $line);
			$this->openTag("code");
		} else if (strpos($line, "```") !== false && $this->tagOpen("code")) {
			$line = str_replace("```", "</code>", $line);
			$this->closeTag("code");
		}

		// Return
		return $line;
	}

	/**
	 * Parse README.md header formatting
	 *
	 * Includes:
	 * <h1>, <h2>, <h3>, <h3>, <h5>, <h6>
	 *
	 * @param string $line
	 * @return string formatted $line
	 * @throws TypeError
	 */
	private function parseHeaders(string $line) : string {
		// Checks
		if ($this->tagOpen("code")) {
			return $line;
		}
		if (strpos($line, '######') !== false) {
			$line = str_replace(Array("###### ", "######"), "<h6>", $line) . "</h6>";
		} else if (strpos($line, '#####') !== false) {
			$line = str_replace(Array("##### ", "#####"), "<h5>", $line) . "</h5>";
		} else if (strpos($line, '####') !== false) {
			$line = str_replace(Array("#### ", "####"), "<h4>", $line) . "</h4>";
		} else if (strpos($line, '###') !== false) {
			$line = str_replace(Array("### ", "###"), "<h3>", $line) . "</h3>";
		} else if (strpos($line, '##') !== false) {
			$line = str_replace(Array("## ", "##"), "<h2>", $line) . "</h2>";
		} else if (strpos($line, '#') !== false) {
			$line = str_replace(Array("# ", "#"), "<h1>", $line) . "</h1>";
		}

		// Return
		return $line;
	}

	/**
	 * Check if the specified tag is open
	 *
	 * @param string $tag
	 * @return bool tag status
	 * @throws TypeError
	 * @date 2019-12-26T17:21:34-050
	 */
	private function tagOpen(string $tag) : bool {
		// Checks
		if (isset($this->open_tags[$tag])) {
			return true;
		}

		// Return
		return false;
	}

	/**
	 * Mark a specified tag as open
	 *
	 * @param string $tag
	 * @return None
	 * @throws TypeError
	 * @date 2019-12-27T19:42:12-050
	 */
	private function openTag(string $tag) : void {
		$this->open_tags[$tag] = 1;
	}

	/**
	 * Mark a specified tag as closed
	 *
	 * @param string $tag
	 * @return None
	 * @throws TypeError
	 * @date 2019-12-27T19:42:12-050
	 */
	private function closeTag(string $tag) : void {
		unset($this->open_tags[$tag]);
	}
}
?>
