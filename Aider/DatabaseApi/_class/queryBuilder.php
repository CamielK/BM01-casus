<?php

class queryBuilder {
	
	
	public function getSynonym($query_word) {
		
		//open synonym list
		$synonym_file = fopen("/home/bm01/api/resources/thesaurus.txt", "r") or die("Unable to open file!");
		
		//loop synonym list rows untill finished or untill a match was found
		while(($row = fgets($synonym_file)) && !isset($synonym_array)) {
			$row = str_replace("\n", "", $row);
			$row_contents = explode(";",$row);
			
			//error_log($row);
			
			//find rows that matches the query
			foreach ($row_contents as $word) {
				if ($query_word === $word) {
					$synonym_array = $row_contents;
					break;
				}
			}
		}
		
		//close synonym list and return a list of words that are synonyms for the query
		fclose($synonym_file);
		
		if (isset($synonym_array)) {
			return $synonym_array;
		} else {
			return [$query_word];
		}
		
		
	}
	
	
}



?>