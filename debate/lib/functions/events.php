<?php 

$state = $_POST['state'];

require __DIR__ . '/dbconn.php';

session_start();

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
							<p class=\"card-text\">". $events['address'] .", ". $events['city'] .", ". $events['zip'] ." | Event date: " . $date['month'] . "/" . $date['day'] . "/" . $date['year'] . "</p>
							<button href=\"#\" class=\"btn btn-dark\">Edit Event and Debates</button>
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

?>