<?php
session_start();
$email = $_SESSION['email'];
$role = $_SESSION['role'];
include 'connection.php';

$hid ="";
$hname="";
$hst_address="";
$hst_city="";
$hstate="";
$hzip="";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function getPosts()
{
    $posts = array();
    $posts[0] = $_POST['hid'];
    $posts[1] = $_POST['hname'];
    $posts[2] = $_POST['hst_address'];
    $posts[3] = $_POST['hst_city'];
    $posts[4] = $_POST['hstate'];
    $posts[5] = $_POST['hzip'];
   
   
    return $posts;
}

if(isset($_POST['search']))
{
    $data = getPosts();

    $search_Query = "SELECT * FROM hospital WHERE hid = $data[0]";

    $search_Result = mysqli_query($dbc,$search_Query);

    if($search_Result)
    {
        if(mysqli_num_rows($search_Result))
        {
            while($row = mysqli_fetch_array($search_Result))
            {
                $hid = $row['hid'];
                $hname = $row['hname'];
                $hst_address = $row['hst_address'];
                $hst_city = $row['hst_city'];
                $hstate = $row['hstate'];
                $hzip = $row['hzip'];
                
            }
        }
        else
        {
            echo'no data for this id';
        }
    }else
    {
        echo 'Result error';
    }

}


if(isset($_POST['insert']))
{  

$tmp = mysqli_query($dbc, "select max(hid) as hid from hospital");
$row = $tmp->fetch_assoc();
$hid_new = $row['hid'] + 1;


$data = getPosts();

if(($hname != null)&&($hst_address!= null)&&($hst_city!= null)&&($hstate!= null)&&($hzip!= null))
{

$insert_Query = "INSERT INTO `hospital`(`hid`, `hname`, `hst_address`, `hst_city`, `hstate`,`hzip`)
 VALUES ($hid_new,'$data[1]','$data[2]','$data[3]','$data[4]',$data[5])";
 
 }
	     if(($hname != null)&&($hst_address!= null)&&($hst_city!= null)&&($hstate!= null)&&($hzip!= null))
	     {
	        echo 'Data Inserted';
	     }	
	    if (($hname == null) or($hst_address== null)or($hst_city == null)or($hstate== null)or($hzip== null))
	     {
	      	echo 'Data Not Inserted';
	     
	     }
}




if(isset($_POST['delete']))
{  
$data = getPosts();
$delete_Query = "DELETE FROM `hospital`  WHERE `hid` = $data[0]";
	try
	{
		$delete_Result = mysqli_query($dbc,$delete_Query);
		
		if($delete_Result)
		{
	     if(mysqli_affected_rows($dbc) > 0)
	     {
	        echo 'Data deleted';
	     }	
	     else
	     {
	      	echo 'Data Not deleted';
	      }
	    }
	} catch (Exception $ex){ 
	 	 echo 'ERROR delete'.$ex->getMessage();
	}
}


if(isset($_POST['update']))
{  
$data = getPosts();
$update_Query = "UPDATE `hospital` SET `hname`='$data[1]',
`hst_address`='$data[2]',`hst_city`='$data[3]',`hstate`='$data[4]', `hzip`=$data[5] WHERE `hid`= $data[0]";
	try
	{
		$update_Result = mysqli_query($dbc,$update_Query);
		
		if($update_Result)
		{
	     if(mysqli_affected_rows($dbc) > 0)
	     {
	        echo 'Data updated';
	     }	
	     else
	     {
	      	echo 'Data Not updated';
	      }
	    }
	} catch (Exception $ex){ 
	 	 echo 'ERROR update'.$ex->getMessage();
	}
}

?>


   

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>FunFunFunding</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/stylish-portfolio.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <style>

        .title{
            color: #FFFFFF;
        }

        .navbar-brand{
            font-size: 1.8em;
        }


        #topRow h1 {
            font-size: 300%;

        }

        .center{
            text-align: center;
        }

        .title{
            margin-top: 100px;
            font-size: 300%;
        }

        #footer {
            background-color: #B0D1FB;
        }

        .marginBottom{
            margin-bottom: 30px;
        }

        .tagcontainer{
            height: 350px;
            width: 1200px;
            background:url("images/hometagbackground.jpg") center;
            color: white;
        }

    </style>
</head>
<body>
<div style="border:2px solid #a1a1a1; border-radius:25px;padding:50px 40px;width:1000px; text-align:center;margin-left:auto;margin-right: auto;margin-top: 100px;margin-bottom: 50px;" >
<div class ="navbar-default navbar-fixed-top">
    <div class = "container">
        <div class ="navbar-header">
            <button class ="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">

                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>

            </button>
            <a class="navbar-brand">LPHospital</a>

        </div>
        <div class="collapse navbar-collapse">

            <ul class ="nav navbar-nav" id="ul1">
                <li><a href="homepage.php">Home</a></li>
                <li class="active"><a href="diesase.php">Data Manipulation</a></li>
                <li><a href ="dataanalysis.php">Data Analysis</a></li>
                <li><a href ="createRecord.php">Create Record</a></li>
            </ul>
            <ul class ="nav navbar-nav">
                <li><?php echo "<a>Hello, " .$email. "!</a>"?></li>
            </ul>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-md-offset-4 col-no-padding well">
        <form action="department.php"  method="POST">
            <fieldset>
                <div class="form-group">
                    <input type="number" name="hid" placeholder= "hid(3 digits)" value="<?php echo $hid;?>" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="text" name="hname" placeholder = "hname" value="<?php echo $hname;?>" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="text" name="hst_address" placeholder= "hst_address" value="<?php echo $hst_address;?>" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="text" name="hst_city" placeholder = "hst_city" value="<?php echo $hst_city;?>" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="text" name="hstate" placeholder = "hstate" value="<?php echo $hstate;?>" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="number" name="hzip" placeholder = "hzip(5 digits)" value="<?php echo $hzip;?>" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="insert" value="Add" class="btn btn-primary" />
                    <input type="submit" name="update" value="Update" class="btn btn-primary" />
                    <input type="submit" name="delete" value="Delete" class="btn btn-primary" />
                    <input type="submit" name="search" value="Find" class="btn btn-primary" />
                </div>
            </fieldset>
        </form>
    </div>
</div>
<?php
$result = mysqli_query ($dbc,"select * from hospital");

echo "<table align=\"center\" style=\"text-align: center;width: 900px; \" class=\"table table-striped\">
    <caption><h1>Hospital Information</h1></caption>
	<tr>
	<th>HOSPITAL ID</th>
	<th>HOSPITAL NAME</th>
	<th>HOSPITAL ADDRESS</th>
	<th>HOSPITAL CITY</th>
	<th>HOSPITAL STATE</th>
	<th>ZIPCODE</th>
	
	
	<th>";

while($row = mysqli_fetch_array($result))
{	echo "<tr>";
    echo "<td>".$row['hid']."</td>";
    echo "<td>".$row['hname']."</td>";
    echo "<td>".$row['hst_address']."</td>";
    echo "<td>".$row['hst_city']."</td>";
    echo "<td>".$row['hstate']."</td>";
    echo "<td>".$row['hzip']."</td>";

    echo "<tr>";

}?>
</div>
</body>
</html>