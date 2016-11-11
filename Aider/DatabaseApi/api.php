<?php

    //*** add default json response headers
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/json');

    //*** filter request url parameters
    $method = $_SERVER['REQUEST_METHOD'];
    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
    $input = json_decode(file_get_contents('php://input'),true);

    error_log("api call received. Method: $method. Url: ".$_SERVER['PATH_INFO']." ",0);

    //*** execute API function depending on main argument
    $mainArg = array_shift($request);
    
    
    
    // search
    if ($mainArg==='search') {
        
        //get searchstring parameter
        $searchstring = array_shift($request);
        
        include_once('/home/bm01/api/_class/searchEngine.php');
        $search_engine = new searchEngine();
        
        //return search output
        echo $result = $search_engine->searchLawTexts($searchstring);
        
        
    // summary answer
    } else if ($mainArg==='answer') {
        
        //get searchstring parameters
        $searchstring = array_shift($request);
        $category_list = array_shift($request);
        $category_array = explode("+", $category_list);
        
        include_once('/home/bm01/api/_class/searchEngine.php');
        $search_engine = new searchEngine();
        
        //return search output
        echo $result = $search_engine->getSummaryFromLawTexts($searchstring, 6, $category_array);
        
    
    // get specific article text
    } else if ($mainArg==='article') {
        
        //get searchstring parameter
        $article_id = array_shift($request);
        
        include_once('/home/bm01/api/_class/searchEngine.php');
        $search_engine = new searchEngine();
        
        //return search output
        echo $result = $search_engine->getArticle($article_id);
        
        
    // test
    } else if ($mainArg==='test') {
        $arr = array('A' => 1, 'B' => 2, 'C' => 3, 'Response' => true);
        echo json_encode($arr);
    } else {
        incorrectArgs('Incorrect API arguments. Check API documentation for a list of valid arguments');
    }


    function incorrectArgs($errorMsg) {
        $arr = array('Error' => $errorMsg, 'Response' => false);
        echo json_encode($arr);
    }


?>