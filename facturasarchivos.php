<?php

session_start();

set_time_limit(10000000);

require_once inc/config.php;

$nivel = $_SESSION["pfl_user"];

$regionsession = $_SESSION["region"];

$usuario=$_SESSION["nom_user"];

$objDTEWs = null;

$consultarFechaRecepcionSii= null;

$APRO_COD = 'CNT'; //C�digo del programa en la tabla aprobacion_nivel
$APRO_NIVEL = 1;   //Nivel de autorizaci�n de este programa en la tabla aprobacion_nivel
//$row=mysql_fetch_row(mysql_query("SELECT apro_estado from aprobacion_nivel WHERE apro_cod = '$APRO_COD' AND apro_nivel = '$APRO_NIVEL' AND apro_reg = '$regionsession' "));
//$APRO_ESTADO = $row[0];

$arrayFiscalias = array();

$sqlFiscalias = "SELECT * FROM regiones WHERE activo = 1";

$resFiscalias = mysql_query($sqlFiscalias);

while($rowFiscalias = mysql_fetch_array($resFiscalias))
{
  $arrayFiscalias[] = $rowFiscalias;
}

if($_SESSION["nom_user"] =="" ){

	?><script language="javascript">location.href='sesion_perdida.php';</script><?
}
$date_in=date("d-m-Y");

$read1= rand(0,1000000);

$read4= rand(0,1000000);

require_once($_SERVER["DOCUMENT_ROOT"]."/SII/includes/inc/class.dtews.php"); 

$objDTEWs = new dteWS();

$arrayDocumentos = ["f" => 33,"fa" => 34,"n" => 61,"d" => 56];

?>
<!DOCTYPE html>
<html lang="e">
<head>
  <meta content="text/html; charset=utf-8" />
  <title>Facturas y/o Boletas</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="css/estilos.css" rel="stylesheet" type="text/css">
  <style type="text/css">
    body {
     margin-left: 0px;
     margin-top: 0px;
     margin-right: 0px;
     margin-bottom: 0px;
   }
   .Estilo1 {
     font-family: Verdana;
     font-weight: bold;
     font-size: 10px;
     color: #003063;
     text-align: left;
   }
  
   .Estilo1c {
     font-family: Verdana;
     font-weight: bold;
     font-size: 10px;
     color: #009900;
     text-align: right;
   }

   .link {
     font-family: Geneva, Arial, Helvetica, sans-serif;
     font-size: 10px;
     font-weight: bold;
     color: #00659C;
     text-decoration:none;
     text-transform:uppercase;
   }
   .link:over {
     font-family: Geneva, Arial, Helvetica, sans-serif;
     font-size: 10px;
     color: #0000cc;
     text-decoration:none;
     text-transform:uppercase;
   }
   .link2 {
     font-family: Geneva, Arial, Helvetica, sans-serif;
     font-size: 10px;
     font-weight: bold;
     color: #FF0000;
     text-decoration:none;
     text-transform:uppercase;
   }
   .link2:over {
     font-family: Geneva, Arial, Helvetica, sans-serif;
     font-size: 10px;
     color: #0000cc;
     text-decoration:none;
     text-transform:uppercase;
   }
 

   .Estilo7 {
    font-family: Geneva, Arial, Helvetica, sans-serif;
    font-size: 14px;
    font-weight: bold;
  }
</style>
<!-- calendar stylesheet -->
<link rel="stylesheet" type="text/css" media="all" href="librerias/calendar-win2k-cold-1.css" title="win2k-cold-1" />
<script type="text/javascript" src="jquery/jquery-3.1.1.min.js"></script>
<!-- main calendar program -->
<script type="text/javascript" src="librerias/calendar.js"></script>
<!-- language for the calendar -->
<script type="text/javascript" src="librerias/lang/calendar-en.js"></script>
    <!-- the following script defines the Calendar.setup helper function, which makes
     adding a calendar a matter of 1 or 2 lines of code. -->
     <script type="text/javascript" src="librerias/calendar-setup.js"></script>
     <script src="librerias/js/jscal2.js"></script>
     <script src="librerias/js/lang/es.js"></script>
     <link rel="stylesheet" type="text/css" href="librerias/css/jscal2.css" />
     <link rel="stylesheet" type="text/css" href="librerias/css/border-radius.css" />
     <link rel="stylesheet" type="text/css" href="librerias/css/steel/steel.css" />
     <!-- boottrap -->
     <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
     <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
     <!-- end  bootsrap -->
     <script type="text/javascript">
      function verAsociadas(proye) {
        miPopup = window.open("proyecta_verfacturas.php?id="+proye+"","miwin","width=500,height=500,scrollbars=yes,toolbar=0")
        miPopup.focus()

      }
      $(function() {
        $('#refcollapseOne').on('click',function(){
          var inc = $('#collapseOne').attr('class').search("in");
          if( inc < 0){
            $('#collapseOne').addClass('in');
          }else{
            $('#collapseOne').removeClass('in');
          }
        });
      });

function abreVentana2(id,numerooc,id2,swb){
  miPopup = window.open("mp_updatearchivo.php?id="+id+"&numerooc="+numerooc+"&id2="+id2+"&swb="+swb,"miwin","width=500,height=200,scrollbars=yes,toolbar=0")
  miPopup.focus()
}
function abreVentana3(id,numerooc,id2,swb){
  miPopup = window.open("mp_subirarchivo.php?id="+id+"&numerooc="+numerooc+"&id2="+id2+"&swb="+swb,"miwin","width=500,height=200,scrollbars=yes,toolbar=0")
  miPopup.focus()
}


    </script>
  </head>
  <body>
    <div class="navbar-nav ">
      <div class="container">
        <div class="navbar-header">
          <?
          require("inc/top.php");
          ?>
        </div>
      </div>
    </div>



    <div class="container">
     <div class="row">
      <div class="col-sm-2 col-lg-2">
        <div class="dash-unit2">
          <?
          require("inc/menu_1.php");
          ?>
        </div>
      </div>
      <div class="col-sm-9 col-lg-9">
        <div class="dash-unit2">
          <table border="0" >
            <tr>
              <th colspan="2" scope="col"><span class="Estilo7"><?= utf8_decode('DERIVACIÓN A V°B°') ?></span></th>
            </tr>
            <tr>
             <td><hr></td>
             <td><hr></td>
           </tr>

           <?

           if (isset($_GET["llave"])){
             if ($_GET['llave'] == 1) {
              echo "<p> Datos guardados con " . utf8_decode('éxito') . " !</p>";
            }elseif ($_GET['llave'] == 2) {
              echo "<p> Problemas al actualizar datos !</p>"; 
            }
          }

          $id        = $_GET["id"];
          $id2       =$_GET["id2"];
          $id1b      =$_GET["id1b"];
          $nroorden2 =$_GET["nroorden2"];

          if ($id2<>'') {

            $sql5="select * from dpp_facturas x, dpp_etapas y where eta_id=$id1b and fac_eta_id=eta_id ";
           // $sql5="select * from  dpp_etapas where eta_id=$id1b ";

          } else {

            $sql5="select * from dpp_facturas x, dpp_etapas y where fac_id=$id and fac_eta_id=eta_id ";
          //  $sql5="select * from dpp_etapas where fac_id=$id  ";

          }

//echo $sql5;

          $res5 = mysql_query($sql5);

          $row5=mysql_fetch_array($res5);

//$archivo5=$row5["fac_"];

          $idetapa=$row5["eta_id"];

          $etaporroid=$row5["eta_prorro_id"];

          $etanumero=$row5["eta_numero"];

          $etarut=$row5["eta_rut"];

          $etavb=$row5["eta_fecha_aprobacionok"];


