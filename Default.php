<?php
 /*********************************************************************************
 *          Filename: Default.php
 *          Generated with CodeCharge  v.1.1.19
 *          PHP build 02/26/2001
 *********************************************************************************/

include ("./common.php");
include ("./Header.php");
include ("./Footer.php");

session_start();

$sFileName = "Default.php";





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
<? Search_Show() ?>
    
<? AdvMenu_Show() ?>
    
<? Categories_Show() ?>
    
<? Specials_Show() ?>
    </td>
   <td valign="top"><table width="250"><tr><td></td></tr></table>
<? Recommended_Show() ?>
    </td>
   <td valign="top">
<? What_Show() ?>
    
<? New_Show() ?>
    
<? Weekly_Show() ?>
    
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



function Search_Show()
{
  global $styles;
  
  $action_page = "Books.php";

  


    $fldcategory_id = strip(get_param("category_id"));
    $fldname = strip(get_param("name"));
  ?>
    <form method="GET" action="<?= $action_page ?>">
    <table style="">
     <tr>
      <td style="background-color: #336699; text-align: Center; border-style: outset; border-width: 1" colspan="5"><a name="Search"><font style="font-size: 12pt; color: #FFFFFF; font-weight: bold">Search</font></a></td>
     </tr>
     <tr>
      <td style="background-color: #FFEAC5; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #000000">Category</font></td>
      <td style="background-color: #FFFFFF; border-width: 1"><select name="category_id"><?= get_options("select category_id, name from categories order by 2",true,false,$fldcategory_id);?></select></td>
     </tr>
     <tr>
      <td style="background-color: #FFEAC5; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #000000">Title</font></td>
      <td style="background-color: #FFFFFF; border-width: 1">
         <input type="text" name="name" maxlength="10" value="<?= tohtml($fldname) ?>" size="10" ></td>
     </tr>
     <tr>
     <td align="right" colspan="3"><input type="submit" value="Search">
     </td>     
    </tr>
     
   </table>
   </form>
<?
  
}

function AdvMenu_Show()
{
global $styles;




?>
  <table style="">
  <tr>
    <td colspan="1" style="background-color: #336699; text-align: Center; border-style: outset; border-width: 1"><font style="font-size: 12pt; color: #FFFFFF; font-weight: bold">More Search Options</font></td></tr>
  <tr>
  
    <td style="background-color: #FFFFFF; border-width: 1"><a href="AdvSearch.php"><font style="font-size: 10pt; color: #000000">Advanced search</font></a></td>
  </tr>
  </table>
<?

}


