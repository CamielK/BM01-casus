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
        
        //form query
        $query = "SELECT * FROM Law_Text WHERE Law_Text.article_text LIKE '%$searchstring%' LIMIT 10";
        
        error_log($query);
        
        //do query
        $result = $db->queryDatabase($query);

        //check result
        $searchResults = array();
        if ($result->num_rows > 0) {
        	while ($row = $result->fetch_assoc()) {
        		$searchResults['law_articles'][] = $row;
        		error_log($row['id']);
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
        
        // //call to database connection
        // include_once('dbConnection.php');
        // $db = new databaseConnection();
        
        // //form query
        // $query = "
        //     SELECT Article.*, User.name AS author_name, ROUND(Article.average_rating, 1) AS article_rating
        //     FROM `Article` 
        //     JOIN User ON Article.author_id = User.id
        //     WHERE Article.id='$artId';";
        
        // //do query
        // $result = $db->queryDatabase($query);

        // //check result
        // $articleInfo = array();
        // if ($result->num_rows > 0) {
        //     $articleInfo = $result->fetch_assoc();
            
        //     //increase view count for article
        //     $query = "
        //         UPDATE Article 
        //         SET Article.view_count = Article.view_count +1 
        //         WHERE Article.id = '$artId';";
                
        //     $db->queryDatabase($query);
            
            
        // } else {
        //     $articleInfo['error'] = 'No article found for the given article id.';
        // }
        
        
        
    
        // //close connection
        // $db->closeConnection();
    
        // //return article json
        // return json_encode($articleInfo);
        
    }
    
    
}

?>