#Forma m�s amigable de permitir accesos a ciertas regiones o usuarios
$usuariosPermitidos = ["JVERGARAF","vlealm","VGUENEL","LHPINO","CASOTO"];
$cfPermitidos = [1,4,14,16,19,11,2,13,6,20,9,12,15,3,8,10,7,5,18,17];
//$cfPermitidos = [1,4,14,16,19,11,2,13,6,20,9,12,15,3,8,10,7,5,18];
#Pregunta si el CF del usuario est� dentro del listado del arreglo $cfPermitidos, mismo caso para el nombre de sesion de usuario
if(in_array($_SESSION['region'],$cfPermitidos) || in_array($_SESSION['nom_user'],$usuariosPermitidos) or 1==1){

#if ($usuario=='JVERGARAF' || $usuario=="CASOTO" || $usuario=="VGUENEL" || $usuario=="LHPINO" || $usuario=='vlealm' or $regionsession=='1' or $regionsession=='4' or $regionsession=='14' or $regionsession=='16' or $regionsession=='19' or $regionsession=='11') {

// --- INICIO para la cargar las firmas se deben enviar 2 parametros: 1 id del doc, 2 el estado de la firma en un campo propio de la tabla, 3 el doc. a firmar
$id1b=$row5["eta_id"];
$firmaestado=$row5["eta_firmaestado"];
$tipodoc=1;
$etafirmaestado=$row5["eta_firmaestado"];
$etanumero=$row5["eta_numero"];

#echo "ENTRA 1: ".$regionsession;
include("fir_cargafirmas.php");

//---- FIN carga firmas


}




          $sqlVerifyNC = "SELECT * FROM dpp_ncnd WHERE ncnd_eta_id IN(".$idetapa.") AND ncnd_tipo IN('NC') AND ncnd_estado IN(1)";
          $resVerifyNC = mysql_query($sqlVerifyNC);
          if(mysql_num_rows($resVerifyNC) > 0 or 1==1){
            $idE = $row5['eta_id'];
            #$sql55="SELECT sum(eta_monto) as eta_monto FROM dpp_etapas WHERE eta_rel_id = '$idE'";
            $sql55 =  "SELECT SUM(eta_monto) as eta_monto FROM dpp_ncnd a INNER JOIN dpp_etapas b ON b.eta_id = a.ncnd_eta_rel_id WHERE a.ncnd_eta_id IN(".$idetapa.") AND ncnd_tipo IN ('NC') AND ncnd_estado IN (1)";
  //echo $sql55;
            $result=mysql_fetch_array(mysql_query($sql55));  

            $monto = $row5["fac_monto"] - $result['eta_monto'];



          }else{
           $monto = number_format($row5["fac_monto"],0,',','.');
         }

//------------------------ Asociacion de facturas con contratos ---------------
         $fac_rut=$row5["fac_rut"];
         $fac_id=$row5["fac_id"];

         $sql21 = "Select * from dpp_contratos where cont_rut='$fac_rut' and cont_region='$regionsession'";
         
         $res21 = mysql_query($sql21);
         $row21 = mysql_fetch_array($res21);
         
         $cont_nombre=$row21["cont_nombre"];
         $cont_rut=$row21["cont_rut"];

         $sql22 = "Select * from dpp_cont_fac where confa_fac_id='$fac_id'";
                                   // echo $sql22; //exit();
         $res22 = mysql_query($sql22);
         $row22 = mysql_fetch_array($res22);
         $confa_fac_id=$row22["confa_fac_id"];
         $cont_id = $row22["confa_cont_id"];
         $sqlVb = "Select cont_vb, cont_pop from dpp_contratos where cont_id='$cont_id'";
         $resVb = mysql_query($sqlVb);
         $rowVb = mysql_fetch_array($resVb);
         $vb = $rowVb['cont_vb'];
         $pop = $rowVb['cont_pop'];
         $sw11=0;

         if ($confa_fac_id<>'')
          $sw11=1;
        if ($cont_nombre<>'' and $confa_fac_id=='')
          $sw11=2;
                                   //   echo $cont_nombre."<-";

//$etanumero=214;

//$etarut=76096016;



//echo "$etanumero $etarut <br>";

        $arrayDatos = array(
          "emisor_rut" => 13169658,
          "emisor_dv" => 2,
          "cesion_rut" => $row5["fac_rut"],
          "cesion_dv" => $row5["fac_dig"],
          "cesion_tipoDTE" => $arrayDocumentos[$row5["eta_tipo_doc2"]],
          "cesion_folio" => $row5["fac_numero"],
        );

        if ($nroorden2<>'') {

          $sql9="update compra_orden set oc_estado='RECEPCION CONFORME' where oc_eta_id ='$nroorden2' ";

//    echo $sql9;

          mysql_query($sql9);



        }





        ?>

        <tr>

         <td width="487" valign="top" class="Estilo1">

           <a href="valida2.php" class="link">VOLVER</a> /

           <a href="dpp_plantilla2.php?id=<? echo $id ?>&id1b=<? echo $id1b ?>" class="link">Asociar Plantilla</a> /
           <? if($sw11 == 1){ ?>
           <? };

           if ($etaporroid<>0) {

            ?>

            <a href="dpp_plantillaficha2.php?id=<? echo $id ?>&id1b=<? echo $id1b ?>&id2=<? echo $etaporroid ?>&ori=3" class="link">Plantilla Asociada</a>

            <?

          }

          ?>





          <br>

        </tr>

        <tr>

         <td><hr></td><td><hr></td>

       </tr>

       <tr>



        <tr>

         <td width="487" valign="top" class="Estilo1">

          <br>

        </tr>

        <tr>

         <td width="487" valign="top" class="Estilo1">
         </td>

       </tr>

     </table>

     <table width="100%" border="0" cellspacing="0" cellpadding="0">

       <form name="form22" action="cambiaestado.php" method="post"  onSubmit="return valida2()"  enctype="multipart/form-data">



         <tr>

           <td  valign="top" class="Estilo1"><?= utf8_decode('Acción') ?></td>

           <td class="Estilo1" colspan=3>

             <select name="accion" class="Estilo1" onchange="muestra();">

              <?

              if ($regionsession==15 and 1==2){

                ?>

                <option value='2' <? if ($row5["eta_estado"]==2) echo "selected=selected";  ?> >1.- <?= utf8_decode('Derivación A V°B°') ?> </option>

                <option value='1' <? if ($row5["eta_estado"]==1) echo "selected=selected";  ?> >2.- Volver a <?= utf8_decode('recepción') ?></option>

                <?

              }

              // if ($regionsession<>15 or 1==1) {

                ?>

                <option value="">Seleccione...  </option>

                <? if($APRO_ESTADO == 0 and 1==2): ?>
                  <option value='5' <? if ($row5["eta_estado"]==4) echo "selected=selected";  ?>>1.- Enviar a: "CONTABILIDAD"</option>
                  <? else: ?>
                    <option value='4' <? if ($row5["eta_estado"]==4) echo "selected=selected";  ?>>1.- Enviar a: "Enviar a Modulo de Contabilidad"</option>
                  <? endif; ?>


                  <option value='1' <? if ($row5["eta_estado"]==1) echo "selected=selected";  ?> >2.- Volver a <?= utf8_decode('recepción') ?></option>
                  <option value="3" <?php if($row5["eta_tipo_doc2"] <> "f" && $row5["eta_tipo_doc2"] <> "fa"){echo"disabled";} ?> >3.- Reclamar/Aceptar Factura S.I.I.</option>
                  <option value="6">4.- Derivar Documento</option>
                  <option value="7">5.- Cerrar Facturas Fondo Fijo</option>
                  <option value='99'>6.- Eliminar Documento</option>

                  <?

                // }

                ?>

              </select>

            </td>

          </tr>

          <tr id="fiscalias">
            <td class="Estilo1"><?= utf8_decode('Fiscalía') ?> destino</td>
            <td>
              <select name="fiscaliaDestino" id="fiscaliaDestino" class="Estilo1">
                <option value="">Seleccionar...</option>
                <?php foreach($arrayFiscalias as $key => $value): ?>
                  <option value="<?php echo $value["codigo"] ?>" <?php if($_SESSION["region"] == $value["codigo"]){echo"selected";} ?> ><?php echo $value["nombre"] ?></option>
                <?php endforeach ?>
                
              </select>
            </td>
          </tr>

          <?

          if ($regionsession<>15 or 1==1) {



           if  ($row5["eta_fecha_aprobacionok"]=='0000-00-00') {

    //    $fecha6=$fechamia2;
            $fecha6 = date("d-m-Y");

          } else {

            $fecha6=substr($row5["eta_fecha_aprobacionok"],8,2)."-".substr($row5["eta_fecha_aprobacionok"],5,2)."-".substr($row5["eta_fecha_aprobacionok"],0,4);

          }

          ?>

          <tr>


           <td  valign="top" class="Estilo1">Fecha <?= utf8_decode('derivación') ?> </td>

           <td class="Estilo1" valign="center">

             <input type="text" name="fechavb" class="Estilo2" size="12" value="<? echo $fecha6 ?>" id="f_date_c1" readonly="1">

             <img src="calendario.gif" id="f_trigger_c1" style="cursor: pointer; border: 1px solid red;" title="Date selector"

             onmouseover="this.style.background='red';" onMouseOut="this.style.background=''" />





    <script type="text/javascript">//<![CDATA[

    Calendar.setup({

      inputField : "f_date_c1",

      trigger    : "f_trigger_c1",

      onSelect   : function() { this.hide() },

      showTime   : 12,

      dateFormat : "%d-%m-%Y"

    });

    //]]></script>









    <?

  }

  ?>

