 <header>
            <?php
                include_once("menu.php");   
                include_once("nav.php");        
            ?>
        </header>
<?php
include_once("conn.conf.php");
include_once("functions.php");
$stmtgetdata = $dbh->prepare("select type_id,type_name from relation_types where type_id=:id");
$stmtgetdata->bindParam(':id',$type_id);
$type_id = $_GET['id'];
if($stmtgetdata->execute())
{
    $rowdata = $stmtgetdata->fetch();
}
if(isset($_POST['submit']))
{
    if($_POST['title'] == "")
    {
        error("Please fill in the name of the type you require to edit","editrelationtype.php");
    }

   $stmtgetdata = $dbh->prepare("select type_name from relation_types where type_name=:title and delete_flag=0");
$stmtgetdata->bindParam(':title',$type_name);
$type_name = $_POST['title'];
if($stmtgetdata->execute())
{
    $rowdata = $stmtgetdata->fetch();
}
if($rowdata['type_name'] == $_POST['title'])
   {
    error("This type relation already exist","relation_types.php");
}
    $stmtinsert = $dbh->prepare("Update relation_types set type_name = :title  where type_id = :id");
    $stmtinsert->bindParam(':title',$title);
    $stmtinsert->bindParam(':id',$id);
    $id = $_POST['type_id'];
    $title = $_POST['title'];
    $stmtinsert->execute();
    header('Location: relation_types.php');
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
include("header.php");
?>
<body>

<div id="overlay">
    <div id="progstat"></div>
    <div id="progress"></div>
</div>
<div class="trigger">
    <div>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>

<div class="sitewrapper" id="header">
    <section class="mainwrapper">
        <section class="row mainsection">     
            <h3>Relation type Management Portal</h3>       
            <form action="" method = "POST" class="w-100 pad-15">
                    <div class="w-25 pad-lr-10">
                        <input type="hidden" name="type_id" placeholder="type ID" value=<?php echo $rowdata['type_id']; ?> />
                        <input type="text" name="title" placeholder="type name" value=<?php echo $rowdata['type_name']; ?> />
                    </div>
                    
                    
                    <div class="w-10 pad-lr-10"><input type="submit" name="submit" value="Update" /></div>
                    <div class="w-10 pad-lr-10"><input type="submit" name="back" value="Cancel" /></div>
                    <?php
if(isset($_POST['back']))
{
    header('Location: relation_types.php');
}
?>
                </form>
                <br>
        </section>
   <?php
        include_once("editfooter.php");//hi
   ?>
</div>
</body>
</html>
