<?php
 /*********************************************************************************
 *          Filename: EditorialsGrid.php
 *          Generated with CodeCharge  v.1.1.19
 *          PHP build 02/26/2001
 *********************************************************************************/

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

session_start();

$sFileName = "EditorialsGrid.php";



check_security(2);


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


function editorials_Show()
{ 
  global $sFileName;  //-- name of the current page
  
  global $db;   //-- database connection
  global $seditorialsErr; //-- error string

  //-- SQL for order field
  $sOrder = " order by e.article_title Asc";

  $HasParam = false;

  $iSort = get_param("Formeditorials_Sorting");
  $iSorted = get_param("Formeditorials_Sorted");

  //-- process sort commands
  $sDirection = "";
  $sSortParams = "";
  if($iSort)
  {
    if($iSort == $iSorted)
    {
      $form_sorting = "";
      $sDirection = " DESC";
      $sSortParams = "Formeditorials_Sorting=" . $iSort . "&Formeditorials_Sorted=" . $iSort . "&";
    }
    else
    {
      $form_sorting = $iSort;
      $sDirection = " ASC";
      $sSortParams = "Formeditorials_Sorting=" . $iSort . "&Formeditorials_Sorted=" . "&";
    }
    
    if ($iSort == 1) $sOrder = " order by e.article_title" . $sDirection;
    if ($iSort == 2) $sOrder = " order by e1.editorial_cat_name" . $sDirection;
    if ($iSort == 3) $sOrder = " order by i.name" . $sDirection;
    if (!strlen($sOrder))  $sDirection = "";
  }
  

//-- table header
?>
     <table style="">
      <tr>
       <td style="background-color: #336699; text-align: Center; border-style: outset; border-width: 1" colspan="3"><a name="editorials"><font style="font-size: 12pt; color: #FFFFFF; font-weight: bold">Editorials</font></a></td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><a href="<?=$sFileName?>?<?=$transit_params?>Formeditorials_Sorting=1&Formeditorials_Sorted=<?=$form_sorting?>&"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold">Title</font></a></td>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><a href="<?=$sFileName?>?<?=$transit_params?>Formeditorials_Sorting=2&Formeditorials_Sorted=<?=$form_sorting?>&"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold">Editorial Category</font></a></td>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><a href="<?=$sFileName?>?<?=$transit_params?>Formeditorials_Sorting=3&Formeditorials_Sorted=<?=$form_sorting?>&"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold">Item</font></a></td>
      </tr>
<?

  $sWhere = "";
  
  //-- populate arrays for list of values
  //-- complete SQL
  $sSQL = "select e.article_id as e_article_id, " . 
    "e.article_title as e_article_title, " . 
    "e.editorial_cat_id as e_editorial_cat_id, " . 
    "e.item_id as e_item_id, " . 
    "e1.editorial_cat_id as e1_editorial_cat_id, " . 
    "e1.editorial_cat_name as e1_editorial_cat_name, " . 
    "i.item_id as i_item_id, " . 
    "i.name as i_name " . 
    " from editorials e, editorial_categories e1, items i" . 
    " where e1.editorial_cat_id=e.editorial_cat_id and i.item_id=e.item_id  ";
  
  $sSQL = $sSQL . $sWhere . $sOrder;

  //-- insert button
  $form_action = "EditorialsRecord.php";
  //-- variables of the page scroller
  $iPage = get_param("Formeditorials_Page");
  if(!strlen($iPage)) $iPage = 1;
  $RecordsPerPage = 20;

  //-- do SQL query
  $db->query($sSQL);
  
  //-- move through the recordset - as scroller requires
  $position_to_seek = ($iPage - 1)*$RecordsPerPage;
  if ($position_to_seek) $db->seek($position_to_seek);
  $iCounter = 0;
  $is_next_record=false;

  //-- show records
  if($db->next_record())
  {
    //-- default values
    

    //-- display rows
    do
    {
      //-- retrieve data from the record
      $fldarticle_id = $db->f("e_article_id");
      $fldarticle_title = $db->f("e_article_title");
      $fldeditorial_cat_id = $db->f("e1_editorial_cat_name");
      $flditem_id = $db->f("i_name");
    $iCounter++;
      //-- display current record
    ?>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><a href="EditorialsRecord.php?article_id=<?= tourl($db->f("e_article_id"))?>&<?=$transit_params?>"><font style="font-size: 10pt; color: #000000"><?= tohtml($fldarticle_title) ?></font></a>&nbsp;</font></td>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><?=tohtml($fldeditorial_cat_id)?>&nbsp;</font></td>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><?=tohtml($flditem_id)?>&nbsp;</font></td>
      </tr>
    <?
    $is_next_record = @$db->next_record();
    } while($is_next_record  && $iCounter < $RecordsPerPage);
  }
  else //-- there are no records
  {
  //$db->num_rows() == 0 || ($iPage - 1)*$RecordsPerPage >= $db->num_rows())
    ?>
      <tr><td colspan="3" style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000">No records</font></td></tr>
<tr><td colspan="3" style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold">
      <a href="<?= $form_action ?>?<?= $transit_params ?>"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold">Insert</font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

      </table>
    <?
    return;
  }

 
 //-- last row of the table is for scroller and "insert" link
  ?>
    
      <tr><td colspan="3" style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold">
      <a href="<?= $form_action ?>?<?= $transit_params ?>"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold">Insert</font></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <?
  //-- scroller
  

  if($is_next_record || $iPage != 1)
  {
    //-- previous page 
    if($iPage == 1)
      $scroller_prev = "<a href_=\"".$sFileName."?".$transit_params.$sSortParams."Formeditorials_Page=".$prev_page."#editorials\">";
    else
    {
      $prev_page = $iPage - 1;
      $scroller_prev = "<a href=\"".$sFileName."?".$transit_params.$sSortParams."Formeditorials_Page=".$prev_page."#editorials\">";
    }
    echo  $scroller_prev."<font "."style=\"font-size: 10pt; color: #CE7E00; font-weight: bold\"".">Previous</font>";
    if ($scroller_prev) echo "</a>";

    //-- current page
    echo " [ $iPage ] ";

    //-- next page
    //if($iPage*$RecordsPerPage >= $db->num_rows())
    if (!$is_next_record)
      $scroller_next = "<a href_=\"".$sFileName."?".$transit_params.$sSortParams."Formeditorials_Page=".$next_page."#editorials\">";
    else
    {
      $next_page = $iPage + 1;
      $scroller_next = "<a href=\"".$sFileName."?".$transit_params.$sSortParams."Formeditorials_Page=".$next_page."#editorials\">";
    }
    echo $scroller_next."<font "."style=\"font-size: 10pt; color: #CE7E00; font-weight: bold\"".">Next</font>";
    if ($scroller_next) echo "</a>";
  }

  //-- the end of the last row and the end of the table
  ?>
      </font></td></tr>
    </table>
  <?

 
}

?>