<?php
        $team = (int) $_POST['team_id'];
        $firstName     = trim( preg_replace("/\t|\R/",' ',$_POST['firstName']) );
        $lastName      = trim( preg_replace("/\t|\R/",' ',$_POST['lastName'])  );
        $street        = trim( preg_replace("/\t|\R/",' ',$_POST['street'])    );
        $city          = trim( preg_replace("/\t|\R/",' ',$_POST['city'])      );
        $state         = trim( preg_replace("/\t|\R/",' ',$_POST['state'])     );
        $country       = trim( preg_replace("/\t|\R/",' ',$_POST['country'])   );
        $zipCode       = trim( preg_replace("/\t|\R/",' ',$_POST['zipCode'])   );

        if( empty($team) ) $team = null;

        if( empty($firstName) ) $firstName = null;
        if( empty($lastName)  ) $lastName  = null;
        if( empty($street)    ) $street    = null;
        if( empty($city)      ) $city      = null;
        if( empty($state)     ) $state     = null;
        if( empty($country)   ) $country   = null;
        if( empty($zipCode)   ) $zipCode   = null;


        if( ! empty($lastName) ) // Verify required fields are present
        {
          require_once( 'db.php' );
          $mysqli = new mysqli(DATA_BASE_HOST, USER_NAME, USER_PASSWORD, DATA_BASE_NAME);

          if( mysqli_connect_error() == 0 )  // Connection succeeded
          {
            $query = "INSERT INTO PLAYER SET
                        Name_First = ?,
                        Name_Last  = ?,
                        Street     = ?,
                        City       = ?,
                        State      = ?,
                        Country    = ?,
                        ZipCode    = ?,
                        PlayerTeamId = ?";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('sssssssd', $firstName, $lastName, $street, $city, $state, $country, $zipCode,$team);
            $stmt->execute();

          }
        }

        require('viewplayers.php');

?>
