$(document).ready(function(){
	$(".yorumGonderButonu").click(function(){
		var yazilanYorum = $(".yorumTextare").val();
		var makaleID = $(".makale_id").text();
		ajaxIslem(yazilanYorum, makaleID);
	})
	
	function ajaxIslem(x, y){
		$.ajax({
			url: "../makale/yorum-gonderme.php",
			type: "POST",
			data: {yorum: x, makaleID: y},
			success: function(a){
				if (a == "boş veri girildi")
				{
					alert("Hiçbir şey yazmadın");
				}
				else if (a == "yorum veritabanına yazılamadı")
				{
					alert(a);
				}
				else
				{
					// $(".yorumlarListe li:first-child").append(a);
					$(".yorumlarListe li:first-child").before(a);
					if(typeof($(".yorum-yazilmamis-bilgi-mesaji")) != "undefined")
					{
						$(".yorum-yazilmamis-bilgi-mesaji").hide();
					}
					$(".yorumTextare").val() = "";
				}
			}
		})
	}
	
	//yorum lisme işlemleri
	$(".yorum-sil-buton").click(function(){
		var yorumid = $(this).parent().parent().attr("yorumid");
		
		$.ajax({
			url:"../makale/yorum-silme.php",
			type:"POST",
			data:{"id": yorumid},
			success:function(x){
				switch(x){
					case "veritabani hatasi":
					alert("Veritabanı Hatası");
					break;
					
					case "istenen yorum yok":
					alert("Yorumu Silerken Hata Oldu");
					break;
					
					case "hata":
					alert("HATA")
					break;
					
					case "başarılı":
					$(".kullanici-yorumu[yorumid=" + yorumid + "]").css("background-color", "#f5fa6d");
					$(".kullanici-yorumu[yorumid=" + yorumid + "]").hide(500);
					break;
					
					default:
					alert("Bilinmeyen Hata");
				}
			}
		});
	});
});