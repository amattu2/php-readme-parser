# Introduction
Under development.

This is a PHP based Markdown (https://www.markdownguide.org/) parser.

# Usage
Include the class file
```PHP
require(dirname(__FILE__) . "/classes/mdparser.class.php");
```

### Supported Tags
- H1 to H6
- code

### Parsing Strings
If you have already grabbed the contents of a markdown file, you can parse the input with `MDParser::parseString`

```PHP
MDParser::parseString("# Hey!");
```

### Parsing Files
If you have a resource handle, you can parse the contents with `MDParser::parseFile`

```PHP
MDParser::parseFile(fopen(dirname(__FILE__) . "/tests/test_1.md", "r");
```

# Notes
Syntax derived from https://www.markdownguide.org/cheat-sheet/

# Requirements & Dependencies
N/A

# Previews
N/A
