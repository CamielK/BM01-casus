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
            SELECT *, Category.category_name AS category, Law_Book.book_title AS law_book
            FROM (
                SELECT *, 
                    MATCH (article_text) 
                    AGAINST ('$searchstring') 
                    as relevance 
                FROM Law_Text) as derived_table
            JOIN Category ON derived_table.category_id = Category.id
            JOIN Law_Book ON derived_table.lawbook_id = Law_Book.id
            WHERE derived_table.relevance > 0
            ORDER BY derived_table.relevance DESC
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
