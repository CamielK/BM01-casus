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
            'A'=>'A', 'A'=>'A', 'À'=>'A', 'Ã'=>'A', 'Á'=>'A', 'Æ'=>'A', 'Â'=>'A', 'Å'=>'A', 'Ä'=>'Ae',
            'Þ'=>'B',
            'C'=>'C', '?'=>'C', 'Ç'=>'C',
            'È'=>'E', 'E'=>'E', 'É'=>'E', 'Ë'=>'E', 'Ê'=>'E',
            'G'=>'G',
            'I'=>'I', 'Ï'=>'I', 'Î'=>'I', 'Í'=>'I', 'Ì'=>'I',
            'L'=>'L',
            'Ñ'=>'N', 'N'=>'N',
            'Ø'=>'O', 'Ó'=>'O', 'Ò'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'Oe',
            'S'=>'S', 'S'=>'S', '?'=>'S', 'Š'=>'S',
            '?'=>'T',
            'Ù'=>'U', 'Û'=>'U', 'Ú'=>'U', 'Ü'=>'Ue',
            'Ý'=>'Y',
            'Z'=>'Z', 'Ž'=>'Z', 'Z'=>'Z',
            'â'=>'a', 'a'=>'a', 'a'=>'a', 'á'=>'a', 'a'=>'a', 'ã'=>'a', 'A'=>'a', '?'=>'a', '?'=>'a', 'å'=>'a', 'à'=>'a', '?'=>'a', '?'=>'a', 'A'=>'a', '?'=>'a', 'a'=>'a', 'ä'=>'ae', 'æ'=>'ae', '?'=>'ae', '?'=>'ae',
            '?'=>'b', '?'=>'b', '?'=>'b', 'þ'=>'b',
            'c'=>'c', 'C'=>'c', 'C'=>'c', 'c'=>'c', 'ç'=>'c', '?'=>'c', '?'=>'c', 'c'=>'c', '?'=>'c', 'C'=>'c', 'c'=>'c', '?'=>'ch', '?'=>'ch',
            '?'=>'d', 'd'=>'d', 'Ð'=>'d', 'D'=>'d', 'd'=>'d', '?'=>'d', '?'=>'D', 'ð'=>'d',
            '?'=>'e', '?'=>'e', '?'=>'e', '?'=>'e', '?'=>'e', 'e'=>'e', 'e'=>'e', 'e'=>'e', 'E'=>'e', 'E'=>'e', 'e'=>'e', 'e'=>'e', 'E'=>'e', '?'=>'e', 'E'=>'e', 'ê'=>'e', '?'=>'e', 'è'=>'e', 'ë'=>'e', 'é'=>'e',
            '?'=>'f', 'ƒ'=>'f', '?'=>'f',
            'g'=>'g', 'G'=>'g', 'G'=>'g', 'G'=>'g', '?'=>'g', '?'=>'g', 'g'=>'g', 'g'=>'g', '?'=>'g', '?'=>'g', '?'=>'g', 'g'=>'g',
            '?'=>'h', 'h'=>'h', '?'=>'h', 'H'=>'h', 'H'=>'h', 'h'=>'h', '?'=>'h', '?'=>'h',
            'î'=>'i', 'ï'=>'i', 'í'=>'i', 'ì'=>'i', 'i'=>'i', 'i'=>'i', 'i'=>'i', 'I'=>'i', '?'=>'i', 'i'=>'i', 'i'=>'i', 'I'=>'i', 'I'=>'i', '?'=>'i', 'I'=>'i', '?'=>'i', '?'=>'i', 'I'=>'i', '?'=>'i', '?'=>'i', '?'=>'i', 'i'=>'i', '?'=>'ij', '?'=>'ij',
            '?'=>'j', '?'=>'j', 'J'=>'j', 'j'=>'j', '?'=>'ja', '?'=>'ja', '?'=>'je', '?'=>'je', '?'=>'jo', '?'=>'jo', '?'=>'ju', '?'=>'ju',
            '?'=>'k', '?'=>'k', 'K'=>'k', '?'=>'k', '?'=>'k', 'k'=>'k', '?'=>'k',
            '?'=>'l', '?'=>'l', '?'=>'l', 'l'=>'l', 'l'=>'l', 'l'=>'l', 'L'=>'l', 'L'=>'l', '?'=>'l', 'L'=>'l', 'l'=>'l', '?'=>'l',
            '?'=>'m', '?'=>'m', '?'=>'m', '?'=>'m',
            'ñ'=>'n', '?'=>'n', 'N'=>'n', '?'=>'n', '?'=>'n', '?'=>'n', '?'=>'n', 'n'=>'n', '?'=>'n', 'n'=>'n', '?'=>'n', 'N'=>'n', 'n'=>'n',
            '?'=>'o', '?'=>'o', 'o'=>'o', 'õ'=>'o', 'ô'=>'o', 'O'=>'o', 'o'=>'o', 'O'=>'o', 'O'=>'o', 'o'=>'o', 'ø'=>'o', '?'=>'o', 'o'=>'o', 'ò'=>'o', '?'=>'o', 'O'=>'o', 'o'=>'o', 'ó'=>'o', 'O'=>'o', 'œ'=>'oe', 'Œ'=>'oe', 'ö'=>'oe',
            '?'=>'p', '?'=>'p', '?'=>'p', '?'=>'p',
            '?'=>'q',
            'r'=>'r', 'r'=>'r', 'R'=>'r', 'r'=>'r', 'R'=>'r', '?'=>'r', 'R'=>'r', '?'=>'r', '?'=>'r',
            '?'=>'s', '?'=>'s', 'S'=>'s', 'š'=>'s', 's'=>'s', '?'=>'s', 's'=>'s', '?'=>'s', 's'=>'s', '?'=>'sch', '?'=>'sch', '?'=>'sh', '?'=>'sh', 'ß'=>'ss',
            '?'=>'t', '?'=>'t', 't'=>'t', '?'=>'t', 't'=>'t', 't'=>'t', 'T'=>'t', '?'=>'t', '?'=>'t', 'T'=>'t', 'T'=>'t', '™'=>'tm',
            'u'=>'u', '?'=>'u', 'U'=>'u', 'u'=>'u', 'U'=>'u', 'u'=>'u', 'U'=>'u', 'U'=>'u', 'u'=>'u', 'U'=>'u', 'u'=>'u', 'U'=>'u', 'U'=>'u', 'u'=>'u', 'u'=>'u', 'U'=>'u', 'U'=>'u', 'u'=>'u', 'U'=>'u', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', '?'=>'u', 'u'=>'u', 'u'=>'u', 'U'=>'u', 'U'=>'u', 'u'=>'u', 'u'=>'u', 'ü'=>'ue',
            '?'=>'v', '?'=>'v', '?'=>'v',
            '?'=>'w', 'w'=>'w', 'W'=>'w',
            '?'=>'y', 'y'=>'y', 'ý'=>'y', 'ÿ'=>'y', 'Ÿ'=>'y', 'Y'=>'y',
            '?'=>'y', 'ž'=>'z', '?'=>'z', '?'=>'z', 'z'=>'z', '?'=>'z', 'z'=>'z', '?'=>'z', '?'=>'zh', '?'=>'zh'
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