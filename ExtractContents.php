
<?php
	//extract contents of a directory and ouput into new file with extension docx
	//recursive directory listing NOT WORKING (only doing current directory)
	
	function get_string_between($string,$start,$end){
		$string = " ".$string;
		$ini = strpos($string,$start);
		if($ini==0) return "";
		$ini += strlen($start);
		$len = strpos($string,$end,$ini) - $ini;
		return substr($string,$ini,$len);
	}; //not used

	function str_match ($input)
	{

		preg_match ('/Title=(.*?)\" /i', $input, $title);
		$com_title = "Title: " . PHP_EOL . substr($title[0], 7, strlen($title[0])-9)  . PHP_EOL . PHP_EOL;
		//echo $com_title;
		//preg_match ('/<h1\>(.*?)<p\>/i', $input, $content);
		//$com_content = "Content: <br>" . $content[0] . "\n";
		//substr($content[0], 3, strlen($content[0])-3) 
		//echo $com_content
		preg_match ('/description" content=(.*?)\>/i', $input, $description);
		$com_description = "Description: " . PHP_EOL . substr($description[0], 22, strlen($description[0])-26) . PHP_EOL . PHP_EOL;
		//echo $com_description;
		preg_match ('/keywords" content=(.*?)\>/i', $input, $keywords);
		$com_keywords = "Keywords: " . PHP_EOL . substr($keywords[0], 19 , strlen($keywords[0])-23) . PHP_EOL . PHP_EOL;
		//echo $com_keywords;
		$post_name = "Post Name: " . PHP_EOL . strtolower(str_replace (' ', '-', $com_title)) . PHP_EOL . PHP_EOL;
		$result = $post_name . $com_title . $com_description . $com_keywords;
		//$result = array_merge ($com_title, $com_description, $com_keywords);
		return $result;
	};


	$filetypes = array ("txt");

	$dir = ".";

	$objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator ($dir));
	foreach ($objects as $file) {
		$filetype = pathinfo($file, PATHINFO_EXTENSION);
    	if (in_array(strtolower($filetype), $filetypes)) {
    		echo "Filename: $file <br>";
    		$file_contents = file_get_contents ($file);
    		$output = str_match($file_contents);
    		//if folder not there yet, create it
    		if (is_dir("DOCfiles/")) {
    			echo "Directory already exists.";
    			exit(0);
    		}
    		else {
    			mkdir ("DOCfiles/");
    		}
    		file_put_contents("DOCfiles/" . pathinfo($file, PATHINFO_FILENAME) . '.docx', $output);
    	}
    	
	}


?>