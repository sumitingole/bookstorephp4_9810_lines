<?php
 /*********************************************************************************
 *          Filename: EditorialsRecord.php
 *          Generated with CodeCharge  v.1.1.19
 *          PHP build 02/26/2001
 *********************************************************************************/

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

session_start();

$sFileName = "EditorialsRecord.php";



check_security(2);

$seditorialsErr = "";
$sAction = get_param("FormAction");
$sForm = get_param("FormName");

//-- handling actions
switch ($sForm)
{
  case "editorials":
    editorials_action($sAction);
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
<? editorials_Show() ?>
    
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



function editorials_action($sAction)
{
  global $db;
  global $sForm;
  global $seditorialsErr;
  
  $sParams = "";
  $sActionFileName = "EditorialsGrid.php";

  

  $sWhere = "";
  $bErr = false;

  if($sAction == "cancel")
    header("Location: " . $sActionFileName); 

  
  if($sAction == "update" || $sAction == "delete") 
  {
    $pPKarticle_id = get_param("PK_article_id");
    
    $sWhere .= "article_id=" . tosql($pPKarticle_id, "Number");
    
  }
  
  $fldarticle_desc = get_param("article_desc");
  $fldarticle_title = get_param("article_title");
  $fldeditorial_cat_id = get_param("editorial_cat_id");
  $flditem_id = get_param("item_id");
  if($sAction == "insert" || $sAction == "update") 
  {
    if(!strlen($fldeditorial_cat_id))
      $seditorialsErr .= "The value in field Editorial Category is required.<br>";
    
    if(!is_number($fldeditorial_cat_id))
      $seditorialsErr .= "The value in field Editorial Category is incorrect.<br>";
    
    if(!is_number($flditem_id))
      $seditorialsErr .= "The value in field Item is incorrect.<br>";
    

    if(strlen($seditorialsErr)) return;
  }
  

  //-- Create SQL statement
  $sSQL = "";
  
  switch(strtolower($sAction)) 
  {
    case "insert":
      
        $sSQL = "insert into editorials (" . 
          "article_desc," . 
          "article_title," . 
          "editorial_cat_id," . 
          "item_id)" . 
          " values (" . 
          tosql($fldarticle_desc, "Text") . "," .
          tosql($fldarticle_title, "Text") . "," .
          tosql($fldeditorial_cat_id, "Number") . "," .
          tosql($flditem_id, "Number") . ")";
    break;
    case "update":
      
        $sSQL = "update editorials set " .
          "article_desc=" . tosql($fldarticle_desc, "Text") .
          ",article_title=" . tosql($fldarticle_title, "Text") .
          ",editorial_cat_id=" . tosql($fldeditorial_cat_id, "Number") .
          ",item_id=" . tosql($flditem_id, "Number");
        $sSQL .= " where " . $sWhere;
    break;
  
    case "delete":
      
        $sSQL = "delete from editorials where " . $sWhere;
    break;
  
  }

  if(strlen($seditorialsErr)) return;
  //-- Execute SQL query
  $db->query($sSQL);
  
  header("Location: " . $sActionFileName);
  
}



function editorials_Show()
{
  global $sFileName;
  global $sAction;
  global $db;
  global $sForm;
  global $seditorialsErr;

  global $styles;

  $sWhere = "";
  
  $bPK = true;  //-- primary key indication

  //-- begin block of initialization variables
  $fldarticle_id = "";
  $fldarticle_desc = "";
  $fldarticle_title = "";
  $fldeditorial_cat_id = "";
  $flditem_id = "";
  //-- end block

?>
   
   <table style="">
   <form method="POST" action="<?= $sFileName ?>" name="editorials">
   <tr><td style="background-color: #336699; text-align: Center; border-style: outset; border-width: 1" colspan="2"><font style="font-size: 12pt; color: #FFFFFF; font-weight: bold">Editorial</font></td></tr>
   <? if ($seditorialsErr) { ?> <tr><td style="background-color: #FFFFFF; border-width: 1" colspan="2"><font style="font-size: 10pt; color: #000000"><?= $seditorialsErr ?></font></td></tr><? } ?>
<? 

  if($seditorialsErr == "")
  {
    //-- Get primary key and form parameters
    $fldarticle_id = get_param("article_id");
    $particle_id = get_param("article_id");
  }
  else
  {
    //-- Get primary key, form parameters and form's fields
    $fldarticle_id = strip(get_param("article_id"));
    $fldarticle_desc = strip(get_param("article_desc"));
    $fldarticle_title = strip(get_param("article_title"));
    $fldeditorial_cat_id = strip(get_param("editorial_cat_id"));
    $flditem_id = strip(get_param("item_id"));
    $particle_id = get_param("PK_article_id");
  }

  
  if( !strlen($particle_id)) $bPK = false;
  
  $sWhere .= "article_id=" . tosql($particle_id, "Number");
  $PK_article_id = $particle_id;

  $sSQL = "select * from editorials where " . $sWhere;
  if($bPK && !($sAction == "insert" && $sForm == "editorials"))
  {
    $db->query($sSQL);
    $db->next_record();
    
    $fldarticle_id = $db->f("article_id");
    if($seditorialsErr == "") 
    {
      //-- Load data from database when form is displayed for the first time
    
      $fldarticle_desc = $db->f("article_desc");
      $fldarticle_title = $db->f("article_title");
      $fldeditorial_cat_id = $db->f("editorial_cat_id");
      $flditem_id = $db->f("item_id");
    }
  }

  else
  {
    if($seditorialsErr == "")
    {
      $fldarticle_id = tohtml(get_param("article_id"));
    }
  }
    //-- show fields
    ?>
  <tr>
       <td style="background-color: #FFEAC5; border-style: inset; border-width: 0">
         <font style="font-size: 10pt; color: #000000">Article Description</font>
       </td>
       <td style="background-color: #FFFFFF; border-width: 1">
         <font style="font-size: 10pt; color: #000000">
         <input type="text" name="article_desc" maxlength="" value="<?= tohtml($fldarticle_desc) ?>" size="" ></font>
       </td>
     </tr>
<tr>
       <td style="background-color: #FFEAC5; border-style: inset; border-width: 0">
         <font style="font-size: 10pt; color: #000000">Article Title</font>
       </td>
       <td style="background-color: #FFFFFF; border-width: 1">
         <font style="font-size: 10pt; color: #000000">
         <input type="text" name="article_title" maxlength="200" value="<?= tohtml($fldarticle_title) ?>" size="50" ></font>
       </td>
     </tr>
<tr>
       <td style="background-color: #FFEAC5; border-style: inset; border-width: 0">
         <font style="font-size: 10pt; color: #000000">Editorial Category</font>
       </td>
       <td style="background-color: #FFFFFF; border-width: 1">
         <font style="font-size: 10pt; color: #000000"><select name="editorial_cat_id"><?= get_options("select editorial_cat_id, editorial_cat_name from editorial_categories order by 2",false,true,$fldeditorial_cat_id);?></select></font>
       </td>
     </tr>
<tr>
       <td style="background-color: #FFEAC5; border-style: inset; border-width: 0">
         <font style="font-size: 10pt; color: #000000">Item</font>
       </td>
       <td style="background-color: #FFFFFF; border-width: 1">
         <font style="font-size: 10pt; color: #000000"><select name="item_id"><?= get_options("select item_id, name from items order by 2",false,false,$flditem_id);?></select></font>
       </td>
     </tr>

    <tr align="right"><td colspan="2" align="right">
    

<? if (!($bPK && !($sAction=="insert" && $sForm=="editorials"))) { ?>

<? if (!$bPK) { ?>
   <input type="submit" value="Insert" onclick="document.editorials.FormAction.value = 'insert';">
   <input type="hidden" value="insert" name="FormAction"/>
<? } ?>

<? } else { ?>
  <input type="hidden" value="update" name="FormAction"/>
 
 <? if ($bPK) { ?>
   <input type="submit" value="Update" onclick="document.editorials.FormAction.value = 'update';">
   
 <? } ?>
 
 <? if ($bPK) { ?>
   <input type="submit" value="Delete" onclick="document.editorials.FormAction.value = 'delete';">
   <? } ?>
 
<? } ?>

 <input type="submit" value="Cancel" onclick="document.editorials.FormAction.value = 'cancel';">
   <input type="hidden" name="FormName" value="editorials">
  
  <input type="hidden" name="PK_article_id" value="<?= $particle_id ?>">  
  <input type="hidden" name="article_id" value="<?= tohtml($fldarticle_id) ?>">

  </td></tr>
  </form>
  </table>
<?
  
}



?>