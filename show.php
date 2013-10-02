<?php
/*** Check the $_GET variable ***/
if(filter_has_var(INPUT_GET, "image_id") !== false && filter_input(INPUT_GET, 'image_id', FILTER_VALIDATE_INT) !== false)
    {
    /*** set the image_id variable ***/
    $image_id = filter_input(INPUT_GET, "image_id", FILTER_SANITIZE_NUMBER_INT);
   try    {
          /*** connect to the database ***/
          $dbh = new PDO("mysql:host=localhost:3307;dbname=elo", 'root', 'root');

          /*** set the PDO error mode to exception ***/
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

          /*** The sql statement ***/
          $sql = "SELECT image_type, image_size, image_name FROM testblob WHERE image_id=".$image_id;

          /*** prepare the sql ***/
          $stmt = $dbh->prepare($sql);

          /*** exceute the query ***/
          $stmt->execute(); 

          /*** set the fetch mode to associative array ***/
          $stmt->setFetchMode(PDO::FETCH_ASSOC);

          /*** set the header for the image ***/
          $array = $stmt->fetch();

          /*** the size of the array should be 3 (1 for each field) ***/
          if(sizeof($array) === 3)
              {
              //echo '<p>This is '.$array['image_name'].' from the database</p>';
              $tem=$array['image_name'];
              //echo "file source is from $tem";
              
              echo '<img '.$array['image_size'].' src="'.$tem.'"width="400" height="400">';
              }
          else
              {
              throw new Exception("Out of bounds error");
              }
          }
       catch(PDOException $e)
          {
          echo $e->getMessage();
          }
       catch(Exception $e)
          {
          echo $e->getMessage();
          }
      }
 else
      {
      echo 'Please use a valid image id number';
      }
?>

<head><title>show image</title></head>
