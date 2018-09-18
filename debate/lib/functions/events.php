<?php 

if(isset($_POST['state'])){$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);}
if(isset($_POST['id'])){$id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);}

require __DIR__ . '/dbconn.php';

session_start();

if (isset($state)) {
	if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SESSION['level'] >= 6 && in_array($state, array(0,1,2,3,4,5,6,7,8,9,10))){ 
			try {
				$db = new DbConn;
				$stmt = $db->conn->prepare("SELECT * FROM events WHERE state = :state ORDER BY date DESC");
				$stmt->bindParam(":state", $state);
				$stmt->execute();
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
				$i = 0;
				foreach ($result as $events) {
					$i++;
					if ($events['region'] != NULL) {
						$type = "One-day";
						$icon = "fa-clock";
					} else {
						$type = "Convention";
						$icon = "fa-calendar-alt";
					}
					$date = date_parse($events['date']);
					print "<div class=\"card\">
							<div class=\"card-header\">". $type ."</div>
							<div class=\"card-body\">
								<h5 class=\"card-title\">". $events['name'] ."<span style=\"font-size: 3em; float:right; margin-right: 20px;\"><i class=\"fas " . $icon . "\"></i></span></h5>
								<p class=\"card-text\">". $events['address'] .", ". $events['city'] ." ". $events['zip'] ." | Event date: " . $date['month'] . "/" . $date['day'] . "/" . $date['year'] . "</p>
								<button onClick=\"load(". $events['id'].")\" class=\"btn btn-dark\">Edit Event and Debates</button>
							  </div>
						</div>";
					if ((count($result) - $i) > 0){
						print "<br>";
					}
				}
				if (count($result) == 0) {
					print "<p style=\"color: white\">No events currently registered.</p><hr>";
				} else {
					print "<hr>";
				}

				print "<button class=\"btn btn-light\" onClick=\"add()\">Add New Event</button>";

			} catch (Exception $e) {
				echo "<p style=\"color: white\">Error occurred while loading.</p>";
			}


	} 
} elseif(isset($id)) {
	if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SESSION['level'] >= 2) {
		try {
			$db = new DbConn;
			$stmt = $db->conn->prepare("SELECT * FROM debates WHERE event = :event ORDER BY block");
			/** 
				MAKE IT SEPARATE BY BLOCKS
			*/
			$stmt->bindParam(":event", $id);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			$rdb = new DbConn;
			$rstmt = $rdb->conn->prepare("SELECT * FROM events WHERE id = :event");
			/** 
				USE OUTPUT FOR EDIT EVENT MODAL
			*/
			$rstmt->bindParam(":event", $id);
			$rstmt->execute();
			$rresult = $rstmt->fetch(PDO::FETCH_ASSOC);
			
			print "<h2 style=\"color: white\">" . $rresult['name'] . "</h2><hr>";
			
			if ($_SESSION['level'] == 2) { print "<button class=\"btn btn-light\" onClick=\"revert()\">Return to All Events</button>"; } else { print "<button class=\"btn btn-light\" onClick=\"edit(" . $id . ")\">Edit Event Details</button>&nbsp<button class=\"btn btn-light\" onClick=\"revert()\">Return to All Events</button>"; }
			print "<hr>";
			$i = 0;
			foreach ($result as $debate) {
				$i++;
				/** 
				ADD DIFFERENT DEBATE STYLES HERE
				*/
				if ($debate['thought_talk'] == 1) {
					$type = "Thought Talk";
					$icon = "fa-comments";
				} else {
					$type = "Debate";
					$icon = "fa-gavel";
				}
				print "<div class=\"card\">
						<div class=\"card-header\">". $type ." - Block " . $debate['block'] . "</div>
						<div class=\"card-body\">
							<h5 class=\"card-title\">". $debate['name'] ."<span style=\"font-size: 3em; float:right; margin-right: 20px;\"><i class=\"fas " . $icon . "\"></i></span></h5>
							<p class=\"card-text\">". $debate['explanation'] ."</p>
							<button onClick=\"debate(". $debate['id'].")\" class=\"btn btn-dark\">View Debate Details</button>
						  </div>
					</div>";
				if ((count($result) - $i) > 0){
					print "<br>";
				}
			}
			
			if (count($result) == 0) {
				print "<p style=\"color: white\">No active debates.</p><hr>";
			} else {
				print "<hr>";
			}
			
			if ($_SESSION['level'] != 2) { 
				print "<button class=\"btn btn-light\" onClick=\"talk()\">Add New Debate</button>"; 
				print "GT";
			}
			
		} catch (Exception $e) {
			echo "<p style=\"color: white\">Error occurred while loading.</p>";
		}
	}
}


?>