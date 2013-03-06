<?php

namespace Com\App {

	/*
	* This class can be used to search for words within other words, or find 
	* out what words can be made using reusable letters for example. It can
	* also be used to solve countdown conundrums and other related issues.
	*
	* It uses an experimental method by reading in the entire dictionary, then
	* eliminating words one by one until it's left with the desired array.
	*
	* @version 1.0
	* @copyright 2012 Mark Gannaway <mark@ganners.co.uk>
	* @link http://ganners.co.uk
	* @license LGPL
	*/
	class Word_Finder {
		
		private $word,
			$dictionary = array(),
			$alphabet = array();
		
		/**
		* Public construct - used to define all required variables
		* @param (string) $word - The inputted word/letters to be searched
		* @param (bool) $strict - If the search is strict - which means it must use all letters at least once
		* @param (bool) $match_letter_count - This will mean it should match the maximum letter count, so the words can't reuse letters
		* @return void
		*/
		public function __construct($word, $strict = FALSE, $match_letter_count = FALSE) {
			
			//Sets the word to the lowercase array of letters
			$this->word = (array) str_split(strtolower($word));
			
			//Reads in the dictionary
			$this->dictionary = $this->getDictionary(dirname(__FILE__) . "/words.english");
			
			//Grabs the alphabet array
			$this->alphabet = $this->getFilteredAlphabetArray();
			
			//Performs the initial array magic and will loosely filter out words which don't contain any of the letters
			$this->filterLoose();
			
			//Will match the maximum letter counts if true
			if($match_letter_count) {
				$this->matchLetterCounts();
			}
			
			//Will strict search if true
			if($strict) {
				$this->filterStrict();
			}
			
		}
		
		/**
		* Will retrieve the words and perform a sort by string length
		* @param void
		* @return void
		*/
		public function getWords() {
		
			$sortArray = function($a, $b) {
				return strlen($b)-strlen($a);
			};
		
			usort($this->dictionary, $sortArray);
			return $this->dictionary;
		
		}
		
		/**
		* Will read in the dictionary file and return the array
		* @param (string) $file_name - The location of the dictionary file
		* @return (array) The dictionary array
		*/
		private function getDictionary($file_name) {
			$dictionary_file = file_get_contents($file_name);
			return (array) explode("\n", $dictionary_file);
		}
		
		/**
		* This will create an alphabet based on the letters that aren't in the inputted word.
		* @param void
		* @return (array) $alphabet - The alphabet containing words not in the object's word
		*/
		private function getFilteredAlphabetArray() {
		
			$alphabet = str_split("abcdefghijklmnopqrstuvwxyz");
			
			foreach($this->word as $wordLetter) {
				foreach($alphabet as $key => $alphabetLetter) {
					if($wordLetter == $alphabetLetter) {
						unset($alphabet[$key]);
					}
				}
			}
			
			return (array) $alphabet;
			
		}
		
		/**
		* This will filter out words which don't contain any letters from the formatted alphabet
		* @param void
		* @return void
		*/
		private function filterLoose() {
			foreach($this->alphabet as $letter) {
				foreach($this->dictionary as $key => $word) {
					$wordArr = str_split(strtolower($word));
					if(in_array($letter, $wordArr)) {
						unset($this->dictionary[$key]);
					}
				}
			}
			
		}
		
		/**
		* This will filter out words which don't contain all letters from the formatted alphabet
		* @param void
		* @return void
		*/
		private function filterStrict() {
			foreach($this->word as $wordLetter) {
				foreach($this->dictionary as $key => $word) {
					$wordArr = str_split($word);
					if(!in_array($wordLetter, $wordArr)) {
						unset($this->dictionary[$key]);
					}
				}
			}
		}
		
		/**
		* This will filter out words which don't contain more individual letters than that in the original word
		* @param void
		* @return void
		*/
		private function matchLetterCounts() {
		
			foreach($this->dictionary as $key => $dictionary_word) {
				$dictionary_word_count_values = array_count_values(str_split(strtolower($dictionary_word)));
				$word_count_values = array_count_values($this->word);
				
				foreach($word_count_values as $letter_count_value => $letter_count_amount) {
					if(isset($dictionary_word_count_values[$letter_count_value]) && ($letter_count_amount < $dictionary_word_count_values[$letter_count_value])) {
						unset($this->dictionary[$key]);
					}
				}
				
			}
		
		}
		
	}
}

?>