</td>

</tr>

<?
$codigo2 = explode("|", $resultado);
$codigo3 =$codigo2[1];

if ($resultado2<>'') {
 ?>
 <a href="javascript:void(0)" onclick="window.open('listaperitaje.php?rut=<? echo $etarut; ?>&id=<? echo $id; ?>&id1b=<? echo $id1b ?>','','width=700,height=600,scrollbars=1,location=1')"></a>
 <?
}
$codigo22 = explode("|", $resultado2);

?>
<tr>
  <td>
  </td>
</tr>
<?

$a0=$row5["eta_estado"];


$a1=$row5["fac_servicio"];


$a2=$row5["fac_archivoval"];
$a3=$row5["fac_archivo"];



if ($a3<>"" )   {
  ?>

  <tr>
   <td  valign="top" class="Estilo1" colspan=4>
     <input type="submit" class="btn btn-success" value="Grabar <?= utf8_decode('Acción') ?> " >
   </td>
 </tr>

 <div id="seccion1" style="display:none">
  <input type="submit" class="btn btn-success" value="Grabar <?= utf8_decode('Acción') ?> " >
</div>

<?
} else {
  ?>
  <tr>
   <td  valign="top" class="Estilo1" colspan=4>
     <div id="seccion1" style="display:none">
      <input type="submit" class="Estilo2" value="Grabar <?= utf8_decode('Acción') ?> 2" >
    </div>
  </td>
</tr>
<?
}
?>
<tr>
 <td  valign="center" class="Estilo1" colspan=8><hr></td>
</tr>
<input type="hidden" name="id" value="<? echo $id  ?>">
<input type="hidden" name="id2" value="<? echo $row5["eta_id"];  ?>">
</form>
</table>
<?

if (($usuario=='JVERGARAF' or $usuario=='vlealm') and 1==1)  {
?>    
<table>
  <tr>
    <td>
        <a href="bienestar_grabaenvio.php?id=<?= $id ?>&id1b=<?= $id1b ?>"  class="btn btn-success"  onClick="return confirm('Seguro que desea enviar?')">  Enviar a Bienestar</a>
    </td>

  </tr>
</table>
<?
}


if ($usuario=='bienestar' and 1==1)  {
?>    
<table>
  <tr>
    <td>
        <a href="bienestar_grabapago.php?id=<?= $id ?>&id1b=<?= $id1b ?>"  class="btn btn-success"  onClick="return confirm('Seguro que desea Pagar?')">  Dejar Documento Pagado</a>
    </td>
    
  </tr>
</table>
<?
}
?>

<br>

<?
#Forma m�s amigable de permitir accesos a ciertas regiones o usuarios
$usuariosPermitidos = ["JVERGARAF","vlealm","VGUENEL","LHPINO","CASOTO"];
//$cfPermitidos = [1,2,4,14,16,19,11,2,13,6,20,9,12,15,3,8,10,7,5];
$cfPermitidos = [1,4,14,16,19,11,2,13,6,20,9,12,15,3,8,10,7,5,18,17];
#Pregunta si el CF del usuario est� dentro del listado del arreglo $cfPermitidos, mismo caso para el nombre de sesion de usuario
if(in_array($_SESSION['region'],$cfPermitidos) || in_array($_SESSION['nom_user'],$usuariosPermitidos) or 1==1){
    #if ($usuario=='JVERGARAF' || $usuario=="CASOTO" || $usuario=="VGUENEL" || $usuario=="LHPINO" || $usuario=="vlealm" or $regionsession=='1' or $regionsession=='4' or $regionsession=='14' or $regionsession=='16' or $regionsession=='19' or $regionsession=='11' )  {
  $regionfirmas=$row5["eta_region"];
        include("fir_firmas.php");
    }

  ?>
<table width="100%">

<form id="form1" name="form1" action="grabafacturaarchivo.php" method="post"  enctype="multipart/form-data"  onSubmit="return valida()">
  <input type="hidden" name="id2" value="<? echo $row5["eta_id"];  ?>">
  <?

  $facfolio=$row5["eta_id"];

  if ($row5["eta_rechaza_motivo2"]<>"") {

    ?>

    <tr>

     <td  align="center" class="Estilo1c" colspan="4"><a href="grabaaceptarechazo2.php?id=<? echo $row5["eta_id"] ?>" class="link">ACEPTA RECHAZO</a> <br></td>

   </tr>

   <tr>

     <td  align="center" class="Estilo1c" colspan="4"><? echo $row5["eta_rechaza_motivo2"] ?> <br></td>

   </tr>

   <?

 }

// do{
 if($row5["eta_tipo_doc2"] == "f" || $row5["eta_tipo_doc2"] == "fa"):
 $consultarFechaRecepcionSii = $objDTEWs->consultarFechaRecepcionSii($arrayDatos);
endif;
//}while(!$consultarFechaRecepcionSii["Respuesta"]);

$fechaSII = date("d-m-Y",strtotime($consultarFechaRecepcionSii["Mensaje"]));
$fechaRecep = substr($row5["fac_fecha_recepcion"],8,2)."-".substr($row5["fac_fecha_recepcion"],5,2)."-".substr($row5["fac_fecha_recepcion"],0,4);
// echo $fechaSII.":".$fechaRecep;
// echo "<br>Respuesta : ".strcasecmp($fechaSII, $fechaRecep);
if(strcasecmp($fechaSII, $fechaRecep) <> 0)
{
  // echo "Actualizar...<br>";
  $sqlUpdateDate = "UPDATE dpp_etapas SET eta_fecha_recepcion = '".date("Y-m-d",strtotime($consultarFechaRecepcionSii["Mensaje"]))."' WHERE eta_id = '".$id1b."'";
  $sqlUpdateDate2 = "UPDATE dpp_facturas SET fac_fecha_recepcion = '".date("Y-m-d",strtotime($consultarFechaRecepcionSii["Mensaje"]))."' WHERE fac_eta_id = '".$id1b."'";
   //echo $sqlUpdateDate2;
  // echo "<br>".$sqlUpdateDate;
  if(date("Y",strtotime($consultarFechaRecepcionSii["Mensaje"])) >= 2019)
  {
    mysql_query($sqlUpdateDate,$dbh);
    mysql_query($sqlUpdateDate2,$dbh);
  }
}
  
?>


</table>

<table width="100%">
<tr>

 <td  valign="center" class="Estilo1">FOLIO.</td>

 <td class="Estilo1" colspan=3><? echo $row5["fac_folio"]; ?>

</td>

</tr>



<tr>

 <td  valign="center" class="Estilo1">Fecha <?= utf8_decode('recepción') ?></td>

 <td class="Estilo1" valign="center">

  <?

  $a=$row5["fac_fecha_recepcion"];

                                     //echo $a."-";

  echo substr($a,8,2)."-".substr($a,5,2)."-".substr($a,0,4);



  ?>







</td>

</tr>

<tr>

 <td  valign="center" class="Estilo1">Fecha <?= utf8_decode('recepción') ?> S.I.I.</td>

 <td class="Estilo1" valign="center">

  <?
  echo date("d-m-Y H:i:s",strtotime($consultarFechaRecepcionSii["Mensaje"]));


  ?>







</td>

</tr>

<tr>

 <td  valign="center" class="Estilo1">Estado S.I.I.</td>

 <td class="Estilo1" valign="center">

  <?
  if(strlen($row5["eta_nroresolucion"]) == 3)
  {
    $arrayReclamos = [
      "ACD" => "Acepta Contenido del Documento",
      "RCD" => "Reclamo al Contenido del Documento",
      "ERM" => "Otorga Recibo de " . utf8_decode('Mercaderías') . " o Servicios",
      "RFP" => "Reclamo por Falta Parcial de " . utf8_decode('Mercaderías') . "",
      "RFT" => "Reclamo por Falta Total de " . utf8_decode('Mercaderías') . "",
    ];
    $mensaje = $arrayReclamos[$row5["eta_nroresolucion"]];
  }else{
    $mensaje = "SIN RECLAMO";
  }
  echo $mensaje;



  ?>







</td>

</tr>

<tr>
 <td  valign="center" class="Estilo1">Fecha Factura</td>
 <td class="Estilo1">
  <?
  $a=$row5["fac_fecha_fac"];
  echo substr($a,8,2)."-".substr($a,5,2)."-".substr($a,0,4);
  ?>
</td>
</tr>
<tr>

 <td  valign="center" class="Estilo1">Regi&oacute;n</td>

 <td class="Estilo1">

   <?

   $region=$row5["eta_region"];

   $sql2 = "Select * from regiones where codigo='$region'";

                                    //echo $sql;

   $res2 = mysql_query($sql2);

   $row2 = mysql_fetch_array($res2);

   $region2=$row2["nombre"];

   echo $region2;



   ?>







 </td>

