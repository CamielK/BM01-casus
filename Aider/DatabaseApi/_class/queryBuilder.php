<?php

class queryBuilder {
	
	
	public function getSynonym($query_word) {
		
		//normalize query word
		$query_word = $this->normalizeChars($query_word);
		
		//open synonym list
		$synonym_file = $this->utf8_fopen_read("/home/bm01/api/resources/thesaurus.txt") or die("Unable to open file!");
		
		//loop synonym list rows untill finished or untill a match was found
		while(($data = fgetcsv($synonym_file, 11000, ",")) && !isset($synonym_array)) {
			
			foreach($data as $row) {
			    
			    $row = str_replace("\n", "", $row);
    			$row = $this->normalizeChars($row);
    			$row_contents = explode(";",$row);
    			
    			error_log($row);
    			
    			//find rows that matches the query
    			foreach ($row_contents as $word) {
    				if ($query_word === $word) {
    					$synonym_array = $row_contents;
    					break;
    				}
    			}
    			
    			if (isset($synonym_array)) {break;}
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
	
	
	private function normalizeChars($s) {
		//hard coded normalization for creating a more flexible search
        $replace = array(
            '?'=>'-', '?'=>'-', '?'=>'-', '?'=>'-',
            'A'=>'A', 'A'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'A', '�'=>'Ae',
            '�'=>'B',
            'C'=>'C', '?'=>'C', '�'=>'C',
            '�'=>'E', 'E'=>'E', '�'=>'E', '�'=>'E', '�'=>'E',
            'G'=>'G',
            'I'=>'I', '�'=>'I', '�'=>'I', '�'=>'I', '�'=>'I',
            'L'=>'L',
            '�'=>'N', 'N'=>'N',
            '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'O', '�'=>'Oe',
            'S'=>'S', 'S'=>'S', '?'=>'S', '�'=>'S',
            '?'=>'T',
            '�'=>'U', '�'=>'U', '�'=>'U', '�'=>'Ue',
            '�'=>'Y',
            'Z'=>'Z', '�'=>'Z', 'Z'=>'Z',
            '�'=>'a', 'a'=>'a', 'a'=>'a', '�'=>'a', 'a'=>'a', '�'=>'a', 'A'=>'a', '?'=>'a', '?'=>'a', '�'=>'a', '�'=>'a', '?'=>'a', '?'=>'a', 'A'=>'a', '?'=>'a', 'a'=>'a', '�'=>'ae', '�'=>'ae', '?'=>'ae', '?'=>'ae',
            '?'=>'b', '?'=>'b', '?'=>'b', '�'=>'b',
            'c'=>'c', 'C'=>'c', 'C'=>'c', 'c'=>'c', '�'=>'c', '?'=>'c', '?'=>'c', 'c'=>'c', '?'=>'c', 'C'=>'c', 'c'=>'c', '?'=>'ch', '?'=>'ch',
            '?'=>'d', 'd'=>'d', '�'=>'d', 'D'=>'d', 'd'=>'d', '?'=>'d', '?'=>'D', '�'=>'d',
            '?'=>'e', '?'=>'e', '?'=>'e', '?'=>'e', '?'=>'e', 'e'=>'e', 'e'=>'e', 'e'=>'e', 'E'=>'e', 'E'=>'e', 'e'=>'e', 'e'=>'e', 'E'=>'e', '?'=>'e', 'E'=>'e', '�'=>'e', '?'=>'e', '�'=>'e', '�'=>'e', '�'=>'e',
            '?'=>'f', '�'=>'f', '?'=>'f',
            'g'=>'g', 'G'=>'g', 'G'=>'g', 'G'=>'g', '?'=>'g', '?'=>'g', 'g'=>'g', 'g'=>'g', '?'=>'g', '?'=>'g', '?'=>'g', 'g'=>'g',
            '?'=>'h', 'h'=>'h', '?'=>'h', 'H'=>'h', 'H'=>'h', 'h'=>'h', '?'=>'h', '?'=>'h',
            '�'=>'i', '�'=>'i', '�'=>'i', '�'=>'i', 'i'=>'i', 'i'=>'i', 'i'=>'i', 'I'=>'i', '?'=>'i', 'i'=>'i', 'i'=>'i', 'I'=>'i', 'I'=>'i', '?'=>'i', 'I'=>'i', '?'=>'i', '?'=>'i', 'I'=>'i', '?'=>'i', '?'=>'i', '?'=>'i', 'i'=>'i', '?'=>'ij', '?'=>'ij',
            '?'=>'j', '?'=>'j', 'J'=>'j', 'j'=>'j', '?'=>'ja', '?'=>'ja', '?'=>'je', '?'=>'je', '?'=>'jo', '?'=>'jo', '?'=>'ju', '?'=>'ju',
            '?'=>'k', '?'=>'k', 'K'=>'k', '?'=>'k', '?'=>'k', 'k'=>'k', '?'=>'k',
            '?'=>'l', '?'=>'l', '?'=>'l', 'l'=>'l', 'l'=>'l', 'l'=>'l', 'L'=>'l', 'L'=>'l', '?'=>'l', 'L'=>'l', 'l'=>'l', '?'=>'l',
            '?'=>'m', '?'=>'m', '?'=>'m', '?'=>'m',
            '�'=>'n', '?'=>'n', 'N'=>'n', '?'=>'n', '?'=>'n', '?'=>'n', '?'=>'n', 'n'=>'n', '?'=>'n', 'n'=>'n', '?'=>'n', 'N'=>'n', 'n'=>'n',
            '?'=>'o', '?'=>'o', 'o'=>'o', '�'=>'o', '�'=>'o', 'O'=>'o', 'o'=>'o', 'O'=>'o', 'O'=>'o', 'o'=>'o', '�'=>'o', '?'=>'o', 'o'=>'o', '�'=>'o', '?'=>'o', 'O'=>'o', 'o'=>'o', '�'=>'o', 'O'=>'o', '�'=>'oe', '�'=>'oe', '�'=>'oe',
            '?'=>'p', '?'=>'p', '?'=>'p', '?'=>'p',
            '?'=>'q',
            'r'=>'r', 'r'=>'r', 'R'=>'r', 'r'=>'r', 'R'=>'r', '?'=>'r', 'R'=>'r', '?'=>'r', '?'=>'r',
            '?'=>'s', '?'=>'s', 'S'=>'s', '�'=>'s', 's'=>'s', '?'=>'s', 's'=>'s', '?'=>'s', 's'=>'s', '?'=>'sch', '?'=>'sch', '?'=>'sh', '?'=>'sh', '�'=>'ss',
            '?'=>'t', '?'=>'t', 't'=>'t', '?'=>'t', 't'=>'t', 't'=>'t', 'T'=>'t', '?'=>'t', '?'=>'t', 'T'=>'t', 'T'=>'t', '�'=>'tm',
            'u'=>'u', '?'=>'u', 'U'=>'u', 'u'=>'u', 'U'=>'u', 'u'=>'u', 'U'=>'u', 'U'=>'u', 'u'=>'u', 'U'=>'u', 'u'=>'u', 'U'=>'u', 'U'=>'u', 'u'=>'u', 'u'=>'u', 'U'=>'u', 'U'=>'u', 'u'=>'u', 'U'=>'u', '�'=>'u', '�'=>'u', '�'=>'u', '?'=>'u', 'u'=>'u', 'u'=>'u', 'U'=>'u', 'U'=>'u', 'u'=>'u', 'u'=>'u', '�'=>'ue',
            '?'=>'v', '?'=>'v', '?'=>'v',
            '?'=>'w', 'w'=>'w', 'W'=>'w',
            '?'=>'y', 'y'=>'y', '�'=>'y', '�'=>'y', '�'=>'y', 'Y'=>'y',
            '?'=>'y', '�'=>'z', '?'=>'z', '?'=>'z', 'z'=>'z', '?'=>'z', 'z'=>'z', '?'=>'z', '?'=>'zh', '?'=>'zh'
        );
        return strtolower(strtr($s, $replace));
	}
	
	
	private function utf8_fopen_read($fileName) { 
        $fc = iconv('windows-1250', 'utf-8', file_get_contents($fileName)); 
        $handle=fopen("php://memory", "rw"); 
        fwrite($handle, $fc); 
        fseek($handle, 0); 
        return $handle; 
    }
	
}



?>