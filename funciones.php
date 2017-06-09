<?php

require_once('sesion.php');

if(!isset($_SESSION)) 
 { 
        session_start(); 
 } 

class funcion{

	public function phpAlert($msg) {
    	echo '<script type="text/javascript">alert("' . $msg . '")</script>';
     }

    public function llenarLista(){
       for ($i=60; $i <= 240 ; $i++) { 
	   	echo "<option value='".$i."'>".$i."</option>";
	   } 
    }

    public function calcularTotalSinSubsidio($totviv, $totpres, $plazo, $smmlv, $minsub, $maxsub, $tasaInt, $edad, $tasaSub, $tasaSeg, $ingFam){
    	$salariominimo=$smmlv;
    	$minsubsidio=($salariominimo*$minsub);
    	$maxsubsidio=($salariominimo*$maxsub);
    	$submens = $tasaSub/12;
    	$valorinteres=0;
    	$tasaint=($tasaInt/12)/100;
    	$totalcapital=$totpres;
    	$saldocapital=$totalcapital;
    	$valorcuota=0;
        $valorcuotasubsidio=$valorcuota;
        $totcap=0;
        $amortizacion=0;
        $subsidio=0;
        $interes=0;
        $descsubsidio=0;
        $totalpagar=0;
        if($totalcapital=='' || $totviv==''){
            	
        }else{
        	$valorcuota= floor(($totalcapital*$tasaint)/(1-pow(1+$tasaint,(-1*$plazo)))*100)/100;
          	$totalpagar=$valorcuota*$plazo;
          	return $totalpagar;
         }
      }

 public function calcularTotalConSubsidio($totviv, $totpres, $plazo, $smmlv, $minsub, $maxsub, $tasaInt, $edad, $tasaSub, $tasaSeg, $ingFam){
    	$salariominimo=$smmlv;
    	$minsubsidio=($salariominimo*$minsub);
    	$maxsubsidio=($salariominimo*$maxsub);
    	$submens = $tasaSub/12;
    	$valorinteres=0;
    	$tasaint=($tasaInt/12)/100;
    	$totalcapital=$totpres;
    	$saldocapital=$totalcapital;
    	$valorcuota=0;
        $valorcuotasubsidio=$valorcuota;
        $totcap=0;
        $amortizacion=0;
        $subsidio=0;
        $interes=0;
        $descsubsidio=0;
        $totalpagar=0;
        if($totalcapital=='' || $totviv==''){
            	
        }else{
        	$valorcuota= floor(($totalcapital*$tasaint)/(1-pow(1+$tasaint,(-1*$plazo)))*100)/100;
	        $subsidio= round($valorcuota*0.034);	
			if($plazo<=84){
          		$totalpagar=($valorcuota-$subsidio)*$plazo;
            }else{
            	$dif=$plazo-84;
            	$totalpagar=($valorcuota-$subsidio)*84;
            	$totalpagar=$totalpagar+($valorcuota*$dif);
            }
          	return $totalpagar;
         }
      }