</tr>



<tr>

 <td  valign="center" class="Estilo1">Rut Proveedor </td>

 <td class="Estilo1" colspan=3><? echo $row5["fac_rut"]."-".$row5["fac_dig"]; ?>

</td>

</tr>



<tr>

 <td  valign="center" class="Estilo1">Nombre Proveedor </td>

 <td class="Estilo1" colspan=3><? echo $row5["fac_cli_nombre"] ?>

</td>

</tr>

<tr>

 <td  valign="center" class="Estilo1"><?= utf8_decode('N°') ?> Factura </td>

 <td class="Estilo1" colspan=3><? echo $row5["fac_numero"] ?>



</td>

</tr>

<td  valign="center" class="Estilo1">Monto Factura </td>

<td class="Estilo1" colspan=3>$<? echo number_format($row5["fac_monto"],0,',','.'); ?>



</td>

</tr>





<tr>

 <td colspan=6><br></td>

</tr>



<tr>

 <td colspan=6>

  <table border=1 width="100%" class="table table-striped table-bordered">

   <tr>









    <?
    
    if ($sw11==2) {
      ?>

      <tr>

       <td  valign="center" class="Estilo1" width="50%"><a href="buscarcontratos.php?rut=<? echo $cont_rut ?>&numfac=<? echo $id ?>&id1b=<? echo $id1b ?>&ori2=f&monto=<? echo $row5["fac_monto"] ?>" class="link" >Asociar Contrato</a> </td>





       <?

     }



     if ($sw11==1) {


      ?>

      <tr>

       <td  valign="center" class="Estilo1" width="50%">
         Ya Asociada a Contrato &nbsp;&nbsp;&nbsp;<a href="descontrato.php?rut=<? echo $cont_rut ?>&numfac=<? echo $id ?>&id1b=<? echo $id1b ?>&ori2=f&monto=<? echo $row5["fac_monto"] ?>" class="link" onclick="return confirm('Seguro Desasociar el Contrato ?')" title="Desasociar"><img src="imagenes/b_drop.png" border=0>.</a>
         <br>
         <a href="contrato_hitosparafichapago.php?id=<? echo $cont_id ?>&id1b=<?= $row5["fac_eta_id"] ?>" class="link" target="_blank">Generar Ficha de Pago</a>
       </td>



       <?

     }

     

//------------------------ Asociacion de Facturas con O/C ---------------

     $fac_rut=$row5["fac_rut"];

     $fac_id=$row5["fac_id"];

     $sw2=2;

     $sql21 = "Select * from compra_orden where oc_rut='$fac_rut' and (oc_estado='ACEPTADO' or oc_estado='ENVIADA' ) and oc_region='$regionsession' ";

//                                   echo $sql21;

     $res21 = mysql_query($sql21);

     $row21 = mysql_fetch_array($res21);

     $ocid=$row21["oc_id"];

     

     $sql22 = "select * from compra_oceta where oceta_eta_id='$id1b'  ";

//                                   echo $sql21;

     $res22 = mysql_query($sql22);

     $row22 = mysql_fetch_array($res22);

     $oceta_eta_id=$row22["oceta_eta_id"];



     

     $sw2=0;

     if ($ocid<>'')

      $sw2=1;



    if ($row5["eta_nroorden"]<>'' and $oceta_eta_id<>'')

      $sw2=2;



    if ($sw2==1 and $row5["eta_nroorden"]=='' or $oceta_eta_id=='') {



      ?>





      <td  valign="center" class="Estilo1" width="50%">
       <a href="buscarordencompra.php?rut=<? echo $fac_rut ?>&numfac=<? echo $id ?>&id1b=<? echo $id1b ?>&ori2=f&monto=<? echo $row5["fac_monto"] ?>" class="link" >ASOCIAR ORDEN DE COMPRA</a>

     </td>

     

     





     <?

   }



   if ($sw2==2) {

    $facnroorden=$row5["fac_nroorden"];

    $sql21b = "Select * from compra_orden where oc_numero='$facnroorden' and oc_region='$regionsession' ";

//                                      echo $sql21b;

    $res21b = mysql_query($sql21b);

    $row21b = mysql_fetch_array($res21b);

    $ocestado=$row21b["oc_estado"];

    $sw3=0;

    if ($ocestado=='RECEPCION CONFORME' ) {

      $sw3=1;

    }
    ?>
    <td  valign="center" class="Estilo1" width="50%">Ya Asociada a Orden Compra&nbsp;&nbsp;&nbsp;<a href="desordencompra.php?rut=<? echo $cont_rut ?>&numfac=<? echo $id ?>&id1b=<? echo $id1b ?>&ori2=f&monto=<? echo $row5["fac_monto"] ?>" class="link" onclick="return confirm('Seguro Desasociar la Orden Compra ?')" title="Desasociar"><img src="imagenes/b_drop.png" border=0></a>
     <br>
     <a href="compra_vb.php?prov=<? echo $etarut ?>&idDoc=<?=$_GET["id1b"]?>" class="link" target="_blank">Solicitar <?= utf8_decode('V°B°') ?></a>
   </td>
   <?

 }





 if ($resultado2<>'' ):

   ?>

   <td  valign="center" class="Estilo1" width="50%" >

    <a href="javascript:void(0)" onclick="window.open('listaperitaje.php?rut=<? echo $etarut; ?>&id=<? echo $id; ?>&id1b=<? echo $id1b ?>','','width=700,height=600,scrollbars=1,location=1')"   class="link">Lista de Peritaje</a>

  </td>

  <?

endif;
;
?>
</tr>
</table>
</td>
</tr>
<tr>

 <td colspan=6><br></td>

</tr>
</table>
<table border=1 width="100%" class="table table-striped table-bordered">


  <? if(($sw == 0) and ($sw2 == 2)){ ?>
    <tr>
      <td>Favor revisar si esta OC/OP requiere <?= utf8_decode('V°B°') ?></td>
    </tr>
  <? }?>
  <tr>
   <td  valign="center" class="Estilo1">Total a Pagar </td>
   <td class="Estilo1" colspan=3>
    $ <input type="text" id="monto" name="monto" class="Estilo2" size="15" value="<? echo $monto ?>" disabled="disabled"  >
  </td>
</tr>
<?          if ($sw==1 or 1==1) :
             //        echo $row5['fac_pop'];
  ?>
<!--
                <tr>
                  <td colspan="1">  <? if ($pop == "SI"  ){ echo "<h5>¡Factura Con Indicador POP!</h5> <input type='hidden' name='pop' value='SI'/>";}else{
                                    if($row5['fac_pop'] == 'SI'){
                                      echo "<h4>Marcar como Indicador POP</h4><input type='checkbox' name='pop' id='pop' value='SI' checked ><b id='popR' style='font-size : 14px'>SI</b>";
                                    }else{
                                      echo "<h4>Marcar como Indicador POP</h4><input type='checkbox' name='pop' id='pop' value='SI' ><b id='popR' style='font-size : 14px'>NO</b>";
                                    }
                                    
                                } ?>
                  </td>
                  <td colspan="3">
                      
                  </td>
                </tr>
                !-->

                <tr>
                  <input type="hidden" name="facid" value="<?=$row5['fac_id'];?>"/>
                  <td class="Estilo1" colspan="6">
                    <?
