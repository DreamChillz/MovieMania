<?php

include('connection.php');
include('loginAccess.php');

$user_id = $_SESSION['user_id'];
$role=$_SESSION['role'];

?>
<?php
//get user data from database
if($role==='user'){
    include('sidenav.php') ;
    $query="SELECT * 
            FROM user
            WHERE user_id='$user_id'
            ";
    
} elseif($role==='admin'){
    include('sidenav_admin.php') ;
    $query="SELECT * 
    FROM admin
    WHERE admin_id='$user_id'
    ";
}


$results=mysqli_query($connect,$query);

if(mysqli_num_rows($results)==1){
    $row=mysqli_fetch_assoc($results);

     // Check if the user has a profile image
     if (!empty($row['profile_image'])) {
        // If the user has uploaded a profile picture
        $imageData = base64_encode($row["profile_image"]);
        $src = 'data:image/jpeg;base64,' . $imageData;
    } else {
        // If no profile picture exists, use a default image
        $src='images/blank_pp.webp';
    }

    $current_constellation=$row['constellation'];
    //constellation options
    $constellations=["Aries", "Taurus", "Gemini", "Cancer", "Leo", "Virgo", "Libra", "Scorpio", "Sagittarius", "Capricorn", "Aquarius", "Pisces"];

};


?>

<?php
if(isset($_POST['btnUpdate'])){
    $name =$_POST['txtName'];
    $gender =$_POST['gender'];
    $country =$_POST['txtCountry'];
    $phone_number =$_POST['txtPhoneNo'];
    $date_of_birth =$_POST['dateDOB'];
    $constellation =$_POST['constellationSelect'];
    $bio =mysqli_real_escape_string($connect, $_POST['bio']);


    $image_data = NULL;
    // Handle profile image (LONGBLOB) upload
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === 0) {
        $image_tmp_name = $_FILES['profile_image']['tmp_name'];
        $image_size = $_FILES['profile_image']['size'];
        
        if ($image_size > 0) {
            // Read the image file as binary data
            $image_data = file_get_contents($image_tmp_name);
        } else {
            echo '<script>alert("Failed to upload image: empty file.")</script>';
        }
    } 

    if($role==='user'){
        $query="UPDATE user SET
        name='$name',
        gender='$gender',
        country='$country',
        phone_number='$phone_number',
        date_of_birth='$date_of_birth',
        constellation='$constellation',
        bio='$bio'";

       if ($image_data !== NULL) {
        $query .= ", profile_image='" . mysqli_real_escape_string($connect, $image_data) . "'";
        }

        $query .= " WHERE user_id='$user_id'";
        
        
    } elseif($role==='admin'){
        $query="UPDATE admin SET
        name='$name',
        gender='$gender',
        country='$country',
        phone_number='$phone_number',
        date_of_birth='$date_of_birth',
        constellation='$constellation',
        bio='$bio'";

        if ($image_data !== NULL) {
        $query .= ", profile_image='" . mysqli_real_escape_string($connect, $image_data) . "'";
        }

        $query .= " WHERE admin_id='$user_id'";
     
    }

    if(mysqli_query($connect,$query)){
        echo "<script>alert('Profile updated successfully.');
        window.location.href = 'profile.php';
        </script>'";
    }
    else{
        echo "<script>alert('Error updating profile.');
        window.location.href = 'update_profile.php';
        </script>'";
    }

   
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="images/logo2.png">
    <!-- stylesheet -->
    <link rel="stylesheet" href="manage-profile-css.css">
    <!-- fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">

    <!-- icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
<div id="main">
<div class="profile-container">
    <form class="profile-form" action="" method="post" enctype="multipart/form-data">
        <div class="form-container">
            
        
        <div class="profile-left-container">
            <img class="profile-image" src="<?php echo $src ?>" alt="">
            <input type="file" name="profile_image" id="profile_image">
            

        </div>
        <div class="profile-right-container">

            <?php echo"<h1>".$user_id."'s Profile</h1>" ?>
                
                <div class="input-row">
                    <label for="name" class="user-info">Name: </label>
                    <input id="name" type="text" name="txtName" required value="<?php echo $row['name']; ?>">
                </div>

                <div class="input-row">
                    <label for="gender" class="user-info">Gender:</label>
                    <input type="radio" id="male" name="gender" value="Male" required 
                    <?php if (ucfirst($row['gender']) == 'Male') echo 'checked'; ?> >
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="Female" required 
                    <?php if (ucfirst($row['gender']) == 'Female') echo 'checked'; ?> >
                    <label for="female">Female</label>

                </div>

                <div class="input-row">
                    <label for="country" class="user-info">Country: </label>
                    <input id="country" type="text" name="txtCountry" required value="<?php echo $row['country']; ?>">
                </div>

                <div class="input-row">  
                    <label for="email" class="user-info">Email: </label>
                    <input id="email" readonly type="email" name="txtEmail" value="<?php echo $row['email']; ?>">

                </div>

                <div class="input-row">          
                    <label for="phoneNo" class="user-info">Phone Number: </label>
                    <input id="phoneNo" type="text" name="txtPhoneNo" required  value="<?php echo $row['phone_number']; ?>">

                </div>

                

                <div class="input-row">
                    <label for="dob" class="user-info">Date of Birth: </label>
                    <input id="dob" type="date" name="dateDOB" required  value="<?php echo $row['date_of_birth']; ?>">
                    
                </div>

                <div class="input-row">
                    <label for="constellation" class="user-info">Constellation: </label>
                    <select name="constellationSelect" required  id="constellation">
                    <?php
                    foreach ($constellations as $constellation) {
                        $selected = ($constellation == $current_constellation) ? 'selected' : '';
                        echo "<option value='$constellation' $selected>$constellation</option>";
                    }
                    ?>
                    </select>   
                </div>
                    
                <div class="input-row">
                    <label for="bio" class="user-info">Bio: </label>
                    <textarea rows="5" name="bio" id="bio" ><?php echo $row['bio']; ?></textarea>
                </div>
                
                    <input type="submit" value="Update Profile" name="btnUpdate">

            </div>
            </div>
    </form>
</div>    
    
</div>
        

</body>
</html>

<?php

if($role==='user'){
    include('footer.php') ;
    
} elseif($role==='admin'){
    include('footer_admin.php') ;
}
?>