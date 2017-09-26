 	//getDateTime
	function getDateTime(){
		var d = new Date();
		var yy = d.getFullYear();
		var mm = d.getMonth()+1;
		var dd = d.getDate();
		var hh = d.getHours();
		var mi = d.getMinutes();
		var ss = d.getSeconds();
		var result = yy + "-" + setWordLenth(mm, 2) + "-" + setWordLenth(dd, 2) + " " + setWordLenth(hh, 2) + ":" + setWordLenth(mi, 2) + ":" + setWordLenth(ss, 2);
		return result;
	}	  
	
	//setwordLenth
	function setWordLenth(n, len) {
		var str = new String(n);
		if (str.length < len) {
			for (var i=str.length; i<len; i++) {
				str = "0" + str;
			}
		}
	
		return str;
	} 		
	

// 왼쪽부터 숫자 들어가고, 숫자만 입력되는 코드
//http://ihelpers.x2soft.co.kr/programming/tipntech.php?CMD=view&TYPE=0&KEY=%C3%B5%B4%DC%C0%A7&SC=S&&CC=C&PAGE=1&IDX=145
function currency(obj)
{
	if (event.keyCode >= 48 && event.keyCode <= 57) {
		
	} else {
		event.returnValue = false;
	}
}
function com(obj)
{
	obj.value = unComma(obj.value);
	obj.value = Comma(obj.value);
}
function Comma(input) {

  var inputString = new String;
  var outputString = new String;
  var counter = 0;
  var decimalPoint = 0;
  var end = 0;
  var modval = 0;

  inputString = input.toString();
  outputString = '';
  decimalPoint = inputString.indexOf('.', 1);

  if(decimalPoint == -1) {
     end = inputString.length - (inputString.charAt(0)=='0' ? 1:0);
     for (counter=1;counter <=inputString.length; counter++)
     {
        var modval =counter - Math.floor(counter/3)*3;
        outputString = (modval==0 && counter <end ? ',' : '') + inputString.charAt(inputString.length - counter) + outputString;
     }
  }
  else {
     end = decimalPoint - ( inputString.charAt(0)=='-' ? 1 :0);
     for (counter=1; counter <= decimalPoint ; counter++)
     {
        outputString = (counter==0  && counter <end ? ',' : '') +  inputString.charAt(decimalPoint - counter) + outputString;
     }
     for (counter=decimalPoint; counter < decimalPoint+3; counter++)
     {
        outputString += inputString.charAt(counter);
     }
 }
    return (outputString);
}

/* -------------------------------------------------------------------------- */
/* 기능 : 숫자에서 Comma 제거                                                 */
/* 파라메터 설명 :                                                            */
/*        -  input : 입력값                                                   */
/* -------------------------------------------------------------------------- */
function unComma(input) {
   var inputString = new String;
   var outputString = new String;
   var outputNumber = new Number;
   var counter = 0;
   if (input == '')
   {
	return 0;
   }
   inputString=input;
   outputString='';
   for (counter=0;counter <inputString.length; counter++)
   {
      outputString += (inputString.charAt(counter) != ',' ?inputString.charAt(counter) : '');
   }
   outputNumber = parseFloat(outputString);
   return (outputNumber);
}



$(document).ready(function() {

   //title
   document.title = "InfoNetworks";
   $(".loginlogo").text("InfoNetworks");
   $(".logo").text("© InfoNetworks.");

 
});