    public function calcularSimulacion($totviv, $totpres, $plazo, $smmlv, $minsub, $maxsub, $tasaInt, $edad, $tasaSub, $tasaSeg, $ingFam){
    	$salariominimo=$smmlv;
    	$minsubsidio=($salariominimo*$minsub);
    	$maxsubsidio=($salariominimo*$maxsub);
    	$submens = $tasaSub/12;
    	$valorinteres=0;
    	$tasaint=($tasaInt/12)/100;
    	$totalcapital=$totpres;
    	$saldocapital=$totalcapital;
    	$valorcuota=0;
        $valorcuotasubsidio=$valorcuota;
        $totcap=0;
        $amortizacion=0;
        $subsidio=0;
        $interes=0;
        $descsubsidio=0;
        $idSimulacion=0;
        if($totalcapital=='' || $totviv==''){
            	$this->phpAlert('Por favor digite el valor del credito a a solicitar y de la vivienda y reintente!');
        }else{
            $hoy=date('Y-m-d H_i',strtotime('-5 hours'));
            $tabla='<div id="datos">';
            $tabla=$tabla.'<table border="1" id="datosgrales">';
            $tabla=$tabla.'<tr>';
            $tabla=$tabla.'<td><strong>Fecha de la simulacion:</td>';
            $tabla=$tabla.'<td>'.$hoy.'</td>';
            $tabla=$tabla.'</tr>';
            $tabla=$tabla.'<tr>';
            $tabla=$tabla.'<td><strong>Nombres y apellidos del usuario:</td>';
            $tabla=$tabla.'<td>'.$_SESSION['user_names'].'</td>';
            $tabla=$tabla.'</tr>';
            $tabla=$tabla.'<tr>';
            $tabla=$tabla.'<td><strong>Edad del usuario:</td>';
            $tabla=$tabla.'<td>'.$edad.'</td>';
            $tabla=$tabla.'</tr>';
            $tabla=$tabla.'<td><strong>Ingresos Familiares del usuario:</td>';
            $tabla=$tabla.'<td>$'.$ingFam.'</td>';
            $tabla=$tabla.'</tr>';
            $tabla=$tabla.'<tr>';
            $tabla=$tabla.'<td><strong>Valor del inmueble:</td>';
            $tabla=$tabla.'<td>$'.$totviv.'</td>';
            $tabla=$tabla.'</tr>';
            $tabla=$tabla.'<tr>';
            $tabla=$tabla.'<td><strong>Valor a prestar:</td>';
            $tabla=$tabla.'<td>$'.$totpres.'</td>';
            $tabla=$tabla.'</tr>';
            $tabla=$tabla.'<tr>';
            $tabla=$tabla.'<td><strong>Plazo (meses):</td>';
            $tabla=$tabla.'<td>'.$plazo.'</td>';
            $tabla=$tabla.'</tr>';
            $tabla=$tabla.'<td><strong>Tasa de interes:</td>';
            $tabla=$tabla.'<td>'.$tasaInt.'%(E.A.)</td>';
            $tabla=$tabla.'</tr>';
            $tabla=$tabla.'<td><strong>Tasa de interes del subsidio:</td>';
            $tabla=$tabla.'<td>'.$tasaSub.'%(E.A.)</td>';
            $tabla=$tabla.'</tr>';
            $tabla=$tabla.'<td><strong>Tasa de interes del seguro de vida:</td>';
            $tabla=$tabla.'<td>'.$tasaSeg.'%(Sobre el valor del inmueble asegurado)</td>';
            $tabla=$tabla.'</tr></div>';
            $tabla=$tabla.'<p><p/>';
        	$tabla=$tabla.='<div id="miTabla">';
        	$tabla=$tabla.'<table border="1" id="simulacion">';
        	$tabla=$tabla.'<tr align="center">
				             <th>Numero Cuota</th>
				             <th>Interes</th>
				             <th>Abono Capital</th>
				             <th>Subsidio</th>
                             <th>Seguro de vida</th>
				             <th>Valor Cuota</th>
				             <th>Valor Cuota Con Subsidio</th>
				             <th>Saldo</th>
	         	 			</tr>';
	         $valorcuota= floor(($totalcapital*$tasaint)/(1-pow(1+$tasaint,(-1*$plazo)))*100)/100;
	        if (($totviv >= $minsubsidio) && ($ingFam < (2*$salariominimo))){
						$subsidio= round(($totalcapital*($tasaSub/100))/$plazo);	
			}else if (($ingFam < (2*$salariominimo) || $ingFam > (4*$salariominimo)) && ($totviv >= $minsubsidio || $totviv<=$maxsubsidio)){ 
				$subsidio= round(($totalcapital*($tasaSub/100))/$plazo);
			}else{
          		$subsidio= 0;
          	}
            $vlrSeg=($tasaSeg / 100);
            $vlrSeg=round($vlrSeg*$totalcapital);
            $valorcuota=round($valorcuota+$vlrSeg);
          	$sesiones=new sesion();
          	$result3= $sesiones->crearSimulacion($_SESSION['user_id'],$totviv,$totpres,$plazo);
	        for ($i=0; $i < $plazo; $i++) { 
	        	//calculo de intereses a pagar en el periodo 
		        $intereses=round($saldocapital * $tasaint *100)/100;
		        //calculo de capital a pagar en el periodo
          	    $amortizacion=round(($valorcuota-$intereses)*100)/100;
          	    //calculo de saldo de capital a pagar en el prestamo
				$saldocapital=round(($saldocapital-$amortizacion)*100)/100;
                if ($i<84){
		            $descsubsidio= $valorcuota-$subsidio;
			    }else{
			    	$descsubsidio=$valorcuota;
		        }
		        $numcuota=$i+1;
	        	$tabla=$tabla.'<tr align="center"><td>'.$numcuota.'</td><td>$'.$intereses.'</td><td>$'.$amortizacion.'</td><td>$'.$subsidio.'</td><td>$'.$vlrSeg.'</td><td>$'.$valorcuota.'</td><td>$'.$descsubsidio.'</td>'; 	 	
				 if ($saldocapital <0 ){
				 	$saldocapital=0;
				 }
				 $tabla=$tabla.'<td>$'.$saldocapital.'</td>';
				 $tabla=$tabla.'</tr>';
				 $sesiones=new sesion();
				 $k=$i+1;
				 $idSimulacion= $sesiones->getIdUltSimulacion($_SESSION['user_id']);
				 $result2= $sesiones->crearResultadoSimulacion(intval($idSimulacion),intval($k),intval($intereses),intval($amortizacion),intval($subsidio),intval($valorcuota),intval($descsubsidio),intval($saldocapital));
	        }
	     	$tabla=$tabla.'</table>';
	     	$tabla=$tabla.'</div>';
			return $tabla;
        }
    }
    public function exportarPDF($edad,$ingFam,$valviv,$valpres,$plazo,$tasaInt,$tasaSub,$tasaSeg,$tablas,$vlrconsub,$vlrsinsub,$tablas){
                    $hoy=date('Y-m-d H_i',strtotime('-5 hours'));
                   $html='<html><h1 style="color: #5e9ca0;">Simulador Hipotecario - Cooperativa Financiera Centro Andina</h1>';
                    $html=$html.'<h2 style="color: #2e6c80;">Resultado de la simulacion:</h2>';
                    $html=$html.$tablas;
                    $html=$html.'<p><strong>Total a pagar del prestamo con subsidio: '.$vlrconsub.'</strong></p>';
                    $html=$html.'<p><strong>Total a pagar del prestamo sin subsidio: '.$vlrsinsub.'</strong></html>';
                    $nombrearchivo='pdf/'.$_SESSION['login_user'].'_'.$hoy.'.pdf';
                    try
                    {   
                        $client = new Pdfcrowd("simulador", "528fe7db4e816edc297e8ce8d52092bd");
                        $out_file = fopen($nombrearchivo, "wb");
                        // convert a web page and store the generated PDF into a $pdf variable
                        $client->setHeaderHtml('<div style="height:70pt; text-align:center; background-color:#eee;padding-top:15px">' .
                        '</div>');
                        $pdf = $client->convertHtml($html,$out_file);
                        fclose($out_file);
                    }
                    catch(PdfcrowdException $why)
                    {
                        echo "Pdfcrowd Error: " . $why;
                    }
                    return $nombrearchivo;
    }

    public function saveAs($yourfile){
        //readfile($yourfile);
        //
        echo '<p><strong><a href="'.$yourfile.'" download>Exportar a PDF</a></strong></p>';
    }

 }
?>