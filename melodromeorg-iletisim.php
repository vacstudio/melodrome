<!-- 
	
	ÖNEMLİ AÇIKLAMA!!!
	
	Bu dosya aslında webtools.vacstudio.com adresi altında çalışıyor, 
	Sadece bilgilendirme amacıyla buraya eklenmiştir,
	Değişiklik yapıldıktan sonra lütfen sistem yöneticinize haber veriniz...

-->

<?
include(dirname(__FILE__)."/mailer/lib/class.phpmailer.php");

function mailGonder($kimdenmail,$kimdenisim,$kime,$konu,$icerik)
{
	$mail = new PHPMailer(true); 
	

	try {
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;                      // enable SMTP authentication
        $mail->SMTPSecure = "ssl";
		$mail->Host       = "smtp.gmail.com";          // sets the SMTP server
		$mail->Port       = 465;                       // set the SMTP port for the GMAIL server
		$mail->Username   = "destek@vacstudio.com";    // SMTP account username
		$mail->Password   = "vacs2009";         	   // SMTP account password

		$mail->AltBody = 'Mesajı görüntülemek için, lütfen HTML uyumlu eposta görüntüleyici kullanın.'; // optional - MsgHTML will create an alternate automatically
		$mail->AddReplyTo($kimdenmail, $kimdenisim);
		$mail->SetFrom($kimdenmail, $kimdenisim);

		$mail->AddAddress($kime);
		$mail->Subject = $konu;
		$mail->MsgHTML($icerik);

		$mail->Send();
	} catch (phpmailerException $e) {
	  echo $e->errorMessage(); //Pretty error messages from PHPMailer
	} catch (Exception $e) {
	  echo $e->getMessage(); //Boring error messages from anything else!
	}
}

header('Content-Type: text/html; charset=utf-8');

$adSoyad=$_POST["adsoyad"];
$eMail=$_POST["email"];
$telefon=$_POST["telefon"];
$konu=$_POST["konu"];
$mesaj=$_POST["mesaj"];

if(empty($adSoyad) || empty($eMail) || empty($konu) || empty($mesaj))
{
	$responseMessage="Lütfen tüm zorunlu alanları doldurun.";
}
else
{
	$icerik="Merhaba,<br /><br />www.melodrome.org üzerinden gönderilen <b>İletişim Formu</b> bilgileri aşağıdaki gibidir;<br/><br/>
    <b>Ad Soyad:</b> $adSoyad <br />
    <b>Email:</b> $eMail <br />
    <b>Telefon:</b> $telefon <br />
	<b>Konu:</b> $konu <br />
    <b>Mesaj:</b> $mesaj <br /><br />
    <span style='color:#777;'>V.A.C. Studio Destek Ekibi</span>";
	mailGonder("noreply@vacstudio.com","V.A.C. Studio Destek Ekibi","nevcanuludas@gmail.com","iletisim Formu (www.melodrome.org)",$icerik);
	$responseMessage="Mesajınız başarıyla iletilmiştir. Siteye dönmek için devam edin.";
}
    ?>
    
<script type="text/javascript">
    alert("<?php echo $responseMessage;?>");
    history.go(-1);
</script>
