<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>NCBI Entrez search</title>
</head>
<body>

<?php
//查询的数据库和关键词
$db = $_POST["db"]; //"pubmed";
$term = $_POST["term"]; // = "asthma";
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
$handle = fopen("../xml/entrez_results.xml","w");
fwrite($handle, $output);
fclose($handle);

echo "<input type='button' onclick='show_confirm()' value='Entrez search completed! 你想直接显示XML格式结果吗？' />";

?>


<script type="text/javascript">

function show_confirm()
{
	var r = confirm("你确认要直接显示XML格式结果吗？");
	if (r==true)
	 {
	  	alert("你点击了确认按钮——直接显示XML格式结果!");
		window.location.href="../xml/entrez_results.xml";
	}else{
  		alert("你点击了取消按钮——异同加载并解析XML格式结果!");
		window.location.href="Entrez_show.html";
 	 }
}
</script>


</body>
</html>
