<?php
/**
 * @package admin
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: product.php 6131 2007-04-08 06:56:51Z drbyte $
 */
if(isset($_GET['cPath']) && ($_GET['cPath'] == "0" || $_GET['cPath'] == "")) {
	header("location: product_acquisition_list.php?cID=".$_GET['cID']."");
}

  require('includes/application_top.php');
  require('acquisition/product_price_update.php'); //update save

  require(DIR_WS_MODULES . 'prod_cat_header_code.php');
  $cID = (int)$_GET['cID'];
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  $search = trim($_GET['search']);
  $sort = $_GET['sort'];

  if (is_dir(DIR_FS_CATALOG_IMAGES)) {
    if (!is_writeable(DIR_FS_CATALOG_IMAGES)) $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
<script language="javascript" src="includes/menu.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript" src="includes/javascript/common.js"></script>
<script language="javascript" src="includes/javascript/multifile.js"></script>

<script type="text/javascript">
String.prototype.toProperCase = function()
{
  return this.toLowerCase().replace(/^(.)|\s(.)/g, 
      function($1) { return $1.toUpperCase(); });
}
</script>
<script type="text/javascript">
  <!--
  function init()
  {
    cssjsmenu('navbar');
    if (document.getElementById)
    {
      var kill = document.getElementById('hoverJS');
      kill.disabled = true;
    }
if (typeof _editor_url == "string") HTMLArea.replaceAll();
 }
 // -->
</script>
<style type="text/css">
<!--
.input_bg_red {
	background-color: #FF3333;
}
-->
</style>
</head>
<body onLoad="init()">
<div id="spiffycalendar" class="text"></div>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->
<?php
error_reporting(7);

if($cID == ""){
echo "'cID' Can not be empty <input type=\"button\" name=\"Submit2\" value=\"hitstory\" onClick=\"javascript:history.go(-1);\" />";
exit;
}

$sql = "select * from website where web_cid=".$cID;
$rs = mysql_query($sql);
if(MYSQL_NUMROWS($rs) == 0){
	echo "'cID' Can not be empty <a href=product_acquisition_add.php?cID=".$cID.">Enter</a>";
	exit;
}

$web_name = mysql_result($rs,0,"web_name");
$coding = mysql_result($rs,0,"web_coding");
$fun_name = mysql_result($rs,0,"web_fun_name");
$fun = mysql_result($rs,0,"web_fun_content");
$content = mysql_result($rs,0,"web_fun_remarks");
$replacement = mysql_result($rs,0,"web_replace");
$discount1 = mysql_result($rs,0,"web_fun_a");
$discount2 = mysql_result($rs,0,"web_fun_b");
$testurl = mysql_result($rs,0,"web_test_url");
//$testurl = str_replace("&","||||||",str_replace("?","______",$testurl));
$arr_fun_name = split(", ",$fun_name);
$arr_fun = split(", ",$fun);
$arr_content = split(", ",$content);

?>

<script language="javascript" src="acquisition/ajax.js"></script>
<script language="javascript" src="acquisition/function.js"></script>


<script language="javascript">
function addRow2(info){
$0=document.getElementsByName('tilte[]');
$1=document.getElementsByName('price[]');
$2=document.getElementsByName('title_keyword[]');
$p_name=document.getElementsByName('products_name[]');
$p_price=document.getElementsByName('products_price[]');

for(i=0; i<$p_name.length; i++){
	//if($p_name[i].value.indexOf(info[2]) > -1){
	if(str_digital($p_name[i].value) == info[2]){
		$0[i].value = info[0];
		$1[i].value = info[1].replace("$","");
		$2[i].value = info[2];
		$price = 100 - ($p_price[i].value / ($1[i].value.replace("$","")) * 100);
		if($price > 10 || $price< -10){
			$p_price[i].className='input_bg_red';
		}
	}
}
}

function del(){
var tmp = 0;
for (i=0; i<document.all.length; i++) if (document.all[i].name == "fun[]") tmp++

var obj=document.getElementById("testTbl");
if(tmp > 1) obj.deleteRow(tmp); 
}

function Test(){
var testurl="<?php echo $testurl;?>";
var url;
var arr,arr_div;
var info=new Array();

url="acquisition/ajax.php?url="+testurl;
var content=sendUrl(url+"&c=<?php echo $coding;?>"+getRnd());
	//content=get_replacement(content,"?php echo $replacement;?>");
	<?php echo $discount1."\n";?>
	<?php echo $discount2."\n";?>
for(var i=1;i<arr.length;i++){
 <?php for($i=0; $i<count($arr_fun_name); $i++){
		echo "info[".$i."]=".$arr_fun[$i].";\n";
		}
		?>
		if(info[1].substring(0,1) == "$"){
			addRow2(info);
		}	
  }
  document.getElementById('success').innerHTML = "<b>---O K---</b>";
}
</script> 
<form action="?action=update" method="post" name="form_url">
<input name="cID" type="hidden" value="<?php echo $cID;?>">
  <table width="98%" height="30" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="55%">
	    <input type="button" name="Submit2" value="hitstory" onClick="javascript:history.go(-1);" />
        <input name="Submit3" type="button" value="Into the set" onClick="javascript:location.href='product_acquisition.php';">
        <input type="button" name="Submit" value="test_function" id="" onClick="Test();">
      <a href="<?php echo $testurl;?>" target="_blank"><?php echo $testurl;?></a></td>
      <td width="45%"><div id="success" style="color:#FF0000;"></div></td>
    </tr>
  </table>
  <table width="98%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC" id="content">
    <tr>
      <td width="6%" bgcolor="#EFEFEF">No.</td>
      <td width="22%" bgcolor="#EFEFEF">Old-title</td>
      <td width="23%" bgcolor="#EFEFEF">Title</td>
      <td width="15%" bgcolor="#EFEFEF">Old-Price<A href="?sort_by=p.products_price ASC&cID=<?php echo $cID;?>"> <IMG title=" Sort Price (inc) - Ascendingly " height="12" alt="Sort Price (inc) - Ascendingly" src="images/icon_up.gif" width="11" border="0"></A><A href="?sort_by=p.products_price DESC&cID=<?php echo $cID;?>"> <IMG title=" Sort Price (inc) - Descendingly " height="12" alt="Sort Price (inc) - Descendingly" src="images/icon_down.gif" width="11" border="0"></A></td>
      <td width="16%" bgcolor="#EFEFEF">Price</td>
      <td width="18%" bgcolor="#EFEFEF">Title-Which</td>
    </tr>
	<?php 
	$sql = "select products_price,products_name,p.products_id from products p,products_description pd where p.products_id=pd.products_id and master_categories_id=".$cID." and language_id=1";
	if($_GET['sort_by']<>""){
	$sql .= " order by ".$_GET['sort_by'];
	}
	$crs = $db->Execute($sql);
	for($i=0; $i<$crs->RecordCount();$i++){
	?>
	<tr bgcolor="#FFFFFF" onMouseOver="this.bgColor='#EFEFEF'" onMouseOut="this.bgColor='#ffffff'">
      <td width="6%"><input name="products_id[]" type="text" id="products_id[]" value="<?php echo $crs->fields['products_id'];?>" size="10" ></td>
      <td width="22%"><input name="products_name[]" type="text" id="products_name[]" value="<?php echo $crs->fields['products_name'];?>" size="40"></td>
      <td width="23%"><input name="tilte[]" type="text" id="tilte[]" size="40"></td>
      <td width="15%" bgcolor="#B9CFFF"><input name="products_price[]" type="text" id="products_price[]" value="<?php echo $crs->fields['products_price'];?>"></td>
      <td width="16%"><input name="price[]" type="text" id="price[]"></td>
      <td width="18%"><input name="title_keyword[]" type="text" id="title_keyword[]"></td>
    </tr>
	<?php 
	$crs->movenext();
	}?>
  </table>
  <table width="800" border="0" align="center">
    <tr> 
      <td colspan="4" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit42" value="update Database" /> </td>
    </tr>
  </table>
</form>
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>