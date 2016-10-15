<?php
	
	
	$doc = new DOMDocument();
	//$doc->loadHTMLFile('http://www.wetboek-online.nl/wet/Wetboek%20van%20Strafrecht.html');
	$doc->loadHTMLFile('http://www.wetboek-online.nl/wet/Grondwet.html');
	
	
	$finder = new DomXPath($doc);
  $spaner = $finder->query("//*[contains(@class, 'contents')]/a");
  $articles = array();
  $current_article = array();
  foreach ($spaner as $span) {
  	$elementText = $span->nodeValue;
  	if(strpos($span->getAttribute('class'), "titel") !== false || strpos($span->getAttribute('class'), "hoofdstuk") !== false) {
  	  $current_article['article_chapter'] = $elementText;
  	} else if(strpos($elementText, "Artikel") !== false) {
  		//reset current article and save previous article
  		$articles[] = $current_article;
  		
  		$current_article['article_title'] = $elementText;
  		$current_article['article_text'] = '';
  	} else {
  		$current_article['article_text'] .= $elementText;
  	}
  }
  
  include_once('dbConnection.php');
  $db = new databaseConnection("BM01");
  foreach($articles as $article) {
  	echo $article['article_title'] . "  -  " . $article['article_text']; echo PHP_EOL; echo PHP_EOL;
  
    //decode invalid chars
    $article['article_chapter'] = utf8_decode(urldecode(htmlspecialchars_decode($article['article_chapter'])));
    $article['article_title'] = utf8_decode(urldecode(htmlspecialchars_decode($article['article_title'])));
    $article['article_text'] = utf8_decode(urldecode(htmlspecialchars_decode($article['article_text'])));
    
    $article['article_chapter'] = str_replace("\xa0", " ", $article['article_chapter']);
    $article['article_title'] = str_replace("\xa0", " ", $article['article_title']);
    $article['article_text'] = str_replace("\xa0", " ", $article['article_text']);
    
    //form main query
    //$query = "INSERT INTO `BM01`.`Law_Text` (`id`, `lawbook_id`, `chapter`, `article_title`, `article_text`, `category_id`)
    //          VALUES (NULL, '1', '".$article['article_chapter']."', '".$article['article_title']."', '".$article['article_text']."', '1');";
    $query = "INSERT INTO `BM01`.`Law_Text` (`id`, `lawbook_id`, `chapter`, `article_title`, `article_text`, `category_id`)
              VALUES (NULL, '2', '".$article['article_chapter']."', '".$article['article_title']."', '".$article['article_text']."', '2');";
  
    //do query
    $result = $db->queryDatabase($query);
  }
  
  
  
  
	
	
	//echo file_get_contents('http://www.wetboek-online.nl/wet/Wetboek%20van%20Strafrecht/14b.html');
	
	
?>