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
    public function getSummaryFromLawTexts($searchstring) {
    	
    	//build query
    	include_once('queryBuilder.php');
    	$query_builder = new queryBuilder();
    	
    	//split individual query words and get synonyms for each word
    	$query_array = explode(" ", $searchstring);
    	foreach ($query_array as $key => $query_word) {
    	    $query_array[$key] = $query_builder->getSynonym($query_word); 
    	    
    	    //TODO: assign a weight to each query word
    	}
    	
    	
    	
    	
    	//get documents
    	
    	    //query database for all query words
    	    //return top 100 most relevant articles
    	
    	
    	
    	
    	//create summary
	//     -	Sentence segmentation:
    //         o	Pick a set of sentences from multiple documents
    //     -	Simplify the sentences
    //         o	(Zajic et al. (2007), Controy et al. (2006), Vanderwende et al. (2007))
    //         o	Parse sentences, use rules to decide which modifiers to prune. Machine learning methods can be used aswell
    //     -	Sentence extraction:
    //         o	log-likelihood ratio (LLR)
    //         o	Maximal Marginal Relevance (MMR), avoid redundancy
    //             	(Jaime Cardonell and Jade Goldstein, The Use of MMR, SIGIR-98)
    //             	Method: Iteratively (greedily) choose the best sentence to insert in the summary so far:
    //                 •	Relevant: Maximally relevant to the user’s query (high cosine similarity to query)
    //                 •	Novel: Minimally redundant with the summary so far (low cosine similarity to summary so far) 
    //             	Stop when desired length of summary is reached
    //         o	LLR + MMR
    //             	Combine LLR and MMR to select non-redundant yet informative sentences:
    //                 1.	Score each sentence based on LLR (including query words)
    //                 2.	Include the sentence with highest score in the summary
    //                 3.	Iteratively add into the summary high-scoring sentences that are not redundant with summary so far
    //     -	Information Ordering
    //         o	Chronological ordering: order sentences by the date of the document
    //         o	Coherence:
    //             	Choose orderings that make neighboring sentences similar (by cosine).
    //             	Choose orderings in which neighboring sentences discuss the same entity (Barzilay and Lapata 2007)
    //         o	Topical ordering: learn the ordering of topics in the source documents

    	
    	
    	
    	
    	
    	
    	
    	
    	
    	
    	
    	
    	
    	
    	return json_encode($query_array);
    	
        //call to database connection
        include_once('dbConnection.php');
        $db = new databaseConnection("BM01");
        
        //check search string format (url decode and SQL injections)
        $searchstring = mysqli_real_escape_string($db->getConnection(), $searchstring);
        $searchstring = urldecode(utf8_decode($searchstring));
        
        $db->queryDatabase("SET NAMES 'utf8'");
        $db->queryDatabase("SET CHARACTER SET utf8");
        $db->queryDatabase("SET SESSION collation_connection = 'utf8_unicode_ci'");
        
            
        $query = "
            SELECT *
            FROM (
                SELECT *, 
                    MATCH (article_text) 
                    AGAINST ('$searchstring') 
                    as relevance 
                FROM Law_Text) as derived_table
            WHERE derived_table.relevance > 0
            ORDER BY derived_table.relevance DESC
            LIMIT 100";
            
        
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
        
        
        //summarize the results
        $source_text = '';
        foreach ($searchResults['law_articles'] as $article) {
            $source_text .= "\n\n " . $article['article_text'];
        }
        
        include_once("summarizer.php");
        
        $st = new Summarizer();
        $summary = $st->get_summary($source_text);
    	$searchResults['summary'] = $summary;
    	$searchResults['original'] = $source_text;
        
        
        
        //close connection
        $db->closeConnection();
    
        var_dump($st->how_we_did());
    
        //return summary json
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
