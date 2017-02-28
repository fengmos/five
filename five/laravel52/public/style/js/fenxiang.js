var oShare=document.getElementById('share');
		var oBigdiv=document.getElementsByClassName('bigdiv')[0];
		var oBottomdiv=document.getElementsByClassName('bottomdiv')[0];
		var oPno=document.getElementById('pno');
		oShare.onclick=function(){
			oBigdiv.style.display="block";
			oBottomdiv.style.display="block";
		}
		oPno.onclick=function(){
			oBigdiv.style.display="none";
			oBottomdiv.style.display="none";
		}