<?php
	require_once('sesion.php');
    //include('logout.php');
    if(!isset($_SESSION)) 
    { 
        session_start(); 
        if (!isset($_SESSION['login_user'])){
        	header('Location: index.php');
        	exit();
        }
    } 
    function phpAlert($msg) {
    	echo '<script type="text/javascript">alert("' . $msg . '")</script>';
     }
    if($_SERVER["REQUEST_METHOD"] != "POST") {
          $sesiones = new Sesion();
	      $cont = $sesiones->countSimulaciones($_SESSION['user_id']);
	      //$cont = $stmt -> rowCount();
	      if($cont==0){
	      		phpAlert("No hay simulaciones registradas para el usuario");	
	      		header("Refresh:1; url=menuppal.php");
	      }		
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Simulador Hipotecario - Consultar Simulacion</title>
    <link rel="stylesheet" type="text/css" href="css/topnav.css">

    <style type="text/css">
    <!--
    .style1 {
    	font-size: 36px;
    	font-weight: bold;
    }
    -->
    </style>
    </head>
     
    <body>

      <!-- Header -->
        <div id="header">
          <div class="container">
         
            <!-- Logo -->
            <div id="logo">
              <h1><a><img src="images/logo_miniatura.jpg"/> COOPERATIVA FINANCIERA CENTRO ANDINA</a><h2>Ayudamos a tu progreso</h2></h1>

              <br/>
              <h1 align="left">Simulador Hipotecario - Consultar Simulaciones</h1> 
            </div>
          </div>
        </div>
		<br />
		<div class="topnav" id="menu">
        <ul>
        <li><a href="menuppal.php">Regresar al Menú Principal</a></li>
        <li><a href="logout.php">Cerrar Sesión</a></li>
        </ul>
      </div>
		<br />
		<br />
		<br />
		<form name="loginform" action="" method="post" onSubmit="this.adicionarCombo()">
	      <?php
	      		if($_SESSION['user_type'] == 1){
	      			echo '<p>Por favor seleccione la simulación a consultar o seleccione el rango de fechas de búsqueda, las dos formas de búsqueda son excluyentes</p>';
	      			echo'<table width="800" border="0" align="center" cellpadding="2" cellspacing="5" >';
	      			echo '<tr border="0">';
		       		echo '<td><div width="430" align="left">Seleccione la simulación a consultar:</div></td>';
		        	echo '<td><select name="simulacionsel">';
		        	$sesiones = new Sesion();
			        $result=$sesiones->simulacionesUsuario($_SESSION['user_id']);
			        echo "<option value='0'>Seleccione una simulacion</option>";
		    	    foreach($result as $row){
		    	    	$nomArchivo=substr($row['archivo'],0,strlen($row['archivo'])-4);
		        		echo "<option value='".$row['id']."'>".$nomArchivo."</option>";
		        	}
		        	echo '</select></td>';
		      		echo '</tr>';
	      		}elseif ($_SESSION['user_type'] == 2){
	      			echo '<p>Por favor seleccione el usuario a consultar o seleccione el rango de fechas de búsqueda, las dos formas de búsqueda son excluyentes</p>';
	      			echo'<table width="800" border="0" align="center" cellpadding="2" cellspacing="5" >';
		      		echo'<tr border="0">';
		        	echo'<td><div width="430" align="left">Seleccione el usuario que desea consultar:</div></td>';
		        	echo '<td><select name="usuariosel" onChange="adicionarCombo(this.form)">';
		        	echo "<option value='0'>Seleccione un usuario a consultar</option>";
		        	$sesiones = new Sesion();
		        	$result=$sesiones->todosUsuarios();
		        	foreach($result as $row){
		        		echo "<option value='".$row['id_usuario']."'>".$row['nombres']." ".$row['apellidos']."</option>";
		        	}
		        	echo'</select></td>';
		      		echo'</tr>';
		      	}
	      ?> 
	      <tr>
	        <td><div align="left">Seleccione la fecha inicial de busqueda:</div></td>
	        <td><input name="fechainicial" type="date" /></td>
	      </tr>
	      <tr>
	        <td><div align="left">Seleccione la fecha final de busqueda:</div></td>
	        <td><input name="fechafinal" type="date" /></td>
	      </tr>
	       <tr>
	        <td><div align="right"></div></td>
	        <td><input name="" type="submit" value="Consultar" /></td>
	      </tr>
	    </table>
	</form>
	<?php
	if($_SERVER["REQUEST_METHOD"] == "POST") {
	      		if($_SESSION['user_type'] == 1){
	      			$sesiones = new Sesion();
	      			 if(isset($_POST['simulacionsel']) && $_POST['simulacionsel']!=0){
	        			$simulacion=$_POST['simulacionsel'];
	        			echo '<div id="resultadoconsulta">';
	        			echo '<table>';
	        			echo '<tr>';
	        			echo '<th>Id Simulacion</th>';
	        			echo '<th>Usuario</th>';
	        			echo '<th>Fecha Creacion</th>';
	        			echo '<th>Archivo Generado</th>';
						$stmt=$sesiones->simulacionPorId($simulacion);
						$row=$stmt->fetch(PDO::FETCH_ASSOC);
		    	    	$nomArchivo=$row['archivo'];
			    	    $yourfile='pdf/'.$nomArchivo;
			    	    $newDate = date("Y-m-d", strtotime($row['Fecha']));
			    	    echo '<tr>';
			        	echo '<td>'.$row['id'].'</td><td>'.$_SESSION['login_user'].'</td><td>'.$newDate.'</td><td><img src="images/pdf-icon.png"><a href="'.$yourfile.'" download>'.$nomArchivo.'</a></img></td><td>';
			        	echo '</table></div>';	
	        		}elseif(isset($_POST['simulacionsel']) && $_POST['simulacionsel']==0 && strcmp($_POST['fechainicial'],'')!=0 && strcmp($_POST['fechafinal'],'')!=0 ){
	        			$fechaini=$plazo=	$_POST['fechainicial'];
						$fechafin=$plazo=	$_POST['fechafinal'];
	        			$result=$sesiones->simulacionesUsuarioPorFechas($_SESSION['user_id'],$fechaini,$fechafin);
	        			$count = $result->rowCount();
	        			if($count==0){
	        				$sesiones->phpAlert('El usuario NO tiene simulaciones creadas en las fechas especificadas!');
	        			}else{
	        				echo '<div id="resultadoconsulta">';
		        			echo '<table>';
		        			echo '<tr>';
		        			echo '<th>Id Simulacion</th>';
		        			echo '<th>Usuario</th>';
		        			echo '<th>Fecha Creacion</th>';
		        			echo '<th>Archivo Generado</th>';
				    	    foreach($result as $row){
				    	    	$nomArchivo=$row['archivo'];
				    	    	$yourfile='pdf/'.$nomArchivo;
				    	    	$newDate = date("Y-m-d", strtotime($row['Fecha']));
				    	    	echo '<tr>';
				        		echo '<td>'.$row['id'].'</td><td>'.$_SESSION['login_user'].'</td><td>'.$newDate.'</td><td><img src="images/pdf-icon.png"><a href="'.$yourfile.'" download>'.$nomArchivo.'</a></img></td>';
				        	}
				        	echo '</table></div>';	
				        }	
	        		}else{
	        			$sesiones->phpAlert('Por favor seleccione una simulacion o digite el rango de fechas para consultar simulaciones!');
	        		}
	        		
	      		}else{
	      			if(isset($_POST['usuariosel']) && $_POST['usuariosel']!=0 && strcmp($_POST['fechainicial'],'')==0 && strcmp($_POST['fechafinal'],'')==0){
	        			$iduser=$_POST['usuariosel'];
	        			$result=$sesiones->simulacionesUsuario($iduser);
	        			$count=$result->rowCount();
	        			if($count==0){
	        				$sesiones->phpAlert('El usuario consultado NO tiene simulaciones creadas!');
	        			}else{	
	        				
	      					echo '<div id="resultadoconsulta">';
	        				echo '<table>';
	        				echo '<tr>';
	        				echo '<th>Id Simulacion</th>';
	        				echo '<th>Usuario</th>';
	        				echo '<th>Fecha Creacion</th>';
	        				echo '<th>Archivo Generado</th>';
				    	    foreach($result as $row){
				    	    	$nomArchivo=$row['archivo'];
				    	    	$yourfile='pdf/'.$nomArchivo;
				    	    	$newDate = date("Y-m-d", strtotime($row['Fecha']));
				    	    	echo '<tr>';
				        		echo '<td>'.$row['id'].'</td><td>'.$iduser.'</td><td>'.$newDate.'</td><td><img src="images/pdf-icon.png"><a href="'.$yourfile.'" download>'.$nomArchivo.'</a></img></td><td>';
				        	}
				        	echo '</table></div>';
			        	}

	      			}elseif(isset($_POST['usuariosel']) && $_POST['usuariosel']==0 && strcmp($_POST['fechainicial'],'')!=0 && strcmp($_POST['fechafinal'],'')!=0){
	      				$fechaini=$plazo=	$_POST['fechainicial'];
						$fechafin=$plazo=	$_POST['fechafinal'];
	        			echo '<div id="resultadoconsulta">';
	        			echo '<table>';
	        			echo '<tr>';
	        			echo '<th>Id Simulacion</th>';
	        			echo '<th>Usuario</th>';
	        			echo '<th>Fecha Creacion</th>';
	        			echo '<th>Archivo Generado</th>';
	        			$result=$sesiones->simulacionesPorFechas($fechaini,$fechafin);
			    	    foreach($result as $row){
			    	    	$nomArchivo=$row['archivo'];
			    	    	$yourfile='pdf/'.$nomArchivo;
			    	    	$newDate = date("Y-m-d", strtotime($row['Fecha']));
			    	    	echo '<tr>';
			        		echo '<td>'.$row['id'].'</td><td>'.$row['id_usuario'].'</td><td>'.$newDate.'</td><td><img src="images/pdf-icon.png"><a href="'.$yourfile.'" download>'.$nomArchivo.'</a></img></td><td>';
			        	}
			        	echo '</table></div>';	
	      			}else{
	      				$sesiones->phpAlert('Por favor seleccione una simulacion o digite el rango de fechas para consultar simulaciones!');
	      			}
	      	}		
	}
	?>
    </body>
    </html>