function Recommended_Show()
{ 
  global $sFileName;  //-- name of the current page
  
  global $db;   //-- database connection
  global $sRecommendedErr; //-- error string

  

  $HasParam = false;

  $iSort = get_param("FormRecommended_Sorting");
  $iSorted = get_param("FormRecommended_Sorted");

  //-- process sort commands
  $sDirection = "";
  $sSortParams = "";
  if($iSort)
  {
    if($iSort == $iSorted)
    {
      $form_sorting = "";
      $sDirection = " DESC";
      $sSortParams = "FormRecommended_Sorting=" . $iSort . "&FormRecommended_Sorted=" . $iSort . "&";
    }
    else
    {
      $form_sorting = $iSort;
      $sDirection = " ASC";
      $sSortParams = "FormRecommended_Sorting=" . $iSort . "&FormRecommended_Sorted=" . "&";
    }
    
    if ($iSort == 1) $sOrder = " order by i.name" . $sDirection;
    if ($iSort == 2) $sOrder = " order by i.author" . $sDirection;
    if ($iSort == 3) $sOrder = " order by i.image_url" . $sDirection;
    if ($iSort == 4) $sOrder = " order by i.price" . $sDirection;
    if (!strlen($sOrder))  $sDirection = "";
  }
  

//-- table header
?>
     <table style="">
      <tr>
       <td style="background-color: #336699; text-align: Center; border-style: outset; border-width: 1" colspan="1"><a name="Recommended"><font style="font-size: 12pt; color: #FFFFFF; font-weight: bold">Recommended Titles</font></a></td>
      </tr>
<?

  $sWhere = "";
  
  $sWhere = " WHERE is_recommended=1";
  //-- populate arrays for list of values
  //-- complete SQL
  $sSQL = "select i.author as i_author, " . 
    "i.image_url as i_image_url, " . 
    "i.item_id as i_item_id, " . 
    "i.name as i_name, " . 
    "i.price as i_price " . 
    " from items i ";
  
  $sSQL = $sSQL . $sWhere . $sOrder;

  //-- insert button
  
  //-- variables of the page scroller
  $iPage = get_param("FormRecommended_Page");
  if(!strlen($iPage)) $iPage = 1;
  $RecordsPerPage = 5;

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
    
$fldimage_url="<img border=0 src=" . $fldimage_url . ">";

    //-- display rows
    do
    {
      //-- retrieve data from the record
      $fldname = $db->f("i_name");
      $fldauthor = $db->f("i_author");
      $fldimage_url = $db->f("i_image_url");
      $fldprice = $db->f("i_price");
$fldimage_url="<img border=0 src=" . $fldimage_url . ">";
    $iCounter++;
      //-- display current record
    ?>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></font> </td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><a href="BookDetail.php?item_id=<?= tourl($db->f("i_item_id"))?>&<?=$transit_params?>"><font style="font-size: 10pt; color: #000000"><?= tohtml($fldname) ?></font></a>&nbsp;</font></td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></font> </td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><?=tohtml($fldauthor)?>&nbsp;</font></td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></font> </td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><a href="BookDetail.php?item_id=<?= tourl($db->f("i_item_id"))?>&<?=$transit_params?>"><font style="font-size: 10pt; color: #000000"><?= $fldimage_url ?></font></a>&nbsp;</font></td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold">Price</font> </td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><?=tohtml($fldprice)?>&nbsp;</font></td>
      </tr>
      <tr>
       <td colspan="2" style="background-color: #FFFFFF; border-width: 1">&nbsp;</td>
      </tr>
    <?
    $is_next_record = @$db->next_record();
    } while($is_next_record  && $iCounter < $RecordsPerPage);
  }
  else //-- there are no records
  {
  //$db->num_rows() == 0 || ($iPage - 1)*$RecordsPerPage >= $db->num_rows())
    ?>
      <tr><td colspan="4" style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000">No records</font></td></tr>


      </table>
    <?
    return;
  }

 
 //-- last row of the table is for scroller and "insert" link
  ?>
    
    <? if ($iPage*$RecordsPerPage < $db->num_rows() || $iPage != 1) { ?>
      <tr><td colspan="4" style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold">
    <? } ?>
    
  <?
  //-- scroller
  

  if($is_next_record || $iPage != 1)
  {
    //-- previous page 
    if($iPage == 1)
      $scroller_prev = "<a href_=\"".$sFileName."?".$transit_params.$sSortParams."FormRecommended_Page=".$prev_page."#Recommended\">";
    else
    {
      $prev_page = $iPage - 1;
      $scroller_prev = "<a href=\"".$sFileName."?".$transit_params.$sSortParams."FormRecommended_Page=".$prev_page."#Recommended\">";
    }
    echo  $scroller_prev."<font "."style=\"font-size: 10pt; color: #CE7E00; font-weight: bold\"".">Previous</font>";
    if ($scroller_prev) echo "</a>";

    //-- current page
    echo " [ $iPage ] ";

    //-- next page
    //if($iPage*$RecordsPerPage >= $db->num_rows())
    if (!$is_next_record)
      $scroller_next = "<a href_=\"".$sFileName."?".$transit_params.$sSortParams."FormRecommended_Page=".$next_page."#Recommended\">";
    else
    {
      $next_page = $iPage + 1;
      $scroller_next = "<a href=\"".$sFileName."?".$transit_params.$sSortParams."FormRecommended_Page=".$next_page."#Recommended\">";
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


function What_Show()
{ 
  global $sFileName;  //-- name of the current page
  
  global $db;   //-- database connection
  global $sWhatErr; //-- error string

  

//-- table header
?>
     <table style="">
      <tr>
       <td style="background-color: #336699; text-align: Center; border-style: outset; border-width: 1" colspan="1"><a name="What"><font style="font-size: 12pt; color: #FFFFFF; font-weight: bold">What We're Reading</font></a></td>
      </tr>
<?

  $sWhere = "";
  
  $sWhere = " AND editorial_cat_id=1";
  //-- populate arrays for list of values
  //-- complete SQL
  $sSQL = "select e.article_desc as e_article_desc, " . 
    "e.article_title as e_article_title, " . 
    "e.item_id as e_item_id, " . 
    "i.item_id as i_item_id, " . 
    "i.image_url as i_image_url " . 
    " from editorials e, items i" . 
    " where i.item_id=e.item_id  ";
  
  $sSQL = $sSQL . $sWhere . $sOrder;

  //-- insert button
  

  //-- do SQL query
  $db->query($sSQL);
  
  $is_next_record=false;

  //-- show records
  if($db->next_record())
  {
    //-- default values
    
$flditem_id="<img border=0 src=" . $flditem_id . ">";

    //-- display rows
    do
    {
      //-- retrieve data from the record
      $fldarticle_title = $db->f("e_article_title");
      $fldarticle_desc = $db->f("e_article_desc");
      $flditem_id = $db->f("i_image_url");
$flditem_id="<img border=0 src=" . $flditem_id . ">";

      //-- display current record
    ?>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></font> </td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><a href="BookDetail.php?item_id=<?= tourl($db->f("e_item_id"))?>&<?=$transit_params?>"><font style="font-size: 10pt; color: #000000"><?= tohtml($fldarticle_title) ?></font></a>&nbsp;</font></td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></font> </td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><?=$fldarticle_desc?>&nbsp;</font></td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></font> </td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><a href="BookDetail.php?item_id=<?= tourl($db->f("e_item_id"))?>&<?=$transit_params?>"><font style="font-size: 10pt; color: #000000"><?= $flditem_id ?></font></a>&nbsp;</font></td>
      </tr>
      <tr>
       <td colspan="2" style="background-color: #FFFFFF; border-width: 1">&nbsp;</td>
      </tr>
    <?
    $is_next_record = @$db->next_record();
    } while($is_next_record );
  }
  else //-- there are no records
  {
  //$db->num_rows() == 0 || ($iPage - 1)*$RecordsPerPage >= $db->num_rows())
    ?>
      <tr><td colspan="3" style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000">No records</font></td></tr>


      </table>
    <?
    return;
  }

 

  //-- the end of the last row and the end of the table
  ?>
    </table>
  <?

 
}


function Categories_Show()
{ 
  global $sFileName;  //-- name of the current page
  
  global $db;   //-- database connection
  global $sCategoriesErr; //-- error string

  

//-- table header
?>
     <table style="">
      <tr>
       <td style="background-color: #336699; text-align: Center; border-style: outset; border-width: 1" colspan="1"><a name="Categories"><font style="font-size: 12pt; color: #FFFFFF; font-weight: bold">Categories</font></a></td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></td>
      </tr>
<?

  $sWhere = "";
  
  //-- populate arrays for list of values
  //-- complete SQL
  $sSQL = "select c.category_id as c_category_id, " . 
    "c.name as c_name " . 
    " from categories c ";
  
  $sSQL = $sSQL . $sWhere . $sOrder;

  //-- insert button
  

  //-- do SQL query
  $db->query($sSQL);
  
  $is_next_record=false;

  //-- show records
  if($db->next_record())
  {
    //-- default values
    

    //-- display rows
    do
    {
      //-- retrieve data from the record
      $fldname = $db->f("c_name");

      //-- display current record
    ?>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><a href="Books.php?category_id=<?= tourl($db->f("c_category_id"))?>&<?=$transit_params?>"><font style="font-size: 10pt; color: #000000"><?= tohtml($fldname) ?></font></a>&nbsp;</font></td>
      </tr>
    <?
    $is_next_record = @$db->next_record();
    } while($is_next_record );
  }
  else //-- there are no records
  {
  //$db->num_rows() == 0 || ($iPage - 1)*$RecordsPerPage >= $db->num_rows())
    ?>
      <tr><td colspan="1" style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000">No records</font></td></tr>


      </table>
    <?
    return;
  }

 

  //-- the end of the last row and the end of the table
  ?>
    </table>
  <?

 
}


function New_Show()
{ 
  global $sFileName;  //-- name of the current page
  
  global $db;   //-- database connection
  global $sNewErr; //-- error string

  

//-- table header
?>
     <table style="">
      <tr>
       <td style="background-color: #336699; text-align: Center; border-style: outset; border-width: 1" colspan="3"><a name="New"><font style="font-size: 12pt; color: #FFFFFF; font-weight: bold">New & Notable</font></a></td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></td>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></td>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></td>
      </tr>
<?

  $sWhere = "";
  
  $sWhere = " AND editorial_cat_id=2";
  //-- populate arrays for list of values
  //-- complete SQL
  $sSQL = "select e.article_desc as e_article_desc, " . 
    "e.article_title as e_article_title, " . 
    "e.item_id as e_item_id, " . 
    "i.item_id as i_item_id, " . 
    "i.image_url as i_image_url " . 
    " from editorials e, items i" . 
    " where i.item_id=e.item_id  ";
  
  $sSQL = $sSQL . $sWhere . $sOrder;

  //-- insert button
  

  //-- do SQL query
  $db->query($sSQL);
  
  $is_next_record=false;

  //-- show records
  if($db->next_record())
  {
    //-- default values
    
$flditem_id="<img border=0 src=" . $flditem_id . ">";

    //-- display rows
    do
    {
      //-- retrieve data from the record
      $fldarticle_title = $db->f("e_article_title");
      $flditem_id = $db->f("i_image_url");
      $fldarticle_desc = $db->f("e_article_desc");
$flditem_id="<img border=0 src=" . $flditem_id . ">";

      //-- display current record
    ?>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><a href="BookDetail.php?item_id=<?= tourl($db->f("e_item_id"))?>&<?=$transit_params?>"><font style="font-size: 10pt; color: #000000"><?= tohtml($fldarticle_title) ?></font></a>&nbsp;</font></td>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><a href="BookDetail.php?item_id=<?= tourl($db->f("e_item_id"))?>&<?=$transit_params?>"><font style="font-size: 10pt; color: #000000"><?= $flditem_id ?></font></a>&nbsp;</font></td>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><?=tohtml($fldarticle_desc)?>&nbsp;</font></td>
      </tr>
    <?
    $is_next_record = @$db->next_record();
    } while($is_next_record );
  }
  else //-- there are no records
  {
  //$db->num_rows() == 0 || ($iPage - 1)*$RecordsPerPage >= $db->num_rows())
    ?>
      <tr><td colspan="3" style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000">No records</font></td></tr>


      </table>
    <?
    return;
  }

 

  //-- the end of the last row and the end of the table
  ?>
    </table>
  <?

 
}


function Weekly_Show()
{ 
  global $sFileName;  //-- name of the current page
  
  global $db;   //-- database connection
  global $sWeeklyErr; //-- error string

  

//-- table header
?>
     <table style="">
      <tr>
       <td style="background-color: #336699; text-align: Center; border-style: outset; border-width: 1" colspan="1"><a name="Weekly"><font style="font-size: 12pt; color: #FFFFFF; font-weight: bold">This Week's Featured Books</font></a></td>
      </tr>
<?

  $sWhere = "";
  
  $sWhere = " AND editorial_cat_id=3";
  //-- populate arrays for list of values
  //-- complete SQL
  $sSQL = "select e.article_desc as e_article_desc, " . 
    "e.article_title as e_article_title, " . 
    "e.item_id as e_item_id, " . 
    "i.item_id as i_item_id, " . 
    "i.image_url as i_image_url " . 
    " from editorials e, items i" . 
    " where i.item_id=e.item_id  ";
  
  $sSQL = $sSQL . $sWhere . $sOrder;

  //-- insert button
  

  //-- do SQL query
  $db->query($sSQL);
  
  $is_next_record=false;

  //-- show records
  if($db->next_record())
  {
    //-- default values
    
$flditem_id="<img border=0 src=" . $flditem_id . ">";

    //-- display rows
    do
    {
      //-- retrieve data from the record
      $fldarticle_title = $db->f("e_article_title");
      $flditem_id = $db->f("i_image_url");
      $fldarticle_desc = $db->f("e_article_desc");
$flditem_id="<img border=0 src=" . $flditem_id . ">";

      //-- display current record
    ?>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></font> </td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><a href="BookDetail.php?item_id=<?= tourl($db->f("e_item_id"))?>&<?=$transit_params?>"><font style="font-size: 10pt; color: #000000"><?= tohtml($fldarticle_title) ?></font></a>&nbsp;</font></td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></font> </td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><a href="BookDetail.php?item_id=<?= tourl($db->f("e_item_id"))?>&<?=$transit_params?>"><font style="font-size: 10pt; color: #000000"><?= $flditem_id ?></font></a>&nbsp;</font></td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></font> </td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><?=tohtml($fldarticle_desc)?>&nbsp;</font></td>
      </tr>
      <tr>
       <td colspan="2" style="background-color: #FFFFFF; border-width: 1">&nbsp;</td>
      </tr>
    <?
    $is_next_record = @$db->next_record();
    } while($is_next_record );
  }
  else //-- there are no records
  {
  //$db->num_rows() == 0 || ($iPage - 1)*$RecordsPerPage >= $db->num_rows())
    ?>
      <tr><td colspan="3" style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000">No records</font></td></tr>


      </table>
    <?
    return;
  }

 

  //-- the end of the last row and the end of the table
  ?>
    </table>
  <?

 
}


function Specials_Show()
{ 
  global $sFileName;  //-- name of the current page
  
  global $db;   //-- database connection
  global $sSpecialsErr; //-- error string

  

//-- table header
?>
     <table style="">
      <tr>
       <td style="background-color: #336699; text-align: Center; border-style: outset; border-width: 1" colspan="1"><a name="Specials"><font style="font-size: 12pt; color: #FFFFFF; font-weight: bold">Weekly Specials</font></a></td>
      </tr>
<?

  $sWhere = "";
  
  $sWhere = " WHERE editorial_cat_id=4";
  //-- populate arrays for list of values
  //-- complete SQL
  $sSQL = "select e.article_desc as e_article_desc, " . 
    "e.article_title as e_article_title " . 
    " from editorials e ";
  
  $sSQL = $sSQL . $sWhere . $sOrder;

  //-- insert button
  

  //-- do SQL query
  $db->query($sSQL);
  
  $is_next_record=false;

  //-- show records
  if($db->next_record())
  {
    //-- default values
    

    //-- display rows
    do
    {
      //-- retrieve data from the record
      $fldarticle_title = $db->f("e_article_title");
      $fldarticle_desc = $db->f("e_article_desc");

      //-- display current record
    ?>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></font> </td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><?=$fldarticle_title?>&nbsp;</font></td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-style: inset; border-width: 0"><font style="font-size: 10pt; color: #CE7E00; font-weight: bold"></font> </td>
      </tr>
      <tr>
       <td style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000"><?=$fldarticle_desc?>&nbsp;</font></td>
      </tr>
      <tr>
       <td colspan="2" style="background-color: #FFFFFF; border-width: 1">&nbsp;</td>
      </tr>
    <?
    $is_next_record = @$db->next_record();
    } while($is_next_record );
  }
  else //-- there are no records
  {
  //$db->num_rows() == 0 || ($iPage - 1)*$RecordsPerPage >= $db->num_rows())
    ?>
      <tr><td colspan="2" style="background-color: #FFFFFF; border-width: 1"><font style="font-size: 10pt; color: #000000">No records</font></td></tr>


      </table>
    <?
    return;
  }

 

  //-- the end of the last row and the end of the table
  ?>
    </table>
  <?

 
}

?>