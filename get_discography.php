<?php

$x = $_GET['myname'];
$z = $_GET['mycategory'];
$y = urlencode($x);
$url = "http://www.allmusic.com/search/";
$url = $url.$z."/".$y;
$page = file_get_contents($url);

function myxmlfunc($str){

	$str = str_replace("&","&amp;",$str);
	$str = str_replace("'","&apos;",$str);
	$str = str_replace("\"","&quot;",$str);
	$str = str_replace("<","&lt;",$str);
	$str = str_replace(">","&gt;",$str);

	return $str;
}


/*============================================================================================
							ARTISTS
==============================================================================================*/
if($z=="artists")
{
	$myxml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
	$myxml = $myxml."<results>";

	$regexp = '/<div class=\"image\">(.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)data-tooltip=\"(.*)}}\">(.*)<\/a>(.*)[\n][\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)<\/div>/';
	$length = preg_match_all($regexp,$page,$matches,PREG_SET_ORDER);
	if($length)
	{	
		
		if($length>=5)
		{
			$length=5;
		}
		for($i=0;$i<$length;$i++)
		{
			$reg_img = '/<img src=\"(.*)\" style/';
			$imlen = preg_match_all($reg_img,$matches[$i][4],$img,PREG_SET_ORDER);
			
			if($imlen!=0)
			{
				$myxml = $myxml."<result cover='".myxmlfunc($img[0][1])."' ";
			}
			else
			{
				$myxml = $myxml."<result cover='mike.jpg' ";
			}
			
			if(preg_match_all('/[0-9a-zA-Z]/',$matches[$i][14],$d1,PREG_SET_ORDER))
			{	
				$myxml = $myxml."name='".myxmlfunc($matches[$i][14])."' ";
			}
			else
			{
				$myxml = $myxml."name='N/A' ";
			}
			if(preg_match_all('/[0-9a-zA-Z]/',$matches[$i][17],$d2,PREG_SET_ORDER))
			{	
				$myxml = $myxml."genre='".myxmlfunc($matches[$i][17])."' ";
			}
			else
			{
				$myxml = $myxml."genre='N/A' ";
			}
			if(preg_match_all('/[0-9a-zA-Z]/',$matches[$i][20],$d3,PREG_SET_ORDER))
			{	
				$myxml = $myxml."year='".myxmlfunc($matches[$i][20])."' ";
			}
			else
			{
				$myxml = $myxml."year='N/A' ";
			}
			$reg_det = '/<a href="(.*)"/';
			$detlen = preg_match_all($reg_det,$matches[$i][12],$det,PREG_SET_ORDER);
			
			
			if($detlen!=0)
			{
				$myxml = $myxml."details='".myxmlfunc($det[0][1])."'/>";
			}
			else
			{
				$myxml = $myxml."details='N/A'/>";
			}
			
		}
		
	$myxml = $myxml."</results>";
	}
	else
	{
		//echo "<h4 align = 'center'>\"".$x."\" of type \"".$z."\"</h4><br/> <h1 align = 'center'> No Discography Found</h1>";
		$myxml = $myxml."</results>";
	}

	
	echo $myxml;	
	}

/*============================================================================================
							ALBUMS
==============================================================================================*/

if($z=="albums")
{
	$regexp = '/<div class=\"image\">[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)data-tooltip=\"(.*)}}\">(.*)<\/a>(.*)[\n][\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)<br\/>[\n](.*)<\/div>/';
	//$reg_i = '/<div class=\"cropped-image\"(.*)<img src=\"(.*)\"[\s]style=\"(.*)<\/a>/';
	$length = preg_match_all($regexp,$page,$matches,PREG_SET_ORDER);
		
		$myxml = "<?xml version=\"1.0\"?>";
		$myxml = $myxml."<results>";

if($length)
	{		
		if($length>=5)
		{
			$length = 5;
		}
		for($i=0;$i<$length;$i++)
		{
			$reg_img = '/<img src=\"(.*)\" style/';
			$imlen = preg_match_all($reg_img,$matches[$i][3],$img,PREG_SET_ORDER);
			
			if($imlen!=0)
			{
				$myxml = $myxml."<result cover='".myxmlfunc($img[0][1])."' ";
				
			}
			else
			{
				$myxml = $myxml."<result cover='album.jpg' ";
			}
			if(preg_match_all('/[0-9a-zA-Z]/',$matches[$i][16],$d1,PREG_SET_ORDER))
			{	
				$myxml = $myxml."title='".myxmlfunc($matches[$i][16])."' ";
			}
			else
			{
				$myxml = $myxml."title='N/A' ";
			}
			$reg_artist = '/<a href(.*)\">(.*)<\/a>/';
			$art = preg_match_all($reg_artist,$matches[$i][19],$art1,PREG_SET_ORDER);
			
			if($art!=0)
			{
				if(preg_match_all('/[0-9a-zA-Z]/',$art1[0][2],$d1,PREG_SET_ORDER))
				{	
					$myxml = $myxml."artist='".myxmlfunc($art1[0][2])."' ";
				}
				else
				{
					$myxml = $myxml."artist='N/A' ";
				}
				
			}
			else
			{
				if(preg_match_all('/[0-9a-zA-Z]/',$matches[$i][19],$d1,PREG_SET_ORDER))
				{	
					$myxml = $myxml."artist='".myxmlfunc($matches[$i][19])."' ";
				}
				else
				{
					$myxml = $myxml."artist = 'N/A' ";
				}
			}
			if(preg_match_all('/[0-9a-zA-Z]/',$matches[$i][24],$d1,PREG_SET_ORDER))
				{	
					$myxml = $myxml."genre = '".myxmlfunc($matches[$i][24])."' ";
				}
				else
				{
					$myxml = $myxml."genre='N/A' ";
				}
			if(preg_match_all('/[0-9a-zA-Z]/',$matches[$i][23],$d1,PREG_SET_ORDER))
			{	
				$myxml = $myxml."year ='".myxmlfunc($matches[$i][23])."' ";
			}
			else
			{
				$myxml = $myxml."year='N/A' ";
			}
			$reg_det = '/<a href="(.*)"/';
			$detlen = preg_match_all($reg_det,$matches[$i][14],$det,PREG_SET_ORDER);
			
			
			if($detlen!=0)
			{
				$myxml = $myxml."details= '".myxmlfunc($det[0][1])."'/>";
			}
			else
			{
				$myxml = $myxml."details='N/A'/>";
			}
				
		}
		$myxml = $myxml."</results>";
	
	}
	else
	{
		//echo "<h4 align = 'center'>\"".$x."\" of type \"".$z."\"</h4><br/> <h1 align = 'center'> No Discography Found</h1>";
	$myxml = $myxml."</results>";
	
	}
	//$myxml1 = preg_replace('/\&/','&amp;',$myxml);
	echo $myxml;
}

