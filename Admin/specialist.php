<?php
$con = mysqli_connect("localhost", "root", "root");
if (!$con) {
    die('Could not connect: ' . mysqli_error());
}

mysqli_select_db($con, "clinicosight");

//Insert record
if (isset($_POST["button"])) {
    $sql = "INSERT INTO specislist (spid, sptype, comment)
VALUES
('$_POST[slno]','$_POST[type]','$_POST[comment]')";

    if (!mysql_query($sql, $con)) {
        die('Error: ' . mysql_error());
    }
    echo "1 record added";
}

//increment sl id
$result = mysqli_query($con,"SELECT MAX(spid) FROM specislist");

while ($row = mysqli_fetch_array($result)) {
    $spmax = $row[0];
}
$spmax += 1;

//Update : select query to update

$result = mysqli_query($con,"SELECT * FROM specislist
WHERE spid='$_GET[spid]'");

while ($row = mysqli_fetch_array($result)) {
    $spid    = $row['spid'];
    $stype   = $row['sptype'];
    $comment = $row['comment'];
}

//update record
if (isset($_POST["btnupdate"])) {
    mysqli_query($con,"UPDATE specislist SET sptype = '$_POST[type]',comment= '$_POST[comment]' WHERE spid = '$_POST[slno]' ");
    echo "Record Updated Successfully";
}
//Delete Record
if (isset($_GET["delid"])) {
    mysqli_query($con, "DELETE FROM specislist WHERE spid = '$_GET[delid]'");
    echo "Record Deleted Successfully";
}
?>



<form name="form1" method="post" action="">
  <p>
    <label for="textfield1">SL No :</label>
   &nbsp;&nbsp;
    <?php
//to update
if (isset($_GET[spid])) {
    echo "<input name='slno' type='text' value='$_GET[spid]' readonly>";
}
//to insert
else {
    echo "<input name='slno' type='text' value='$spmax' readonly>";
}
?>
  </p>
  <p>
    <label for="textfield">Type</label>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="type" id="textfield">
  </p>
  <p>
    <label for="textarea">Comment</label>
    <textarea name="comment" id="textarea" cols="45" rows="5"></textarea><br>
    <br>

       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <?php
if (isset($_GET[spid])) {
    echo "<input type='submit' name='btnupdate' value='UPDATE'>";
} else {
    echo "<input type='submit' name='button' value='ADD'>";
}
?>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="reset" name="button2" id="button2" value="RESET">
  </p>
</form>


</table>
<p>&nbsp; </p>
<?php
$result = mysql_query("SELECT * FROM specislist");

echo " <table width='544' border='1'>
  <tr>
    <th width='58' scope='col'>SL NO</th>
    <th width='164' scope='col'>Type</th>
    <th width='182' scope='col'>Comment</th>
    <th width='49' scope='col'>Edit</th>
    <th width='57' scope='col'>Delete</th>
  </tr>";

while ($row = mysql_fetch_array($result)) {
    echo "<tr>
    <td>&nbsp;$row[spid]</td>
    <td>&nbsp;$row[sptype]</td>
    <td>&nbsp;$row[comment]</td>
      <td>&nbsp; <a href='specialist.php?spid=$row[spid]'>Edit</a></td>
    <td>&nbsp;<a href='specialist.php?delid=$row[spid]'>delete</a></td>
  </tr>";
}
echo "</table>";

mysql_close($con);
?>
<?php
