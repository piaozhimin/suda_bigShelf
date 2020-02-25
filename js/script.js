/**
 * 
 */
//隐藏div
function hidden1(div_1,div_2){	
	document.getElementById(div_1).style.display="none";
	document.getElementById(div_2).style.display="block";
}
function to_display(id){
	document.getElementById(id).style.display="block";
}
function no_display(id){
	document.getElementById(id).style.display="none";
}


/*获得时间*/
function mytime(){
        var a = new Date();
        var b = a.toLocaleTimeString();
        var c = a.toLocaleDateString();
        document.getElementById("time1").innerHTML = c+"&nbsp"+b;
        }
setInterval(function() {mytime()},1000);

/*计时器*/
var c=0;
var t;
function timedCount()
{
document.getElementById('time2').innerHTML=c;
c=c+1;
//t = setTimeout("timedCount()",1000);
}
setInterval(function() {timedCount()},1000);
function stopCount()
{
c=0;
setTimeout("document.getElementById('txt').value=0",0);
clearTimeout(t);
}