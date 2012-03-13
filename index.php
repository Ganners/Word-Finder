<?php
	//Require the word finder class
	require_once("com/app/word_finder/word_finder.php");
?>
<html>
	<head>
		<title>The Word Finder</title>
		<meta name="description" content="This is a word finder and anagram solver. It will prove the largest word from the top line of a keyboard is typewriter! It will also solve your Countdown Conundrums." />
		<meta name="keywords" content="anagram, anagram solver, solver, top line of a keyboard, typewriter, countdown, countdown conundrum" />
		<style type="text/css">
			
			@import url(http://fonts.googleapis.com/css?family=Droid+Sans:400,700);
			
			body {
				width: 100%;
				margin: 0;
				padding: 0;
				background: url(assets/images/bg.png);
				font-family: 'Droid Sans', Helvetica, Arial, sans-serif;
				text-align: center;
			}
			
			h1 {
				margin: 0;
				padding: 0;
				color: #333; 
				text-shadow: 0px 2px 3px #777;
				font-size: 2.3em;
				text-align: center;
				margin: 30px 0 10px;
				-webkit-text-stroke: 1px transparent;
				line-height: 0.79em;
			}
			
			div#rofl_container {
				width: 499px;
				height: 333px;
				margin: 0px auto;
				box-shadow: 0px 4px 5px rgba(0,0,0,0.7);
				-moz-box-shadow: 0px 4px 5px rgba(0,0,0,0.7);
				-webkit-box-shadow: 0px 4px 5px rgba(0,0,0,0.7);
			}
			
			div#message_box {
				width: 500px;
				margin: 0px auto;
				margin-top: 50px;
				margin-bottom: 20px;
			}
			
			ul {
				margin: 0;
				padding: 0;
				list-style-type: none;
			}
			
			label {
				display: block;
				float: left;
				width: 250px;
			}
			
			ul#submitform {
				text-align: left;
			}
			
			ul#submitform li {
				height: 30px;
			}
			
			input#submit {
				width: 100%;
				font-family: Arial, Helvetica, sans-serif;
				font-size: 14px;
				color: #050505;
				padding: 10px 20px;
				background: -moz-linear-gradient(
					top,
					#ffffff 0%,
					#ebebeb 50%,
					#dbdbdb 50%,
					#b5b5b5);
				background: -webkit-gradient(
					linear, left top, left bottom, 
					from(#ffffff),
					color-stop(0.50, #ebebeb),
					color-stop(0.50, #dbdbdb),
					to(#b5b5b5));
				border-radius: 10px;
				-moz-border-radius: 10px;
				-webkit-border-radius: 10px;
				border: 1px solid #949494;
				-moz-box-shadow:
					0px 1px 3px rgba(000,000,000,0.5),
					inset 0px 0px 2px rgba(255,255,255,1);
				-webkit-box-shadow:
					0px 1px 3px rgba(000,000,000,0.5),
					inset 0px 0px 2px rgba(255,255,255,1);
				text-shadow:
					0px -1px 0px rgba(000,000,000,0.2),
					0px 1px 0px rgba(255,255,255,1);
				float: left;
				padding-bottom: 10px;
			}
			
			input#submit:hover {
				/*** Adding CSS3 Gradients ***/
				background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#eee), to(#fff));
				background:  -moz-linear-gradient(19% 75% 90deg,#eee, #fff);
			}
			
			::selection {
				color: #333;
				background: #fff;
			}
			
			ul#wordlist {
				
			}
			
			ul#wordlist li{
				background: #fff;
				
				box-shadow: 0px 4px 5px rgba(0,0,0,0.2);
				-moz-box-shadow: 0px 4px 5px rgba(0,0,0,0.2);
				-webkit-box-shadow: 0px 4px 5px rgba(0,0,0,0.2);
				
				margin: 5px 0;
				padding: 5px 10px;
				height: auto;
				
				opacity: 0.8;
				
				font-weight: 900;
			}
			
		</style>
	</head>
	<body>
		<div id="message_box">
			<h1 style="font-size: 8.3em;">Word Finder</h1>
			<p>This was made to prove that the largest word you can type with the top line of a keybaord really is <strong>typewriter</strong>. IT IS TRUE! But there are some equally long words such as <strong>proprietor</strong>, <strong>perpetuity</strong> and <strong>repertoire</strong>.</p>
			<p>It can also be used to <strong>solve</strong> those <strong>Countdown Conundrums</strong>! Just tick <em>Match Letter Counts</em> and write in those vowels and consonants!</p>
			<p><strong>Try it for yourself!</strong></p>
			<hr />
			<form method="get">
				<ul id="submitform">
					<li><label for="word"><strong>Words/Random Letters:</strong></label><input type="text" name="word" id="word" value="<?php echo isset($_GET['word']) ? $_GET['word'] : ""; ?>" /></li>
					<li><label for="strict"><strong>Strict Search:</strong></label><input type="checkbox" name="strict" id="strict" value="1" <?php echo isset($_GET['strict']) && $_GET['strict'] == "1"  ? "checked='checked'" : "0"; ?> /></li>
					<li><label for="match_letter_count"><strong>Match Maximum Letter Counts:</strong></label><input type="checkbox" name="match_letter_count" id="match_letter_count" value="1" <?php echo isset($_GET['match_letter_count']) && $_GET['match_letter_count'] == "1"  ? "checked='checked'" : "0"; ?>/></li>
					<li><input type="submit" name="submit" id="submit" value="find results" /></li>
				</ul>
			</form>
			
			<?php
				//Example Usage
				if(isset($_GET['word']) && $_GET['word'] != NULL) {
					
					//The required usage to get the return array
					$Word_Finders = new Com\App\Word_Finder($_GET['word'], isset($_GET['strict']) ? TRUE : FALSE, isset($_GET['match_letter_count']) ? TRUE : FALSE);
					$arrWord_Finders = $Word_Finders->getWords();
					//The required usage to get the return array
					
					//Echo out the results
					echo '<h1>YOUR RESULTS</h1>';
					echo "<ul id='wordlist'>";
						foreach($arrWord_Finders as $anagram) {
							echo "<li>" . $anagram . " (" . strlen($anagram) . ")</li>";
						}
					echo "</ul>";
				}
			?>
			
		</div>
		
	</body>
</html>