/*
  $sql23 = "SELECT  proye_id,proye_estado, proye_monto, proye_comp, proye_ncuota, proye_desc,sum(fahi_monto) as comprometido, fahi_estado, fahi_fact_id
            FROM contrato_proyecta LEFT JOIN factura_hitos ON fahi_proye_id = proye_id AND fahi_fact_id = ".$row5['fac_id']."
            WHERE fahi_fact_id = ".$row5['fac_id']."
           OR  proye_cont_id = ".$cont_id."  group by proye_ncuota, proye_id ";
  
*/
 
           $sql23 = "SELECT proye_id, proye_estado, proye_monto, proye_comp, proye_ncuota, proye_desc
           FROM contrato_proyecta where proye_cont_id =$cont_id
           GROUP BY proye_ncuota, proye_id
           ";
           
     //  echo $sql23;
      // exit();
           $res23 = mysql_query($sql23);

           if($res23):
            ?>
            <!-- Despliegue de hitos asociados a una factura  -->
            <div class="row">
              <div class="col-md-11" style="margin-left: 5%">
                <div class="panel-group" id="accordion">
                  <div class="panel panel-default">
                    <div class="panel-heading">
                      <h5 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" id="refcollapseOne" href="javascript:void(0)" class="btn btn-info btn-sm">
                          Hitos
                        </a>
                      </h5>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse">
                      <div class="panel-body">
                        <table class="table table-bordered table-hover">
                          <thead>
                            <th class="Estilo1">Cuota</th>
                            <th class="Estilo1">Proyectado </th>
                            <!--th class="Estilo1">Ejecutado </th-->
                            <th class="Estilo1">Comprometido</th>
                            <th class="Estilo1">Disponible</th>
                            <th class="Estilo1">Asignado a esta factura</th>
                            <th class="Estilo1" colspan="3"><?= utf8_decode('Acción') ?></th>
                          </thead>
                          <tbody>
                            <?php 
                            while($row23 = mysql_fetch_array($res23)): 
                              $proyeid=$row23['proye_id'];
                              
                              $sql23b = "select SUM( fahi_monto ) AS comprometido, fahi_estado, fahi_fact_id from  factura_hitos where fahi_proye_id = $proyeid
                              AND fahi_fact_id ='".$row5['fac_id']."'; ";
      //  echo $sql23b."<br>";
                              $res23b = mysql_query($sql23b);
                              $row23b = mysql_fetch_array($res23b);


                              ?>
                              <tr>
                                <td class="Estilo1"><?=$row23['proye_ncuota']?></td>
                                <td class="Estilo1"><?=number_format($row23['proye_monto'],0,',','.');?></td>
                                <!--td class="Estilo1"><?//=number_format($row23['proye_ejec'],0,',','.');?></td -->
                                <td class="Estilo1"><a href="#" class=" link" onClick="verAsociadas(<?=$row23['proye_id']?>)" id="" ><?=number_format($row23['proye_comp'],0,',','.');?></td>
                                  <?php $disponible = $row23['proye_monto'] - $row23['proye_comp'] ; ?>
                                  <td class="Estilo1"><?=number_format($disponible,0,',','.');?></td>
                                  <td class="Estilo1">
                                    <?=number_format($row23b['comprometido'],0,',','.');?>
                                    <td colspan="2">
                                      <?php if($row23['proye_estado'] == 1): ?>
                                        <?php if ($row23b['comprometido'] > 0 ): ?>
                                          <a class="link2" href="factura_desasociarhito.php?h=<?=$row23['proye_id']?>&fac=<?=$row23b['fahi_fact_id']?>&eta=<?=$id1b?>">Desasociar</a>
                                        <?php endif; ?>
                                        <button  onClick="asociarDistribucion(<?=$row23['proye_id']?>,<?=$id?>,'<?=$monto?>',<?=$id1b?>)"  id="" style="font-size: 9px !important: width:50px !important; height: 25px;" type="button">Asociar</button>
                                      <?php endif; ?>
                                      
                                    </td>
                                    <?php if($row23['proye_estado'] == 1 ): ?>
                                      <td><a onclick="cerrar_hito('contrato_editarproyeccion.php?id=<?=$row23['proye_id']?>&fact=<?=$id?>&accion=c&id1b=<?=$id1b?>')"><button  type="button" class="cerrar" style="font-size: 9px !important: width:40px !important; height: 25px;">Cerrar</button></a></td>
                                      <?php elseif($row23['proye_estado'] == 3): ?>
                                        <td><a href="contrato_editarproyeccion.php?id=<?=$row23['proye_id']?>&fact=<?=$id?>&accion=a&id1b=<?=$id1b?>" ><button  type="button" class="cerrar" style="font-size: 9px !important: width:40px !important; height: 25px;">Reabrir</button></a></td> 
                                      <?php endif; ?> 
                                    </tr>
                                  <?php  endwhile; ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- fin hitos --> 
                </td>
              </tr>
              <?
            endif;//If Hitos
          endif;


          $etaitem=$row5["eta_item"];

          #Forma m�s amigable de permitir accesos a ciertas regiones o usuarios
          $usuariosPermitidos = ["JVERGARAF","vlealm","VGUENEL","VGUENEL","LHPINO"];
         // $cfPermitidos = [1,4,14,16,19,11];
         // $cfPermitidos = [1,4,14,16,19,11,2,13,6,20,9,12,15,3,5];
          $cfPermitidos = [1,4,14,16,19,11,2,13,6,20,9,12,15,3,8,10,7,5,18,17];

          if ($regionsession==15 or 1==1) {
            #Pregunta si el CF del usuario est� dentro del listado del arreglo $cfPermitidos, mismo caso para el nombre de sesion de usuario
            if(in_array($_SESSION['region'],$cfPermitidos) || in_array($_SESSION['nom_user'],$usuariosPermitidos) or 1==1){
            #if ($usuario=='JVERGARAF' || $usuario=='vlealm' || $usuario=='LHPINO' or $regionsession=='1' or $regionsession=='4' or $regionsession=='14' or $regionsession=='16' or $regionsession=='19' or $regionsession=='11' || $usuario == "VGUENEL") {

            ?>


            <tr> 
              <td colspan="2">

                              <table class="table table-bordered">
                                <tr>
                                  <td colspan="4">  <a href="#" class="link" onclick='abreVentana3("<? echo $id1b ?>","2","<? echo $id ?>","<? echo $swb ?>" )' >Subir Archivo</a></td>
                                 </tr>  
<?

$sql27="Select distinct arch_eta_id, arch_etiqueta, arch_ruta, arch_archivo, arch_origen, arch_user, arch_fechasys, arch_estado, arch_id from dpp_archivo where arch_eta_id=$idetapa and arch_origen not in(12,7,6,2,3,10,11,9) order by arch_origen";
   //  echo "---->".$sql27;
     $sql27=mysql_query($sql27);
     while ($row27 = mysql_fetch_array($sql27)) {
   ?>

     <tr>
       <td class="Estilo1"> <? echo $row27["arch_etiqueta"] ?></td>
       <td><a href="../../<? echo $row27["arch_ruta"]; ?>/<? echo $row27["arch_archivo"]; ?>?read2=<? echo $read3 ?>" class="link" target="_blank"><? echo $row27["arch_archivo"]; ?> </a></td>

<td class="Estilo1">

        <a href="#" class="link" onclick='abreVentana2("<? echo $id1b ?>","2","<? echo $id ?>","<? echo $row27["arch_id"]; ?>" )' >Subir Archivo</a>
      
</td>
<?
if(in_array($_SESSION['region'],$cfPermitidos) || in_array($_SESSION['nom_user'],$usuariosPermitidos)){
 //if ($row27["arch_origen"]==8 && $usuario=="JVERGARAF" && $row27["arch_ruta"] <> "") {
?>
        <!--

             <a href="#" class="link" onclick='abreVentana2("<? echo $id1b ?>","2","<? echo $id ?>","<? echo $swb ?>" )' >Subir Archivo</a>
              -->
       <td class="Estilo1"> <a href="borradocs3.php?id=<? echo $id ?>&id1b=<? echo $id1b ?>&doc=1&id2=<? echo $row27["arch_id"]; ?>" class="link" onclick="return confirm('Seguro Desasociar Borrar el Archivo ?')" title="Borrar"><img src="imagenes/b_drop.png" border=0></a></td>

   <?
 }
   ?>    
    
    <tr>

<?
}
?>

                              </table>
                             </td> 

            </tr>  

<?
}


?>
            <tr>

             <td  valign="center" class="Estilo1">Orden de compra asociadas </td>

             <td class="Estilo1" colspan=3>

               <table border=1 class="table table-bordered">

                <?

                $sql7="select * from compra_orden inner join compra_oceta  on oc_id= oceta_oc_id where oceta_eta_id = '$id1b'";
             // echo $sql7;


                $res7 = mysql_query($sql7);

                $cont11=1;

                while($row7 = mysql_fetch_array($res7)){

                 if ($cont11==1 or $cont11==4 or $cont11==7 or $cont11==10 or $cont11==13 or $cont11==16 ) {

                   echo "<tr>";

                 }

                 ?>



                 <td>
                   <?php $anhoCompra  = substr($row7['oc_fechasis'],0,-6);
                   $ac2 = explode("_", $row7["oc_archivo"]);
                   $anhoCompra2 = substr($ac2[2],0,4);
                   $sqlAdq = "SELECT * FROM soli_solicitud WHERE soli_oc_browse IN ('".$row7["oc_numero"]."') AND soli_estado IN (9,10) AND soli_region IN (".$_SESSION["region"].")";
                   $resAdq = mysql_query($sqlAdq);
                   ?>
                   <?php if(mysql_num_rows($resAdq) ==  1):?>
                    <?php
                    $rowAdq = mysql_fetch_array($resAdq);
                    #Obtnemos la Oc Firmada de Adquisiciones
                    $sqlFirmada = "SELECT * FROM soli_archivo WHERE arch_origen IN (8) AND arch_etiqueta IN ('OC BROWSE') AND arch_eta_id IN (".$rowAdq["soli_id"].")";
                    $resFirmada = mysql_query($sqlFirmada);
                    $rowFirmada = mysql_fetch_array($resFirmada);
                    ?>

                    <a href='<?=$rowFirmada["arch_ruta"]?>/<?=$rowFirmada["arch_archivo"]?>' target="_blank"><?=$row7["oc_numero"]?></a> <a href='javascript:void(0)' onclick='verSolicitud(<?=$row7["oc_numero"]?>)'><i class='fa fa-eye'></i></a><br>
                   <?php else: ?>

                   <a href='../../archivos/docfac/doc<?=$anhoCompra2?>/ocompra/<?=$row7["oc_archivo"]?>' class="link" target="_blank"><? echo $row7["oc_numero"]; ?></a><br>
                   <?php endif ?>

                 </td>



                 

                 <?

                 $cont11++;

               }

               echo "</table>";

             }


