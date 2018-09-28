<?php
 /*********************************************************************************
 *          Filename: EditorialCatRecord.php
 *          Generated with CodeCharge  v.1.1.19
 *          PHP build 02/26/2001
 *********************************************************************************/

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

session_start();

$sFileName = "EditorialCatRecord.php";



check_security(2);

$seditorial_categoriesErr = "";
$sAction = get_param("FormAction");
$sForm = get_param("FormName");

//-- handling actions
switch ($sForm)
{
  case "editorial_categories":
    editorial_categories_action($sAction);
  break;
}

?><html>
<head>
<title>Book Store</title>
<meta name="GENERATOR" content="YesSoftware CodeCharge v.1.1.19 using 'PHP.ccp'">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0"> 
<meta http-equiv="cache-control" content="no-cache">
</head>
<body style="background-color: #FFFFFF; color: #000000; font-family: Arial, Tahoma, Verdana, Helveticabackground-color: #FFFFFF; color: #000000; font-family: Arial, Tahoma, Verdana, Helvetica">
<center>
 <table>
  <tr>
   <td valign="top">
 <? Menu_Show() ?>
   
   </td>
  </tr>
 </table>
</center>
<hr>
 <table>
  <tr>
   
   <td valign="top">
<? editorial_categories_Show() ?>
    
   </td>
  </tr>
 </table>

<center>
<hr size=1 width=60%>
 <table>
  <tr>
   <td valign="top">
<? Footer_Show() ?>
    </td>
   
  </tr>
 </table>
 
<center><font face="Arial"><small>This dynamic site was generated with <a href="http://www.codecharge.com">CodeCharge</a></small></font></center>
</body>
</html>
<? 



//********************************************************************************



function editorial_categories_action($sAction)
{
  global $db;
  global $sForm;
  global $seditorial_categoriesErr;
  
  $sParams = "";
  $sActionFileName = "EditorialCatGrid.php";

  

  $sWhere = "";
  $bErr = false;

  if($sAction == "cancel")
    header("Location: " . $sActionFileName); 

  
  if($sAction == "update" || $sAction == "delete") 
  {
    $pPKeditorial_cat_id = get_param("PK_editorial_cat_id");
    
    $sWhere .= "editorial_cat_id=" . tosql($pPKeditorial_cat_id, "Number");
    
  }
  
  $fldeditorial_cat_name = get_param("editorial_cat_name");
  if($sAction == "insert" || $sAction == "update") 
  {

    if(strlen($seditorial_categoriesErr)) return;
  }
  

  //-- Create SQL statement
  $sSQL = "";
  
  switch(strtolower($sAction)) 
  {
    case "insert":
      
        $sSQL = "insert into editorial_categories (" . 
          "editorial_cat_name)" . 
          " values (" . 
          tosql($fldeditorial_cat_name, "Text") . ")";
    break;
    case "update":
      
        $sSQL = "update editorial_categories set " .
          "editorial_cat_name=" . tosql($fldeditorial_cat_name, "Text");
        $sSQL .= " where " . $sWhere;
    break;
  
    case "delete":
      
        $sSQL = "delete from editorial_categories where " . $sWhere;
    break;
  
  }

  if(strlen($seditorial_categoriesErr)) return;
  //-- Execute SQL query
  $db->query($sSQL);
  
  header("Location: " . $sActionFileName);
  
}



function editorial_categories_Show()
{
  global $sFileName;
  global $sAction;
  global $db;
  global $sForm;
  global $seditorial_categoriesErr;

  global $styles;

  $sWhere = "";
  
  $bPK = true;  //-- primary key indication

  //-- begin block of initialization variables
  $fldeditorial_cat_id = "";
  $fldeditorial_cat_name = "";
  //-- end block

?>
   
   <table style="">
   <form method="POST" action="<?= $sFileName ?>" name="editorial_categories">
   <tr><td style="background-color: #336699; text-align: Center; border-style: outset; border-width: 1" colspan="2"><font style="font-size: 12pt; color: #FFFFFF; font-weight: bold">Editorial Categories</font></td></tr>
   <? if ($seditorial_categoriesErr) { ?> <tr><td style="background-color: #FFFFFF; border-width: 1" colspan="2"><font style="font-size: 10pt; color: #000000"><?= $seditorial_categoriesErr ?></font></td></tr><? } ?>
<? 

  if($seditorial_categoriesErr == "")
  {
    //-- Get primary key and form parameters
    $fldeditorial_cat_id = get_param("editorial_cat_id");
    $peditorial_cat_id = get_param("editorial_cat_id");
  }
  else
  {
    //-- Get primary key, form parameters and form's fields
    $fldeditorial_cat_id = strip(get_param("editorial_cat_id"));
    $fldeditorial_cat_name = strip(get_param("editorial_cat_name"));
    $peditorial_cat_id = get_param("PK_editorial_cat_id");
  }

  
  if( !strlen($peditorial_cat_id)) $bPK = false;
  
  $sWhere .= "editorial_cat_id=" . tosql($peditorial_cat_id, "Number");
  $PK_editorial_cat_id = $peditorial_cat_id;

  $sSQL = "select * from editorial_categories where " . $sWhere;
  if($bPK && !($sAction == "insert" && $sForm == "editorial_categories"))
  {
    $db->query($sSQL);
    $db->next_record();
    
    $fldeditorial_cat_id = $db->f("editorial_cat_id");
    if($seditorial_categoriesErr == "") 
    {
      //-- Load data from database when form is displayed for the first time
    
      $fldeditorial_cat_name = $db->f("editorial_cat_name");
    }
  }

  else
  {
    if($seditorial_categoriesErr == "")
    {
      $fldeditorial_cat_id = tohtml(get_param("editorial_cat_id"));
    }
  }
    //-- show fields
    ?>
  <tr>
       <td style="background-color: #FFEAC5; border-style: inset; border-width: 0">
         <font style="font-size: 10pt; color: #000000">Name</font>
       </td>
       <td style="background-color: #FFFFFF; border-width: 1">
         <font style="font-size: 10pt; color: #000000">
         <input type="text" name="editorial_cat_name" maxlength="50" value="<?= tohtml($fldeditorial_cat_name) ?>" size="50" ></font>
       </td>
     </tr>

    <tr align="right"><td colspan="2" align="right">
    

<? if (!($bPK && !($sAction=="insert" && $sForm=="editorial_categories"))) { ?>

<? if (!$bPK) { ?>
   <input type="submit" value="Insert" onclick="document.editorial_categories.FormAction.value = 'insert';">
   <input type="hidden" value="insert" name="FormAction"/>
<? } ?>

<? } else { ?>
  <input type="hidden" value="update" name="FormAction"/>
 
 <? if ($bPK) { ?>
   <input type="submit" value="Update" onclick="document.editorial_categories.FormAction.value = 'update';">
   
 <? } ?>
 
 <? if ($bPK) { ?>
   <input type="submit" value="Delete" onclick="document.editorial_categories.FormAction.value = 'delete';">
   <? } ?>
 
<? } ?>

 <input type="submit" value="Cancel" onclick="document.editorial_categories.FormAction.value = 'cancel';">
   <input type="hidden" name="FormName" value="editorial_categories">
  
  <input type="hidden" name="PK_editorial_cat_id" value="<?= $peditorial_cat_id ?>">  
  <input type="hidden" name="editorial_cat_id" value="<?= tohtml($fldeditorial_cat_id) ?>">

  </td></tr>
  </form>
  </table>
<?
  
}



?>