<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>NCBI Entrez search</title>
</head>
<body>

<?php
//查询的数据库和关键词
$db = $_POST["db"]; //
$term = $_POST["term"]; 
$term = str_replace(" ","+", $term); //replace spaces among several keywords with +//replace spaces among several keywords with +

//查询重定向
$query = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?db=".$db."&term=".$term."&retmode=xml";
//远程查询
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在 
	curl_setopt($curl, CURLOPT_URL, $query); 
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($curl,CURLOPT_HEADER,0);
	
	$output = curl_exec($curl);
	 if($output === FALSE ){
	 	echo "CURL Error:".curl_error($curl);
	 }else{
		//echo $output;
	 	echo"CURL successfully.<br/>"; 
	 }
	   
	curl_close($curl); 

//结果输出
//$handle = fopen("entrez_results.xml","w");
//fwrite($handle, $output);
//fclose($handle);

$id = array();


$xmlparser = xml_parser_create();

if(xml_parse_into_struct($xmlparser,$output,$values))
{
	//print_r($values);
	foreach($values as $i => $lines)
	{
		//print_r($lines); 
		//echo $i.": ";
		foreach($lines as $j => $col)
		{
			//echo $j."=".$col."; ";	
			if($j == "tag" and $col == "ID") 
			{
				echo "ID=".$lines["value"]."<br />"; 
				array_push($id,$lines["value"]);
				if(!isset($id_str) || empty($id_str)){$id_str = $lines["value"];}else{$id_str .=","; $id_str .= $lines["value"];}
			} 
			
		}
	}

}else{echo "Warning: parsing xml error!";}

xml_parser_free($xmlparser);

//print_r($id);

echo "<h1>文摘信息(1-20)</h1>";

//根据id获取文摘信息（PubMed）

$query2 = "https://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?db=".$db."&id=".$id_str."&retmode=xml&rettype=abstract";
//远程查询
	$curl2 = curl_init();
	curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查 
	curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在 
	curl_setopt($curl2, CURLOPT_URL, $query2); 
	curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1); 
	curl_setopt($curl2,CURLOPT_HEADER,0);
	
	$output2 = curl_exec($curl2);
	 if($output2 === FALSE ){
	 	echo "CURL Error:".curl_error($curl2);
	 }else{

	 	echo"CURL2 successfully.<br/>"; 
		//echo $output2;
	 }
	   
	curl_close($curl2); 

//结果输出2
$handle2 = fopen("../xml/entrez_results2.xml","w");
fwrite($handle2, $output2);
fclose($handle2);

echo "<input type='button' onclick='show_confirm()' value='Entrez search completed! 你想直接显示XML格式结果吗？' />";

?>


<script type="text/javascript">

function show_confirm()
{
	var r = confirm("你确认要直接显示XML格式结果吗？");
	if (r==true)
	 {
	  	alert("你点击了确认按钮——直接显示XML格式结果!");
		window.location.href="../xml/entrez_results2.xml";
	}else{
  		alert("你点击了取消按钮——异同加载并解析XML格式结果!");
		window.location.href="Entrez_show2.html";
 	 }
}
</script>



</body>
</html>
