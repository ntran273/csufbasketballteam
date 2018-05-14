<!-- CREATE GAMES -->
<?php
// <!-- GameID INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
// StartDate DATE,
// TimeSchedule TIME,
// ATeamID INT(10) UNSIGNED NOT NULL,
// BTeamID INT(10) UNSIGNED NOT NULL, -->

        $StartDate   = trim( preg_replace("/\t|\R/",' ',$_POST['StartDate']) );
        $TimeSchedule     = trim( preg_replace("/\t|\R/",' ',$_POST['TimeSchedule']));
        $teamid = (int) $_POST['team_id2'];
        $teamid2 = (int) $_POST['team_id3'];

        if( empty($teamid) ) $team = null;
        if( empty($teamid2) ) $team = null;

        if( empty($StartDate) ) $StartDate = null;
        if( empty($TimeSchedule)  ) $TimeSchedule  = null;

        require_once( 'db.php' );
        $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

        //Check if the date, the time, the home teame or away team is already placed
        $result = $mysqli->query("SELECT * FROM GAME
          WHERE StartDate ='$StartDate' AND TimeSchedule = '$TimeSchedule' AND ATeamID = $teamid AND BTeamID = $teamid2") or die($mysqli->error());

        if($result->num_rows>0){
          require('admin_creategames.php');
        }else{
          if( ! empty($StartDate) ) // Verify required fields are present
          {

            if( mysqli_connect_error() == 0 )  // Connection succeeded
            {
              $query = "INSERT INTO GAME SET
                          StartDate = ?,
                          TimeSchedule  = ?,
                          ATeamID     = ?,
                          BTeamID      = ?";
              $stmt = $mysqli->prepare($query);
              $stmt->bind_param('ssdd', $StartDate, $TimeSchedule, $teamid,$teamid2);
              $stmt->execute();

            }
          }

        }


        require('admin_creategames.php');

?>
