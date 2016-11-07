<?php

class TextAnalyzer {
	
	public function getSentences($text) {
		//-	Sentence segmentation:
    //    o	Pick a set of sentences from multiple documents
		
		// $text = preg_split('/[?!]/', $text, NULL ,PREG_SPLIT_DELIM_CAPTURE );
		// $strcontent = '';
		// foreach($text as $key => $value) {
		// 	$strcontent .= str_replace("\n", ". ", $value);
		// }
		// return explode(". ", $strcontent);
		
		include_once('sentence.php');
		$sentence = new sentence();
		
		return $sentence->split($text);
		
	}
	
	
	public function simplifySentence($sentence) {
		//-	Simplify the sentences
    //    o	(Zajic et al. (2007), Controy et al. (2006), Vanderwende et al. (2007))
    //    o	Parse sentences, use rules to decide which modifiers to prune. Machine learning methods can be used aswell
		
		//TODO
		return $sentence;
		
	}


	public function getSentenceLikelihoodRatio($sentence) {
		//Conroy, Schlesinger and O’Leary 2006
		// -	Choose words that are informative either
		// 		o	By log-likelihood ratio (LLR)
		// 			o	Dunning (1993), Lin and Hovy (2000)
		// 				o	Ratio between:
		// 					?	The probability of observing a word in both the input and the background corpus assuming equal probabilities
		// 					?	The probability of observing a word in both the input and the background corpus assuming different probabilities
		// 		o	Or by appearing the query
		// 		o	Give the word a weight of 1, 1 or 0:
		// 			?	1 if the LLR ratio is positive, 1 if the word is in the query or 0 otherwise
		// -	Weigh a sentence by weight of its words
		// 		o	Weight(sentence) =  sum(weight(words))

		//TODO
		return 10;

	}
	
	
	
  public function getBestSummarySentence($sentences, $summary_sentences){
  	//return the element in $sentences with the highest likelihood ratio AND the least redundancy to the current $summary_sentences
    // o	Maximal Marginal Relevance (MMR), avoid redundancy
    //     ?	(Jaime Cardonell and Jade Goldstein, The Use of MMR, SIGIR-98)
    //     ?	Method: Iteratively (greedily) choose the best sentence to insert in the summary so far:
    //         •	Relevant: Maximally relevant to the user’s query (high cosine similarity to query)
    //         •	Novel: Minimally redundant with the summary so far (low cosine similarity to summary so far) 
  	
  	//TODO
  	return $sentences[0][0];
  	
  }
	
}



?>