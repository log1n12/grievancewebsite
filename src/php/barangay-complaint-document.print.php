<?php

require_once __DIR__ . '/vendor/autoload.php';


$html = '<html>
<head>
	<title></title>

	<style>
		h1, h2, h3, h4, h5, h6, p {
			margin: 0!important;
			padding: 0!important;
		}
		*{
			
		}
		ul li{
			list-style: none;
		}

		.compL{
			text-decoration: underline;
			font-weight: bold;
			padding: 0 20px;
		}

		* {
  box-sizing: border-box;
}


	</style>
</head>
<body>
	


<table style="width: 100%;">
        <tbody>
            <tr>
                
                    <td style="text-align: center;"> <img style="max-width: 80px;" src="../assets/66.png" /> </td>
                
                
                   <td style="text-align: center;"><p>Republika ng Pilipinas</p>
			<p>Lalawigan ng Laguna</p>
			<p>Bayan ng Magdalena</p>
			<h3><b>BARANGAY ' . $barangayName . '</b></h3></td>

                   <td style="text-align: center;"><img style="max-width: 80px;" src="../assets/55.png" /></td>
                
            </tr>
            
        </tbody>
    </table>
<div style="margin-top: 40px; text-align: right;">
	 <p> <u>' . date("F j, Y") . '</u> </p> 
	</div>
    <div style="margin-top: 20px; text-align: center;">
	 <p> PAABISO NG PAGDINIG </p> 
     <p style="font-size: 15px;"> ( Mga hakbang ng Pamamagitan) </p>
	</div>
	

    <table style="width: 100%; margin-top: 20px;">
        <tbody>
		
            <tr>
                
                    <td> <span><b><u>' . $endorseComplainant . '</b></u></span>(Mga) May sumbong </td>
                
            </tr>
            
        </tbody>
    </table>


		

			<div style="padding: 0 30px; margin-top: 30px;">
				<p style="">Ito ay nagpapatunay na: </p>
				
				<p style="text-align: justify; text-indent: 100px; margin-top: 20px;">Ikaw ay inuutusan na humarap sa akin sa <span style="border-bottom: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $meetDay11 . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> araw ng <span style="border-bottom: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $meetMonth11 . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>, ' . $meetYear11 . ' sa ganap na ika- ' . $meetTime . ' para sa pagdinig ng iyong sumbong.</p>

				<p style="text-align: justify; text-indent: 100px; margin-top: 20px;">Ngayong ika- <span style="border-bottom: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . date("j") . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> araw ng <span style="border-bottom: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . date("F") . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>, ' . date("Y") . '.</p>

			</div>

<div style="text-align: right; float: right; margin-top: 40px;">
<img src="../assets/signature/' . $brgyCaptSignature . '" alt="Girl in a jacket" style="width: auto; height: 80px; margin-bottom: 0; padding-bottom: 0;">
			<h4 style="margin-top: 0; padding-top: 0; padding-right: 50px;" class="compL">' . $brgyCaptain . '</h4>
			<p style="margin-top: 5px; padding-right: 70px;">Punong Barangay</p>
			</div>


		
<div style="padding: 0 30px; margin-top: 30px;">
				
				<p style="text-align: justify; text-indent: 100px; margin-top: 20px;">Pinaabisuhan ngayong ika- ______ araw ng ______________, ' . date("Y") . '.</p>

			</div>

            <div style="margin-top: 40px; text-align: right;">
	 <p> <b> ________________________ </b> </p> 
     <p> <b> ________________________ </b> </p> 
     <p> ( Mga ) May sumbong </p> 
	</div>


</body>
</html>';



//for defendant

$html1 = '<html>
<head>
	<title></title>

	<style>
		h1, h2, h3, h4, h5, h6, p {
			margin: 0!important;
			padding: 0!important;
		}
		*{
			
		}
		ul li{
			list-style: none;
		}

		.compL{
			text-decoration: underline;
			font-weight: bold;
			padding: 0 20px;
		}

		* {
  box-sizing: border-box;
}


	</style>
</head>
<body>
	


<table style="width: 100%;">
        <tbody>
            <tr>
                
                    <td style="text-align: center;"> <img style="max-width: 80px;" src="../assets/66.png" /> </td>
                
                
                   <td style="text-align: center;"><p>Republika ng Pilipinas</p>
			<p>Lalawigan ng Laguna</p>
			<p>Bayan ng Magdalena</p>
			<h3><b>BARANGAY ' . $barangayName . '</b></h3></td>

                   <td style="text-align: center;"><img style="max-width: 80px;" src="../assets/55.png" /></td>
                
            </tr>
            
        </tbody>
    </table>
