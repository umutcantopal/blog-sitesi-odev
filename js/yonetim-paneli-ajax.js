$(document).ready(function(){
	$(".silinen-yorum-geri-getir-link").click(function(){
		var yorumid = $(this).parent().parent().attr("yorumid");
		
		$.ajax({
			url:"../yonetim/ajax-mesaj-geri-getir.php",
			type:"POST",
			data:{"yorumid": yorumid},
			success:function(x){
				switch(x){
					case "hata":
					$(".silik-yorum[yorumid="+yorumid+"]").css("background-color", "#bd4d6a").fadeOut(250);
					setTimeout(function(){
						$(".silik-yorum[yorumid="+yorumid+"]").css("background-color", "transparent").fadeIn(250);
					},250);
					break;
					
					case "başarılı":
					$(".silik-yorum[yorumid="+yorumid+"]").css("background-color", "#81d384");
					$(".silik-yorum[yorumid="+yorumid+"]").fadeOut(500);
					break;
					
					case "sorgu hatası":
					$(".silik-yorum[yorumid="+yorumid+"]").css("background-color", "#bd4d6a").fadeOut(250);
					setTimeout(function(){
						$(".silik-yorum[yorumid="+yorumid+"]").css("background-color", "transparent").fadeIn(250);
					},250);
					break;
					
					case "yorum bulunamadı":
					$(".silik-yorum[yorumid="+yorumid+"]").css("background-color", "#bd4d6a").fadeOut(250);
					setTimeout(function(){
						$(".silik-yorum[yorumid="+yorumid+"]").css("background-color", "transparent").fadeIn(250);
					},250);
					break;
					
					default:
					alert("bilinmeyen hata");
				}
			}
		});
	});
});
