<?php
namespace App\Helpers;
	require_once __DIR__.'/qr/vendor/autoload.php';
	use Endroid\QrCode\ErrorCorrectionLevel;
	use Endroid\QrCode\LabelAlignment;
	use Endroid\QrCode\QrCode;
	use Symfony\Component\HttpFoundation\Response;
	

class QrcodeClass {
	
	static public function generate($text, $logopath, $outpath, $color){
		
		 $qrCode = new   QrCode();;
		 $qrCode->setSize(300);
	
	
    // Set advanced options
	$qrCode
	    ->setText($text)
		->setWriterByName('png')
		->setMargin(10)
		->setEncoding('UTF-8')
		->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH)
		->setForegroundColor($color)
		->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255])
		//->setLabel('Scan the code', 16, __DIR__.'/vendor/assets/noto_sans.otf', LabelAlignment::CENTER)
		->setLogoPath($logopath)
		->setLogoWidth(120)
		->setValidateResult(false);
		
		// Directly output the QR code
		//header('Content-Type: '.$qrCode->getContentType());
		//echo $qrCode->writeString();
	
	
		$qrCode->writeFile($outpath);
	}
}