/*
             $sql8="select * from argedo_documentos where docs_id=".$row5["fac_docs_id"];

//echo $sql8;

             $res8 = mysql_query($sql8);

             $row8 = mysql_fetch_array($res8);

             $docsfecha=$row8["docs_fecha"];

             if ($row8["docs_archivo"]<>'') {

              $docsarchivo="../../archivos/docargedo/".$row8["docs_archivo"];

            }
            */

            $mod=$row5["fac_modalidad"];
// echo "<pre>";
// print_r($row5);
// echo "</pre>";
            ?>
            <tr>
             <td  valign="center" class="Estilo1"><font color="#FF0000">* </font>Imagen de Factura </td>
             <td class="Estilo1" colspan=3>
              <?php if (strlen($row5["fac_usu_recepcion"]) > 0 or 1==1): ?>
                <input type="file" name="archivo1" class="Estilo2" size="20"  > <br>
              <?php endif ?>
              <a href="../../archivos/docfac/<? echo $row5["fac_archivo"]; ?>?read1=<? echo $read1 ?>" class="link" target="_blank"><? echo $row5["fac_archivo"]; ?></a>
              <input type="hidden" name="archivo111" value="<? echo $row5["fac_archivo"]; ?>"  >

              <?

              if ($row5["fac_archivo"]<>'' && strlen($row5["fac_usu_recepcion"]) > 0 ) {

                ?>

                <a href="borradocs.php?id=<? echo $id ?>&id1b=<? echo $id1b ?>&doc=1" class="link" onclick="return confirm('Seguro Desasociar Borrar el Archivo ?')" title="Borrar"><img src="imagenes/b_drop.png" border=0></a>

                <?

              }

              ?>

            </td>

          </tr>



          <tr>
           <td  valign="center" class="Estilo1"><font color="#FF0000"></font><?= utf8_decode('Cesión') ?> de Factura </td>
           <td class="Estilo1" colspan=3>
            <?
            
// do{
            if($row5["eta_tipo_doc2"] == "f" || $row5["eta_tipo_doc2"] == "fa"):

            #Si es factura ingresada manualmente no se muestra estado de cesi�n a�n siendo un documento v�lido
            if($row5["eta_folio"] <> 0 && $row5["eta_usu_recepcion2"] <> ''):
              echo "<span class='label label-danger'>INFORMACION NO " . utf8_decode('VÁLIDA') . " PARA ESTE DOCUMENTO</span>";
            else:

            $data = $objDTEWs->consultaEstCesion($arrayDatos);
            $estCesion = 0;
            if($data["Mensaje"] == "Documento Cedido")
            {
              $estCesion = 1;
            }
            $sqlCesion = "UPDATE dpp_etapas SET eta_peritaje = '".$estCesion."' WHERE eta_id = '".$id1b."'";
            mysql_query($sqlCesion);
            
            if($data["Mensaje"] == "Documento Cedido")
            {
              echo "<span class='label label-danger'>DOCUMENTO CEDIDO</span>";
            }

            if($data["Mensaje"] == "Service Unavailable")
            {
              echo "<span class='label label-danger'>SERVICIO NO DISPONIBLE</span>";
            }

            if($data["Mensaje"] == "Documento no ha sido cedido")
            {
               echo "<span class='label label-success'>DOCUMENTO NO HA SIDO CEDIDO</span>"; 
            }
            
          endif;

        endif;
// }while(!$data["Respuesta"]);

            echo "<a href='facturasarchivos.php?id=".$_REQUEST["id"]."&id1b=".$_REQUEST["id1b"]."'><span class='label label-warning'>Refrescar <i class='fa fa-refresh fa-lg'></i></span></a>";
              ?>
                <a href="javascript:void(0)" onclick="window.open('sii_cesion.php?rutCompany=<?php echo $row5["fac_rut"] ?>&dvCompany=<?php echo $row5["fac_dig"] ?>&&tipoDTE=<?php echo $row5["eta_tipo_doc2"] ?>&folioDTE=<?php echo $row5["fac_numero"] ?>&fechaDTE=<?php echo date("dmY",strtotime($row5["fac_fecha_fac"])) ?>&montoDTE=<?php echo $row5["fac_monto"] ?>','Verifica Documento S.I.I.','height=400,width=800')"><span class="label label-info">Consultar S.I.I.</span></a><br>
                <?

                if ($row5["fac_cesion"]<>'') {
                  ?>

                  <a href="../../archivos/docfac/<? echo $row5["fac_cesion"] ?>?read4=<? echo $read4 ?>" class="link" target="_blank"><? echo $row5["fac_cesion"]; ?></a>
                  <a href="borradocs2.php?id=<? echo $id ?>&id1b=<? echo $id1b ?>&ant=6" class="link" onclick="return confirm('Seguro Desasociar Borrar el Archivo ?')" title="Borrar"><img src="imagenes/b_drop.png" border=0></a> 
                  <br>
                </td>
              </tr>
              <?
            }else{
              ?>
              <input type="file" name="ant6" class="Estilo2" size="20"  > 
              <?
            }



            $verfac='';
            $nuevo=$row5["fac_doc2"];
