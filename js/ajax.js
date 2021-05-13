var url =   "http://localhost/koksgnsBlog";

function mesajgonder(){
    
    var deger= $("#iletisimformu").serialize();
    $.ajax({
        type: "POST",
        url : url+"/inc/mesajgonder.php",
        data: deger,
        success: function(sonuc){
            if($.trim(sonuc) == "bos"){
                
                swal("Hata","Lütfen tüm alanları doldurun", "error");
            }else if($.trim(sonuc)=="format"){
                swal("Hata","E-posta formatı yanlış", "error");
            }else if($.trim(sonuc)=="hata"){
                swal("Hata","Sistem hatası oluştu", "error");
            }else if($.trim(sonuc)=="basarili"){
                swal("Başarılı","Mesajınız alınmıştır. En kısa sürede dönüş sağlanacaktır", "success");
                $("input[name=ad]").val('');
                $("input[name=eposta]").val('');
                $("input[name=konu]").val('');
                $("textarea[name=mesaj]").val('');
            }
        }
    });
}


function yorumyap(){
    
    var deger= $("#yorumformu").serialize();
    $.ajax({
        type: "POST",
        url : url+"/inc/yorumyap.php",
        data: deger,
        success: function(sonuc){
            if($.trim(sonuc) == "bos"){
                
                swal("Hata","Lütfen tüm alanları doldurun", "error");
            }else if($.trim(sonuc)=="format"){
                swal("Hata","E-posta formatı yanlış", "error");
            }else if($.trim(sonuc)=="hata"){
                swal("Hata","Sistem hatası oluştu", "error");
            }else if($.trim(sonuc)=="basarili"){
                swal("Başarılı","Yorumunuz gönderilmiştir. Yönetici tarafından onaylandığında görüntülenecektir.", "success");
                $("input[name=adsoyad]").val('');
                $("input[name=eposta]").val('');
                $("input[name=website]").val('');
                $("textarea[name=yorum]").val('');
            }
        }
    });
}


function aboneol(){
    
    var deger= $("#aboneformu").serialize();
    $.ajax({
        type: "POST",
        url : url+"/inc/aboneol.php",
        data: deger,
        success: function(sonuc){
            if($.trim(sonuc) == "bos"){
                
                swal("Hata","Lütfen tüm alanları doldurun", "error");
            }else if($.trim(sonuc)=="format"){
                swal("Hata","E-posta formatı yanlış", "error");
            }else if($.trim(sonuc)=="hata"){
                swal("Hata","Sistem hatası oluştu", "error");
            }else if($.trim(sonuc)=="basarili"){
                swal("Başarılı","Abonemiz olduğunuz için teşekkürler.", "success");
                $("input[name=eposta]").val('');
            }else if($.trim(sonuc)=="var"){
                swal("Başarılı","Zaten abonemizsiniz!", "error");
            }
        }
    });
}