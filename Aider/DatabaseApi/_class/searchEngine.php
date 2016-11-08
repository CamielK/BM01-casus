<?php

class searchEngine {
    
    
    
    //return a list of search results for the given search string
    public function searchLawTexts($searchstring) {
    	
        //call to database connection
        include_once('dbConnection.php');
        $db = new databaseConnection("BM01");
        
        //check search string format (url decode and SQL injections)
        $searchstring = mysqli_real_escape_string($db->getConnection(), $searchstring);
        $searchstring = urldecode(utf8_decode($searchstring));
        
        $db->queryDatabase("SET NAMES 'utf8'");
        $db->queryDatabase("SET CHARACTER SET utf8");
        $db->queryDatabase("SET SESSION collation_connection = 'utf8_unicode_ci'");
        
        
        //form query
        // $query = "
        //     SELECT * 
        //     FROM Law_Text 
        //     WHERE Law_Text.article_text 
        //     LIKE '%$searchstring%' 
        //     LIMIT 10";
            
        $query = "
            SELECT *
            FROM (
                SELECT *, 
                    MATCH (article_text) 
                    AGAINST ('$searchstring') 
                    as relevance 
                FROM Law_Text) as derived_table
            WHERE relevance > 0
            ORDER BY relevance DESC
            LIMIT 10";
            
        
        error_log($query);
        
        //do query
        $result = $db->queryDatabase($query);

        //check result
        $searchResults = array();
        if ($result->num_rows > 0) {
        	while ($row = $result->fetch_array(MYSQL_ASSOC)) {
        		$searchResults['law_articles'][] = $row;
        		error_log($row['article_text']);
                error_log(implode(" ",$row));
        	}
        } else {
            $searchResults['error'] = 'Did not find any resources matching the search string.';
        }
        
        //close connection
        $db->closeConnection();
    
        error_log(json_encode($searchResults));
    
        //return article json
        return json_encode($searchResults);
    }
    
    
    //return a query-focused summary from the documents that match the search string
    public function getSummaryFromLawTexts($searchstring, $max_length) {
    	
    	// > init database connection
        include_once('dbConnection.php');
        $db = new databaseConnection("BM01");
        $db->queryDatabase("SET NAMES 'utf8'");
        $db->queryDatabase("SET CHARACTER SET utf8");
        $db->queryDatabase("SET SESSION collation_connection = 'utf8_unicode_ci'");
        
        // > check search string format (url decode and SQL injections)
        $searchstring = mysqli_real_escape_string($db->getConnection(), $searchstring);
        $searchstring = urldecode(utf8_decode($searchstring));
    	echo "- original query: " . json_encode($searchstring) . PHP_EOL . PHP_EOL;
    	
    	// > build query
    	//    - split individual query words and get synonyms for each word
    	include_once('queryBuilder.php');
    	$query_builder = new queryBuilder();
    	$query_array = explode(" ", $searchstring);
    	$synonym_array = array();
    	foreach ($query_array as $key => $query_word) {
    	   
    	    if (!$query_builder->isStopword($query_word)) {
    	        $synonym_array[] = $query_builder->getSynonym($query_word);
    	    }
    	    
    	    //TODO: assign a weight to each query word
    	    //TODO: remove otherwise unnecesarry words
    	}
    	echo "- synonym array: " . json_encode($synonym_array) . PHP_EOL . PHP_EOL;
    	
    	
    	
    	// > get documents
    	//    query database and return top 100 most relevant articles
	    $query_string = "";
	    foreach ($synonym_array as $query_word) {
	        $query_string .= implode(" ", $query_word) . " ";
	    }
	    echo "- query string: " . $query_string . PHP_EOL . PHP_EOL;
        $query = "
            SELECT *
            FROM (
                SELECT *, 
                    MATCH (article_text) 
                    AGAINST ('$query_string') 
                    as relevance 
                FROM Law_Text) as derived_table
            WHERE derived_table.relevance > 0
            ORDER BY derived_table.relevance DESC
            LIMIT 100";
        echo "- SQL query: " . $query . PHP_EOL . PHP_EOL;
        $result = $db->queryDatabase($query);
        $searchResults = array();
        if ($result->num_rows > 0) {
        	while ($row = $result->fetch_array(MYSQL_ASSOC)) {
        		$searchResults['law_articles'][] = $row;
        	}
        } else {
            $searchResults['error'] = 'Did not find any resources matching the search string.';
        }
        
        
        
        
        // >>> summarize the results <<<
        $source_text = '';
        foreach ($searchResults['law_articles'] as $article) {
            $source_text .= "\n\n " . $article['article_text'];
        }
    	$searchResults['original'] = $source_text;
        
	    //Sentence segmentation
        include_once('textAnalyzer.php');
        $txt_analyzer = new TextAnalyzer();
        $sentences = $txt_analyzer->getSentences($source_text);
        
        //Simplify the sentences
        foreach ($sentences as $key => $sentence) {
            $sentences[$key] = $txt_analyzer->simplifySentence($sentence);
            //echo '_'.$sentences[$key] .'_'.PHP_EOL;
        }
        
        //score each sentence
        foreach ($sentences as $key => $sentence) {
            $sentence_score = $txt_analyzer->getSentenceWeight($sentence, $sentences, $synonym_array);
            $sentences[$key] = [$sentence, $sentence_score];
        }
        //var_dump($sentences);
        
        //iteratively create summary based on highest scoring and non redundant sentences
        $summary_sentences = array();
        while ((count($summary_sentences) < $max_length) && (count($summary_sentences) < $sentences)) {
            $summary_sentences[] = $txt_analyzer->getBestSummarySentence($sentences, $summary_sentences);
        }
        $searchResults['summary'] = $summary_sentences;
        var_dump($summary_sentences);
        
        //close connection
        $db->closeConnection();
    
        //return summary json
        echo PHP_EOL . PHP_EOL . " - JSON output: ";
        return json_encode($searchResults);
    	
    	
    	
    }
    
    
    
    //return the law article that matches the given article id
    public function getArticle($artId) {
        
        //call to database connection
        include_once('dbConnection.php');
        $db = new databaseConnection("BM01");
        
        $db->queryDatabase("SET NAMES 'utf8'");
        $db->queryDatabase("SET CHARACTER SET utf8");
        $db->queryDatabase("SET SESSION collation_connection = 'utf8_unicode_ci'");
        
        //form query
        $query = "
            SELECT Law_Text.id, Law_Text.chapter, Law_Text.article_title,  Law_Text.article_text, Category.category_name AS category, Law_Book.book_title AS law_book
            FROM `Law_Text` 
            JOIN Category ON Law_Text.category_id = Category.id
            JOIN Law_Book ON Law_Text.lawbook_id = Law_Book.id
            WHERE Law_Text.id='$artId';";
        
        //do query
        $result = $db->queryDatabase($query);

        //check result
        $articleInfo = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_array(MYSQL_ASSOC)) {
                $articleInfo = $row;
                //error_log(implode(" ",$row));
            }
            
        } else {
            $articleInfo['error'] = 'No article found for the given article id.';
        }
        
        
        //close connection
        $db->closeConnection();
    
        //return article json
        return json_encode($articleInfo);
        
    }
    
    
}

?>