<div style="margin-top: 20px; text-align: center;">
	 <p> TANGGAPAN NG LUPONG TAGAPAMAYAPA </p> 
	</div>
	

    <table style="width: 100%; margin-top: 20px;">
        <tbody>
		
            <tr>
                
                    <td> <span><b><u>' . $endorseComplainant . '</b></u></span>(Mga) May sumbong </td>
                
                
                   <td>Usaping Barangay Blg. <b><u>' . $complaintDocNo . '</u></b>
				   
				 
				   </td>
                
            </tr>
            <tr>
                
                    <td style="padding-top: 10px; padding-bottom: 10px;"> - Laban Kay/Kina - </td>
                
                <td>
                    Ukol sa: <b><u>' . $ukolSa . '</b></u>
                </td>
            </tr>
            <tr>
                
                    <td><span><b><u>' . $endorseDefendant . '</b></u> </span>(Mga) Ipinagsusumbong </td>
                
                <td>
                   
                </td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%; margin-top: 20px;">
        <tbody>
		
            <tr>
                
                    <td> Kay: <span><b><u>' . $endorseComplainant . '</b></u></span> </td>
                
                
                   <td>
                   
                   Patawag <br> <span><b><u>' . $endorseDefendant . '</b></u> </span>
				 
				   </td>
                
            </tr>
        </tbody>
    </table>


		<div style="text-align: center; margin-top: 40px;">
			<p>( Mga Ipinagsusumbong )</p>
		</div>

			<div style="padding: 0 30px;">
				<p style="text-align: justify; text-indent: 100px; margin-top: 20px;">Sa pamamagitan nito, kayo ay ipinatawag upang personal na humarap sa akin, kasama ang inyong mga testigo, sa <span style="border-bottom: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $meetDay11 . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> araw ng <span style="border-bottom: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $meetMonth11 . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>, ' . $meetYear11 . ' sa ganap na ika- ' . $meetTime . ', upang sagutin ang sumbong na ginagawa sa harap ko, na ang sipi ay kalakip nito, para pamagitanan/papagkasunduin ang inyong ( mga ) alitan ng ( mga ) nagsusumbong.</p>

                <p style="text-align: justify; text-indent: 100px; margin-top: 20px;">Sa pamamagitan nito, kayo ay binabalaan na ang inyong pagtanggi o kusang di pagharap bilang pagtalima sa pagtawag na ito, kayo ay hahadlangan na makapaghain ng ganting-sumbong na magmumula sa nagsabing sumbong. </p>

                <p style="text-align: justify; text-indent: 100px; margin-top: 20px;"> TUPARIN ITO, at kung hindi ay parurusahan kayo sa salang paglapastangan sa hukuman. </p>

				<p style="text-align: justify; text-indent: 100px; margin-top: 20px;">Ngayong ika- <span style="border-bottom: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . date("j") . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> araw ng <span style="border-bottom: 1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . date("F") . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>, ' . date("Y") . '.</p>

			</div>

<div style="text-align: right; float: right; margin-top: 40px;">
<img src="../assets/signature/' . $brgyCaptSignature . '" alt="Girl in a jacket" style="width: auto; height: 80px; margin-bottom: 0; padding-bottom: 0;">
			<h4 style="margin-top: 0; padding-top: 0; padding-right: 50px;" class="compL">' . $brgyCaptain . '</h4>
			<p style="margin-top: 5px; padding-right: 70px;">Punong Barangay</p>
			</div>


</body>
</html>';










include("./vendor/mpdf/mpdf/src/Mpdf.php");
$mpdf = new \Mpdf\Mpdf();

$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;

$today = date("YmdHis");
$filepath = "../assets/complaintprint/";
$filename = $today . "griv_" . $barangayName . "_" . $complaintDocNo . "_document" . ".pdf";

$mpdf->WriteHTML($html);
$mpdf->AddPage(); // Adds a new page in Landscape orientation
$mpdf->WriteHTML($html1);

$filee = $filepath . $filename;
// Output a PDF file directly to the browser
$mpdf->Output($filepath . $filename, \Mpdf\Output\Destination::FILE);

echo "
            <script type=\"text/javascript\">
             var oWindow = window.open('$filee');
            oWindow.print();
            </script>
        ";