//echo $nuevo;

            if ($nuevo<>'') {
             $buscar='archivos/docargedo/fileargedo';
             $pos = strpos($nuevo,$buscar );
             if ($pos !== FALSE) {





             }  else {

               $nuevo="../../archivos/docfac/".$row5["fac_doc2"];



             }

             

             $verfac="Ver " . utf8_decode('resolución') . "";

           }





           ?>
           <tr>
             <td  valign="center" class="Estilo1"> Subir <?= utf8_decode('validación') ?> SII </td>
             <td class="Estilo1" colspan=3>
              <?
              if ($row5["fac_archivoval"]<>'') {
                ?>
                <a href="../../archivos/docfac/<? echo $row5["fac_archivoval"]; ?>?read1=<? echo $read1 ?>" class="link" target="_blank"><? echo $row5["fac_archivoval"]; ?></a>

                <a href="borradocs2.php?id=<? echo $id ?>&id1b=<? echo $id1b ?>&ant=1" class="link" onclick="return confirm('Seguro Desasociar Borrar el Archivo ?')" title="Borrar"><img src="imagenes/b_drop.png" border=0></a> 
                <br>
              </td>
            </tr>
            <?
          }else{
            ?>
            <input type="file" name="ant1" class="Estilo2" size="20">
            <?php if ($row5["eta_tipo_doc2"] == "f" || $row5["eta_tipo_doc2"] == "fa"): ?>
              <br><a href="javascript:void(0)" onclick="window.open('verifica_sii.php?rutCompany=<?php echo $row5["fac_rut"] ?>&dvCompany=<?php echo $row5["fac_dig"] ?>&&tipoDTE=<?php echo $row5["eta_tipo_doc2"] ?>&folioDTE=<?php echo $row5["fac_numero"] ?>&fechaDTE=<?php echo date("dmY",strtotime($row5["fac_fecha_fac"])) ?>&montoDTE=<?php echo $row5["fac_monto"] ?>','Verifica Documento S.I.I.','height=400,width=800')"><span class="label label-info">CONSULTAR S.I.I.</span></a>
            <?php endif ?>
            <?
          }
          ?>

          <tr>
           <td  valign="center" class="Estilo1"><font color="#FF0000"></font> Subir Correo de <?= utf8_decode('aprobación') ?></td>
           <td class="Estilo1" colspan=3>
            <?
            if ($row5["fac_mail1"]<>''){
              ?>
              <a href="../../archivos/docfac/<? echo $row5["fac_mail1"]; ?>?read1=<? echo $read1 ?>" class="link" target="_blank"><? echo $row5["fac_mail1"]; ?></a>
              <a href="borradocs2.php?id=<? echo $id ?>&id1b=<? echo $id1b ?>&ant=2" class="link" onclick="return confirm('Seguro Desasociar Borrar el Archivo ?')" title="Borrar"><img src="imagenes/b_drop.png" border=0></a> 

              <br>
            </td>
          </tr>
          <tr>
            <td  valign="center" class="Estilo1"><font color="#FF0000"></font> Fecha de <?= utf8_decode('aprobación') ?></td>
            <td class="Estilo1" colspan=3>
             <input type="text" name="fecha_vb" class="Estilo2" size="12" value="<? echo $fecha6 ?>" id="fecha_vb" readonly="1">
             <img src="calendario.gif" id="fecha_vb_trigger" style="cursor: pointer; border: 1px solid red;" title="Date selector"
             onmouseover="this.style.background='red';" onMouseOut="this.style.background=''" />

             <script type="text/javascript">
              Calendar.setup({
                inputField : "fecha_vb",
                trigger    : "fecha_vb_trigger",
                onSelect   : function() { this.hide() },
                showTime   : 12,
                dateFormat : "%d-%m-%Y"
              });
              //]]></script>

            </td>
          </tr>
          <?
        }else{
          ?>
          <input type="file" name="ant2" class="Estilo2" size="20" >
          <br>
        </td>
      </tr>
      <?
    }
    ?>


            <!--FICHA DE PAGO-->

            <?php
             //  $fac_id=$row5["fac_id"]

              $ficha = "";
              //Verificar si es Contrato
              $fac_id = $row5["fac_id"];
              $sql22 = "Select * from dpp_cont_fac where confa_fac_id='$fac_id'";
              //echo $sql22;
              $res22 = mysql_query($sql22);
              $row22 = mysql_fetch_array($res22);
              if (!empty($row22)) {
                $confa_fac_id=$row22["confa_fac_id"];
                if ($confa_fac_id<>''){
                  //Es contrato
                  $cont_id = $row22["confa_cont_id"];
                  $query = "SELECT * FROM  ficha_pago where cont_id_ficha='".$cont_id."' and id_ficha = ( SELECT MAX(id_ficha) as id_ficha FROM ficha_pago where cont_id_ficha='".$cont_id."')";
                //  echo $query;
                  $r = mysql_query($query);
                  $ficha = mysql_fetch_array($r);

                  $tipo=1;
                }
              }else{
                //Verificar si es OC
                $sql222 = "select * from compra_oceta where oceta_eta_id='$id1b'";
                $res222 = mysql_query($sql222);
                $row222 = mysql_fetch_array($res222);
                if (!empty($row222)) {
                  $oceta_eta_id=$row222["oceta_eta_id"];
                  if ($row5["eta_nroorden"]<>'' and $oceta_eta_id<>''){
                    //Es OC
                    $query = "SELECT * FROM  ficha_pago_oc where doc_id_ficha='".$id1b."' and fecha_ficha = ( SELECT MAX(fecha_ficha) FROM ficha_pago_oc where doc_id_ficha='".$id1b."')";
                    $r = mysql_query($query);
                    $ficha = mysql_fetch_array($r);
                    $tipo=2;
                  }
                }else{
                  //No esta asociada a nada
                  $tipo = 3;
                }
                
              }


            ?>

            <?php if ($tipo != 3 || !empty($ficha)): ?>
              
            <tr>
              <td  valign="center" class="Estilo1"><br><br></td>


            </tr>

            <tr>
              <td valign="center" class="Estilo1">Ficha de Pago </td>
              <td class="Estilo1" colspan=3>
                <?php if ($tipo == 1){ ?>
                  <a href="recuperar_fichapagopdf.php?ficha=<?=$ficha["id_ficha"]?>" class="link" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Archivo Ficha de Pago</a>
                  
                <?php }elseif ($tipo == 2) { ?>

                  <a href="recuperar_fichapagopdf2.php?ficha=<?=$ficha["id_ficha"]?>" class="link" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Archivo Ficha de Pago</a>
                <?php } ?>
              </td>
            </tr>

            <tr>
              <td valign="center" class="Estilo1">Fecha Ficha de Pago </td>
              <td class="Estilo1" colspan=3>
                  <? echo  substr($ficha["fecha_ficha"],8,2)."-".substr($ficha["fecha_ficha"],5,2)."-".substr($ficha["fecha_ficha"],0,4);?>
              </td>
            </tr>

            <?php endif ?>

            <!--FIN FICHA DE PAGO-->






    <?

    $mailuno=$row5["fac_mail1"];

    if ($mailuno=="" and $regionsession==15 and 1==2) {

      $mailprimero="aramirez@dpp.cl";

    }else {

      $mailprimero=$row5["fac_mail1"];



    }

    if ($regionsession==15 and 1==2) {

      ?>



      <tr>

       <td  valign="top" class="Estilo1">Email 1 </td>

       <td class="Estilo1" colspan=3>

        <input type="text" name="mail1" class="Estilo2" size="40" value="<? echo $mailprimero ?>">

      </td>

    </tr>

    <tr>

     <td  valign="top" class="Estilo1">Email 2 </td>

     <td class="Estilo1" colspan=3>

      <input type="text" name="mail2" class="Estilo2" size="40" value="<? echo $row5["fac_mail2"] ?>">

    </td>

  </tr>

  <tr>

   <td  valign="top" class="Estilo1">Email 3 </td>

   <td class="Estilo1" colspan=3>

    <input type="text" name="mail3" class="Estilo2" size="40" value="<? echo $row5["fac_mail3"] ?>">

  </td>

</tr>

<tr>

 <td  valign="top" class="Estilo1">Email 4 </td>

 <td class="Estilo1" colspan=3>

  <input type="text" name="mail4" class="Estilo2" size="40" value="<? echo $row5["fac_mail4"] ?>">

</td>

</tr>

<tr>

 <td  valign="top" class="Estilo1">Email 5 </td>

 <td class="Estilo1" colspan=3>

  <input type="text" name="mail5" class="Estilo2" size="40" value="<? echo $row5["fac_mail5"] ?>">

</td>

</tr>

<tr>

 <td  valign="center" class="Estilo1"><br> </td>

 <td  valign="center" class="Estilo1"> </td>



</tr>

<?

}

if ($a0<>4) {

  ?>

  <tr>

   <td colspan=4 align="center"> <input type="submit" value="    GRABAR DATOS    " class="btn btn-primary"> </td>

 </tr>

 <?

}

?>





<input type="hidden" name="var1" value="<? echo $row5["fac_eta_id"] ?>" >

<input type="hidden" name="id" value="<? echo $id ?>" >

<input type="hidden" name="id1b" value="<? echo $id1b ?>" >

<input type="hidden" name="idetapa" value="<? echo $idetapa ?>" >

<input type="hidden" name="facfolio" value="<? echo $facfolio ?>" >

<input type="hidden" name="pagoid" value="<? echo $codigo2[4] ?>" >





</form>



</td>

<?

if ($regionsession==15 and 2==1) {

  ?>





  <form name="form2" action="mail1etapa2.php" method="post"  onSubmit="return valida()"  >

    <table>

     <tr>

       <td  valign="center" class="Estilo1" colspan=8></td>

     </tr>

     

     <tr>

       <td  valign="top" class="Estilo1c" colspan="4">NOTA: Antes de enviar e-mail, se debe grabar <?= utf8_decode('información') ?></td>

     </td>

   </tr>





   <tr>

     <td  valign="top" class="Estilo1">Email 1 </td>

     <td class="Estilo1" colspan=3>

      <input type="checkbox" name="envia1" class="Estilo2" value="1">

      <input type="hidden" name="mail1" class="Estilo2" size="40" value="<? echo $row5["fac_mail1"] ?>"><? echo $row5["fac_mail1"] ?>

    </td>

  </tr>

  <tr>

   <td  valign="top" class="Estilo1">Email 2 </td>

   <td class="Estilo1" colspan=3>

    <input type="checkbox" name="envia2" class="Estilo2" value="1">

    <input type="hidden" name="mail2" class="Estilo2" size="40" value="<? echo $row5["fac_mail2"] ?>"><? echo $row5["fac_mail2"] ?>

  </td>

</tr>

<tr>

 <td  valign="top" class="Estilo1">Email 3 </td>

 <td class="Estilo1" colspan=3>

  <input type="checkbox" name="envia3" class="Estilo2" value="1">

  <input type="hidden" name="mail3" class="Estilo2" size="40" value="<? echo $row5["fac_mail3"] ?>"><? echo $row5["fac_mail3"] ?>

</td>

</tr>

<tr>

 <td  valign="top" class="Estilo1">Email 4 </td>

 <td class="Estilo1" colspan=3>

  <input type="checkbox" name="envia4" class="Estilo2" value="1">

  <input type="hidden" name="mail4" class="Estilo2" size="40" value="<? echo $row5["fac_mail4"] ?>"><? echo $row5["fac_mail4"] ?>

</td>

</tr>

<tr>

 <td  valign="top" class="Estilo1">Email 5 </td>

 <td class="Estilo1" colspan=3>

  <input type="checkbox" name="envia5" class="Estilo2" value="1">

  <input type="hidden" name="mail5" class="Estilo2" size="40" value="<? echo $row5["fac_mail5"] ?>"><? echo $row5["fac_mail5"] ?>

</td>

</tr>



<tr>

 <td  valign="center" class="Estilo1"><br><br><br> </td>

 <td  valign="center" class="Estilo1"> </td>



</tr>



<tr>

 <input type="hidden" name="id" value="<? echo $id ?>" >

 <input type="hidden" name="id1b" value="<? echo $id1b ?>" >

 <input type="hidden" name="sw" value="1">

 <input type="hidden" name="idetapa" value="<? echo $idetapa ?>" >

 <?

 if ($row5["fac_archivo"]<>"" and $row5["fac_doc1"]<>"" and $row5["eta_depto_aprobacion"]<>"0") {

  ?>

  <td colspan=4 align="center"> <input type="submit" value="    Enviar Mail " > </td>

  <?

}

?>

</tr>

<?

}

