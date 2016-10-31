<?php
	
	//source url, lawbook id, category id
	
	$law_sources = [
	  ['http://www.wetboek-online.nl/wet/Wetboek%20van%20Strafrecht.html', 1, 1],
	  ['http://www.wetboek-online.nl/wet/Grondwet.html', 2, 2],
	  ['http://www.wetboek-online.nl/wet/Wetboek%20van%20Strafvordering.html', 3, 3],
	  ['http://www.wetboek-online.nl/wet/Burgerlijk%20Wetboek%20Boek%201.html', 4, 4],
	  ['http://www.wetboek-online.nl/wet/Burgerlijk%20Wetboek%20Boek%202.html', 7, 4],
	  ['http://www.wetboek-online.nl/wet/Burgerlijk%20Wetboek%20Boek%203.html', 8, 4],
	  ['http://www.wetboek-online.nl/wet/Burgerlijk%20Wetboek%20Boek%204.html', 9, 4],
	  ['http://www.wetboek-online.nl/wet/Burgerlijk%20Wetboek%20Boek%205.html', 10, 4],
	  ['http://www.wetboek-online.nl/wet/Burgerlijk%20Wetboek%20Boek%206.html', 11, 4],
	  ['http://www.wetboek-online.nl/wet/Burgerlijk%20Wetboek%20Boek%207.html', 12, 4],
	  ['http://www.wetboek-online.nl/wet/Burgerlijk%20Wetboek%20Boek%208.html', 13, 4],
	  ['http://www.wetboek-online.nl/wet/Rijkswet%20op%20het%20Nederlanderschap.html', 5, 5],
	  ['http://www.wetboek-online.nl/wet/Wegenverkeerswet%201994.html', 14, 22],
	  ['http://www.wetboek-online.nl/wet/Overleveringswet.html', 15, 6],
	  ['http://www.wetboek-online.nl/wet/Algemene%20wet%20bestuursrecht.html', 16, 7],
	  ['http://www.wetboek-online.nl/wet/Wet%20aansprakelijkheidsverzekering%20motorrijtuigen.html', 17, 8],
	  ['http://www.wetboek-online.nl/wet/Archiefwet%201995.html', 18, 9],
	  ['http://www.wetboek-online.nl/wet/Wet%20op%20de%20omzetbelasting%201968.html', 19, 10],
	  ['http://www.wetboek-online.nl/wet/Opiumwet.html', 20, 11],
	  ['http://www.wetboek-online.nl/wet/Belemmeringenwet%20Privaatrecht.html', 21, 12],
	  ['http://www.wetboek-online.nl/wet/Wet%20bescherming%20persoonsgegevens.html', 22, 13],
	  ['http://www.wetboek-online.nl/wet/Bekendmakingswet.html', 23, 14],
	  ['http://www.wetboek-online.nl/wet/Auteurswet.html', 24, 17],
	  ['http://www.wetboek-online.nl/wet/Faillissementswet.html', 25, 15],
	  ['http://www.wetboek-online.nl/wet/Gemeentewet.html', 26, 16],
	  ['http://www.wetboek-online.nl/wet/Wetboek%20van%20Burgerlijke%20Rechtsvordering.html', 27, 18],
	  ['http://www.wetboek-online.nl/wet/Wet%20op%20het%20hoger%20onderwijs%20en%20wetenschappelijk%20onderzoek.html', 28, 19],
	  ['http://www.wetboek-online.nl/wet/Wet%20conflictenrecht%20geregistreerd%20partnerschap.html', 29, 20],
	  ['http://www.wetboek-online.nl/wet/Wet%20ter%20voorkoming%20van%20witwassen%20en%20financieren%20van%20terrorisme.html', 30, 21],
	  ['http://www.wetboek-online.nl/wet/Wet%20administratiefrechtelijke%20handhaving%20verkeersvoorschriften.html', 31, 22],
	  ['http://www.wetboek-online.nl/wet/Wet%20werk%20en%20bijstand.html', 32, 23]
	  ];
	
	
	foreach ($law_sources as $source) {
	  
	  $target_url = $source[0]; // law source url
    $lawbook_id = $source[1]; // lawbook id
    $category_id = $source[2]; // category id
	  
	
  	$doc = new DOMDocument();
  	$doc->loadHTMLFile($target_url);
  	
  	
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
    	//echo $article['article_title'] . "  -  " . $article['article_text']; echo PHP_EOL; echo PHP_EOL;
    
      //decode invalid chars
      $article['article_chapter'] = utf8_decode(urldecode(htmlspecialchars_decode($article['article_chapter'])));
      $article['article_title'] = utf8_decode(urldecode(htmlspecialchars_decode($article['article_title'])));
      $article['article_text'] = utf8_decode(urldecode(htmlspecialchars_decode($article['article_text'])));
      
      $article['article_chapter'] = str_replace("\xa0", " ", $article['article_chapter']);
      $article['article_title'] = str_replace("\xa0", " ", $article['article_title']);
      $article['article_text'] = str_replace("\xa0", " ", $article['article_text']);
      
      //form main query
      $query = "INSERT INTO `BM01`.`Law_Text` (`id`, `lawbook_id`, `chapter`, `article_title`, `article_text`, `category_id`)
                VALUES (NULL, '$lawbook_id', '".$article['article_chapter']."', '".$article['article_title']."', '".$article['article_text']."', '$category_id');";
    
      //do query
      $result = $db->queryDatabase($query);
    }
  
	}
	
	
?>