/*============================================================================================
							SONGS
==============================================================================================*/

if($z=="songs")
{
	$regexp = '/<div class=\"image\">(.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)[\n](.*)/';
	$length = preg_match_all($regexp,$page,$matches,PREG_SET_ORDER);
	
		$myxml = "<?xml version=\"1.0\"?>";
		$myxml = $myxml."<results>";
	if($length>=5)
	{
		$length = 5;
	}
	
	if($length)
	{	
		for($i=0;$i<$length;$i++)
		{
			$reg_sam = '/<a href=\"(.*)" title/';
			$samlen = preg_match_all($reg_sam,$matches[$i][13],$sample,PREG_SET_ORDER);
			if($samlen!=0)
			{
				$myxml = $myxml."<result sample='".myxmlfunc($sample[0][1])."' ";
				$flag =1;
			}
			else
			{
				$myxml = $myxml."<result sample='headphone.jpg' ";
				$flag = 0;
			}
			$reg_title = '/<a title="(.*) by (.*)\"/';
			$tlen = preg_match_all($reg_title,$matches[$i][3],$titperf,PREG_SET_ORDER);
			if(preg_match_all('/[0-9a-zA-Z]/',$titperf[0][1],$d1,PREG_SET_ORDER))
			{	
				$myxml = $myxml."title='".myxmlfunc($titperf[0][1])."' ";
			}
			else
			{
				$myxml = $myxml."title='N/A' ";
			}
			if($flag)
			{
				$ind = 19;
			}
			else
			{
				$ind = 18;
			}
	
			if(preg_match_all('/[0-9a-zA-Z]/',$titperf[0][2],$d1,PREG_SET_ORDER))
			{	
				$myxml = $myxml."performer='".myxmlfunc($titperf[0][2])."' ";
			}
			else
			{
				$myxml = $myxml."performer='N/A' ";
			}
			
			if($flag)
			{
				$ind1 = 23;
			}
			else
			{
				$ind1 = 22;
			}
// check how explode works/////////////////////////////////////////////////////////			
			/*
			$comp = explode('</a> / <a href="',$matches[$i][$ind1]);
			//print_r($comp);
			for($j = 0;$j<count($comp);$j++)
			{
			$reg1 = '/by (.*)$/';
			$alen = preg_match_all($reg1,$comp[$j],$a1,PREG_SET_ORDER);
			echo "==".$a1[0][1]."==";
			}
*/
			$reg_comp = '/<a href=(.*)\">(.*)<\/a>/';
			$complen = preg_match_all($reg_comp,$matches[$i][$ind1],$comp,PREG_SET_ORDER);
			if(preg_match_all('/[0-9a-zA-Z]/',$comp[0][2],$d1,PREG_SET_ORDER))
			{	
				$myxml = $myxml."composer='".myxmlfunc($comp[0][2])."' ";
			}
			else
			{
				$myxml = $myxml."composer='N/A' ";
			}
			
			$reg_det = '/<a href=\"(.*)\">&quot/';
			$detlen = preg_match_all($reg_det,$matches[$i][$ind],$details,PREG_SET_ORDER);
			$myxml = $myxml."details='".myxmlfunc($details[0][1])."'/>";
			
			}
	$myxml = $myxml."</results>";
	}
	else
	{
		//echo "<h4 align = 'center'>\"".$x."\" of type \"".$z."\"</h4><br/> <h1 align = 'center'> No Discography Found</h1>";
	$myxml = $myxml."</results>";
	}
	echo $myxml;
}
?>  