<!--chapter 6 tutorial-->
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Message Board</title>
</head>
<body>
	<h1>Message Board</h1>
	<?php
		
	if(isset($_GET["action"])) {
		if ((file_exists("MessageBoard/messages.txt"))&& (file_exists("MessageBoard/messages.txt")!=0)) {
			// a button has been clicked on and the file message.txt exists with content
			$MessageArray = file("MessageBoard/messages.txt");


			switch ($_GET["action"]) {
				case "DeleteFirst":
					array_shift($MessageArray);
					break;
				
				case "Delete Last":
					array_pop($MessageArray);
					break;
				case "DeleteMessage":
					if (isset($_GET["message"])){
						array_splice($MessageArray, $_GET["message"], 1);
					}
					break;
					case 'Remove Duplicates':
						$MessageArray = array_unique($MessageArray);
						$MessageArray = array_values($MessageArray);
						break;
				
			}// end of switch
		
			if (count($MessageArray)> 0) {
				$NewMessage = implode($MessageArray);
				$MessageStore =fopen("MessageBoard/messages.txt", "wb");
				// check if the file is not accessable
				if ($MessageStore === FALSE) {
					echo "There was a erro updated the message file!\n";
				}
				else {
					fwrite($MessageStore, $NewMessage);
					fclose($MessageStore);

				}
			}


			else {
				// if no messages, delete that file
				unlink("MessageBoard/messages.txt");
			}
		}

	}




		if ((!file_exists("MessageBoard/messages.txt"))|| (filesize("MessageBoard/messages.txt") == 0)) {
		
			echo "<p> There no messages posted.</p>\n";
		}

		else {
			// use the file method () create array out of each message in the text file
			$MessageArray = file("MessageBoard/messages.txt");

			echo "<table style = \"background-color: lightgray;\" border = \"1\" width =\"100%\">\n";
			
			// variables that simply counts the number of items in the $MessageArray
			$count=count($MessageArray);

			// for every message that array has, we will loop to create a new <tr> element and create the content
			for ($i = 0; $i <$count; ++$i) { 
				$CurrMsg = explode("~", $MessageArray[$i]);
				echo "<tr>\n";
				
				echo "<td width = \"5%\" style = \" text-align: center; font-weight: bold;\">"
				.($i + 1). "</td>\n";
				echo "<td width = \"95%\"><span style = \"font-weight; bold;\">Subject: </span>" . 
				htmlentities($CurrMsg[0]). "<br/> \n";
				
				echo "<span style = \"font-weight; bold;\">Name: </span>" . 
				htmlentities($CurrMsg[1]). "<br/> \n";
				
				echo "<span style = \"font-weight; bold text-decoration: underline;\">Message: </span><br/>\n" . htmlentities($CurrMsg[2]). "<td/> \n";

				echo "</td width = \"10%\"style = \"text-align:center;\">" . "<a href = 'MessageBoard.php?" . "action = Delete%20Message&" . "message = $i'>" . "Delete This Message </a> <td>\n";

				echo "</tr>\n";

				echo"</table>\n";
			}


		}

	?>
	<p>><a href="PostMessage.php">Post New Message</a></p>
	<P> <a href="MessageBoard.php?action = Remove%20Duplicate">Remove Duplicate Message</a></P>
	<p><a href="MessageBoard.php?action=Delete%20First">Delete First Message</a></p>
	<p><a href="MessageBoard.php?action=Delete%20Last">Delete Last Message</a></p>
</body>
</html>