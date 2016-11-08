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
		
		include_once('helpers/sentence.php');
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


	public function getSentenceWeight($sentence, $background_corpus, $query_array) {
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
		//
		//	http://www.ir-facility.org/scoring-and-ranking-techniques-tf-idf-term-weighting-and-cosine-similarity 
		//	TF(t) = (Number of times term t appears in a document) / (Total number of terms in the document).
		//	IDF(t) = log_e(Total number of documents / Number of documents with term t in it).


		//TODO
		$score = 0;
		
		//split sentence into words
		$words = explode(" ", $sentence);
		
		$term_in_doc = 0;
		foreach ($query_array as $query_word) {
			foreach ($query_word as $synonym) {
				
				
				$term_in_doc += substr_count($sentence, $synonym);
			}
		}
		
		if ($term_in_doc !== 0) {
			
			$query_term_frequency = $term_in_doc / count($words);
			
			foreach ($words as $word) {
				
				$matching_docs = 0;
				foreach ($background_corpus as $document) {
					if (is_string($word) && is_string($document) && ($word !== '')) {
						if (strpos($document, $word) !== false) {
							$matching_docs += 1;
						}
					}
				}
				
				$document_frequency = count($background_corpus) / $matching_docs;
				$inversed_df = log10($document_frequency);
				
				$score += $query_term_frequency / $inversed_df;
			}
			
			
		}
		
		return $score;
	}
	
	
	
  public function getBestSummarySentence($sentences, $summary_sentences) {
  	//return the element in $sentences with the highest likelihood ratio AND the least redundancy to the current $summary_sentences
    // o	Maximal Marginal Relevance (MMR), avoid redundancy
    //     ?	(Jaime Cardonell and Jade Goldstein, The Use of MMR, SIGIR-98)
    //     ?	Method: Iteratively (greedily) choose the best sentence to insert in the summary so far:
    //         •	Relevant: Maximally relevant to the user’s query (high cosine similarity to query)
    //         •	Novel: Minimally redundant with the summary so far (low cosine similarity to summary so far) 
  	
  	//http://www.ir-facility.org/scoring-and-ranking-techniques-tf-idf-term-weighting-and-cosine-similarity
  	
  	//TODO
  	
  	$highest_score = 0;
  	$best_sentence = '';
  	foreach ($sentences as $sentence) {
  		if (($sentence[1] > $highest_score) && !(in_array($sentence[0], $summary_sentences))) {
  			$highest_score = $sentence[1];
  			$best_sentence = $sentence[0];
  		}
  	}
  	
  	return $best_sentence;
  	
  }
	
}



?>