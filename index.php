<?php

//define a maxim size for the uploaded images in Kb
 define ("MAX_SIZE","1000"); 

//This function reads the extension of the file. It is used to determine if the
// file  is an image by checking the extension.
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         //print("The extension of the file\t".$ext);
         return $ext;
 }

//This variable is used as a flag. The value is initialized with 0 (meaning no 
// error  found)  
//and it will be changed to 1 if an errro occures.  
//If the error occures the file will not be uploaded.
 $errors=0;
 $errors1=0;
//checks if the form has been submitted
 if(isset($_POST['Submit'])) 
 {
 	//reads the name of the file the user submitted for uploading
  $image1=null;
  $image=null;
 	$image=$_FILES['image']['name'];
  $image1=$_FILES['image1']['name'];
  //echo "image value\t".$image."image 1 value\t".$image1;
  if ($image1==null || $image==null) {
    echo "<center>Please Select 2 images</center>";
    $errors=1;
    $errors1=1;
  }
 	//if it is not empty
 	if ($image) 
 	{
 	//get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['image']['name']);
 	//get the extension of the file in a lower case format
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
    //adding code
    
 	//if it is not a known extension, we will suppose it is an error and 
        // will not  upload the file,  
	//otherwise we will do more tests
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension !=
 "png") && ($extension != "gif")) 
 		{
		//print error message
 			echo '<h1>Unknown extension!</h1>';
 			$errors=1;
 		}
 		else
 		{
//get the size of the image in bytes
 //$_FILES['image']['tmp_name'] is the temporary filename of the file
 //in which the uploaded file was stored on the server
 $size=filesize($_FILES['image']['tmp_name']);
 $imgfp = fopen($_FILES['image']['tmp_name'], 'rb');

//compare the size with the maxim size we defined and print error if bigger
if ($size > MAX_SIZE*1024)
{
	echo 'You have exceeded the size limit!';
	$errors=1;
}

//we will give an unique name, for example the time in unix time format
$image_name=time().'.'.$extension;
//the new name will be containing the full path where will be stored (images 
//folder)
$newname="images/".$image_name;
//we verify if the image has been uploaded, and print error instead
$copied = copy($_FILES['image']['tmp_name'], $newname);
if (!$copied) 
{
	echo 'Copy unsuccessfull!';
	$errors=1;
}}}

//second img
if ($image1) 
  {
  //get the original name of the file from the clients machine
    $filename1 = stripslashes($_FILES['image1']['name']);
  //get the extension of the file in a lower case format
      $extension1 = getExtension($filename1);
    $extension1 = strtolower($extension1);
    //adding code
    
  //if it is not a known extension, we will suppose it is an error and 
        // will not  upload the file,  
  //otherwise we will do more tests
 if (($extension1 != "jpg") && ($extension1 != "jpeg") && ($extension1 !=
 "png") && ($extension1 != "gif")) 
    {
    //print error message
      echo 'Unknown extension!';
      $errors1=1;
    }
    else
    {
//get the size of the image in bytes
 //$_FILES['image']['tmp_name'] is the temporary filename of the file
 //in which the uploaded file was stored on the server
 $size1=filesize($_FILES['image']['tmp_name']);
 $imgfp1 = fopen($_FILES['image']['tmp_name'], 'rb');

//compare the size with the maxim size we defined and print error if bigger
if ($size1 > MAX_SIZE*1024)
{
  echo 'You have exceeded the size limit!';
  $errors1=1;
}

//we will give an unique name, for example the time in unix time format
$image_name1=time().'.'.$extension;
//the new name will be containing the full path where will be stored (images 
//folder)
$newname1="images/".$image_name1;
//we verify if the image has been uploaded, and print error instead
$copied1 = copy($_FILES['image1']['tmp_name'], $newname);
if (!$copied1) 
{
  echo 'Copy unsuccessfull!';
  $errors1=1;
}}}

//end of second img

}

//If no errors registred, print the success message
 if(isset($_POST['Submit']) && !$errors && !$errors1) 
 {
 	

  try{
            /*** connect to db ***/
        $dbh = new PDO("mysql:host=localhost:3307;dbname=elo", 'root', 'root');

                /*** set the error mode ***/
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            /*** our sql query ***/
        $stmt = $dbh->prepare("INSERT INTO testblob (image_type,image, image_size, image_name) VALUES (?,?, ?, ?)");

        /*** bind the params ***/
        $stmt->bindParam(1, $extension);
        $stmt->bindParam(2, $imgfp, PDO::PARAM_LOB);
        $stmt->bindParam(3, $size);
        $stmt->bindParam(4, $newname);

        /*** execute the query ***/
        $stmt->execute();
        

  }catch(Exception $e){
    echo '<h4>'.$e->getMessage().'</h4>';

  }


 }
 //If no errors registred, print the success message
 if(isset($_POST['Submit']) && !$errors && !$errors1) 
 {
  

  try{
            /*** connect to db ***/
        $dbh = new PDO("mysql:host=localhost:3307;dbname=elo", 'root', 'root');

                /*** set the error mode ***/
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            /*** our sql query ***/
        $stmt = $dbh->prepare("INSERT INTO testblob (image_type,image, image_size, image_name) VALUES (?,?, ?, ?)");

        /*** bind the params ***/
        $stmt->bindParam(1, $extension1);
        $stmt->bindParam(2, $imgfp1, PDO::PARAM_LOB);
        $stmt->bindParam(3, $size1);
        $stmt->bindParam(4, $newname1);

        /*** execute the query ***/
        $stmt->execute();
        

  }catch(Exception $e){
    echo '<h4>'.$e->getMessage().'</h4>';

  }


 }

 if (isset($_POST['Submit']) && !$errors && !$errors1) {
   echo "upload success";
 }

 ?>

 <!--next comes the form, you must set the enctype to "multipart/frm-data" 
and use an input type "file" -->
<html>
<head><title>Image Upload</title></head>

<body>
  <center>
 <form name="newad" method="post" enctype="multipart/form-data"  
action="">
<a href="www.facebook.com/monishstrithick">Author: Monish M</a>
<h3>Upload Image</h3>
 <table>
  <tr>  <th>Select an image</th></tr>
 	<tr><td><input type="file" name="image"></td></tr>
  <tr><td><input type="file" name="image1"></td></tr>
 	<tr><td><input name="Submit" type="submit" value="Upload image">
       </td></tr>
 </table>	
 </form>
 </center>
 <body>
 </html>