?>

</table>

</form>


<tr>
  <td><br></tr>
  </tr>

  <tr>
    <td><br></tr>
    </tr>

    <tr>
      <td><br></tr>
      </tr>

      <tr>
        <td><br></tr>
        </tr>

        <tr>
          <td><br></tr>
          </tr>

          <tr>
            <td><br></tr>
            </tr>

            <tr>
            </td>

          </tr>

          

          

        </table>



        <img src="images/pix.gif" width="1" height="10">

      </body>

      <script language="javascript">


        function cerrar_hito(url){

         url = url+'&desc=';
         var desc_cierre = prompt('Ingrese una <?= utf8_decode('descripción') ?> para el hito', "");
         
         if (desc_cierre == null || desc_cierre == "") {
           alert('Lo sentimos, no es posible cerrar un hito sin una <?= utf8_decode('descripción') ?>');
         } else {
          url = url+desc_cierre;
          console.log(url);
          location.href=url;
        }


      }
      function asociarDistribucion(id,fact,monto,id1b) {
        console.log('click');
        miPopup = window.open("factura_distribucion.php?id="+id+"&fact="+fact+"&monto="+monto+"&id1b="+id1b,"miwin","width=800,height=500,scrollbars=yes,toolbar=0")
        miPopup.focus()
      }


      function limpiar() {
        document.form1.dig.value="";
      }
      function verificador() {
        var rut = document.form1.rut.value;
        var dig = document.form1.dig.value;
        var count = 0;
        var count2 = 0;
        var factor = 2;
        var suma = 0;
        var sum = 0;
        var digito = 0;
        count2 = rut.length - 1;
        while(count < rut.length) {
          sum = factor * (parseInt(rut.substr(count2,1)));
          suma = suma + sum;
          sum = 0;
          count = count + 1;
          count2 = count2 - 1;
          factor = factor + 1;
          if(factor > 7) {
            factor=2;
          }
        }
        digito = 11 - (suma % 11);
        if (digito == 11) {
          digito = 0;
        }
        if (digito == 10) {
          digito = "k";
        }
        if (dig!=digito) {
          alert('Rut incorrecto, es  '+digito);
          document.form1.dig.focus();
        } else {
          traerDatos(rut);
        }
      }
      function llamado() {
        alert('llamando al un alerta de otra funcion');
      }
      function nuevoAjax()
      {
        var xmlhttp=false;
        try
        {
          xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch(e)
        {
          try
          {
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
          }
          catch(E) { xmlhttp=false; }
        }
        if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); }
        return xmlhttp;
      }
      function traerDatos(tipoDato)  {
        var ajax=nuevoAjax();
        ajax.open("POST", "buscaclient.php", true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("d="+tipoDato);
        ajax.onreadystatechange=function()  {
          if (ajax.readyState==4) {
            document.form1.nombre.value=ajax.responseText;
          }
        }
      }
      function traerDatos2(a,b,c)  {
        var ajax=nuevoAjax();
        tipoDato1=a;
        tipoDato2=b;
        rut=document.form1.rut.value;
        ajax.open("POST", "buscaclient2.php", true);
        ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        ajax.send("d="+tipoDato1+"&e="+tipoDato2);
        ajax.onreadystatechange=function()  {
          if (ajax.readyState==4) {
            if (ajax.responseText == 1) {
            }
            if (ajax.responseText == 0) {
              alert ("Numero de Boleta Existe Para esta proveedor "+c);
              document.getElementById(c).value =ajax.responseText;
            }
          }
        }
      }

      var suma = 0;
      $(document).ready(function(){
        $("#fiscalias").hide();
        $(".cuota").on('click',function(){
          if($(this).is(':checked')){
            total = $("#monto").val();
            id    = $(this).val(); 
            suma = suma + Number($("#cuota"+id).val());
            $("#cuota"+id).prop('disabled',true);
            $("#ch"+id).val($("#cuota"+id).val());
          }else{
            total = $("#monto").val();
            id    = $(this).val(); 
            suma  = suma - Number($("#cuota"+id).val());
            $("#cuota"+id).prop('disabled',false);
            $("#ch"+id).val('');
          }
        });

        $("#pop").on('click',function(){
          if($(this).is(':checked')){
            $("#popR").html(" SI");
          }else{
            $("#popR").html(" NO");
          }
        });
      });

      function valida() {
        <?   
        if ($sw==1 && $hitos > 0) : 
          echo "if($('#monto').val() > suma){
            console.log(suma);
            console.log($('#monto').val());
            r = false; /* confirm('El total a pagar es mayor a la suma de las cuotas'); */
          }else if($('#monto').val() < suma){
           r = false; /* confirm('El total a pagar es menor a la suma de las cuotas'); */
         }
         if (r == true) {
          return false;
        }";
      endif; ?>

      if ((document.form1.item[0].checked=='' && document.form1.item[1].checked==''  && document.form1.item[2].checked=='' && document.form1.item[3].checked=='' && document.form1.item[4].checked=='' && document.form1.item[5].checked=='')) {
        alert ("Descripcion Item presenta problemas ");
        return false;
      }
      if (document.form1.modalidad.value=='' ) {
        alert ("Descripcion modalidad presenta problemas ");
        return false;
      }
      if (document.form1.modalidad.value=='' ) {
      }
  /* if (document.form1.archivo1.value=='' && document.form1.archivo111.value=='') {
      alert ("Imagen de la Factura presenta problemas ");
      return false;
  }
  if (document.form1.ant1.value=='') {
      alert ("Imagen de Validaci�n SII presenta problemas ");
      return false;
  }
  */
}
function valida2() {
  if ( document.form22.accion.value==1 ) {
   return true       
 }
 if (document.form22.accion.value=='' ) {
  alert ("Accion presenta problemas");
  return false;
}
if (document.form22.fechavb.value=='' ) {
  alert ("Fecha <?= utf8_decode('V°B°') ?> presenta problemas");
  return false;
}
if (document.form22.comentario.value=='' && (document.form22.accion.value==10 || document.form22.accion.value==99)) {
  alert ("Justificacion Presenta Problemas");
  return false;
}
if (document.form22.accion.value==10 ) {
 if (confirm('¿ Seguro que Desea Rechazar ?')) {
   return true
 } else {
   return false
 }
}

}
function muestra() {
  var opcionSeleccionada = document.form22.accion.value;
  if(opcionSeleccionada == 6)
  {
    $("#fiscalias").fadeIn("slow");
    $("#fiscaliaDestino").attr("required",true);
  }else{
    $("#fiscalias").fadeOut("slow");
    $("#fiscaliaDestino").attr("required",false);
  }

    /*
    if (document.form22.accion.value==1 ) {
       seccion1.style.display="";
    } else {
       seccion1.style.display="none";
    }
    */
  }
  function abreVentana(){
    miPopup = window.open("compra_listaresolucion.php?id=<? echo $id ?>&id2=<? echo $id2 ?>","miwin","width=500,height=500,scrollbars=yes,toolbar=0")
    miPopup.focus()
  }

  function verSolicitud(ocbrowse){
        let miPopup = window.open('solicitud_ficha_popup.php?id='+ocbrowse,"miwin","width=900,height=600,scrollbars=yes,toolbar=0");
        miPopup.focus()
    }
</script>
</html>
