<?php	
require_once('init.php');
include(CLASS_PATH."step2detail.php");
$obj = new step2detail();

$project_id = $_GET['project_id'];

$get_projname = $obj->get_projname($project_id);
$getworksheet_projinfo = $obj->getworksheet_projinfo($project_id);	
$getwinglassinfo = $obj->getwinglassinfo($project_id);
$getskylightinfo = $obj->getskylightinfo($project_id);
$gethouseinfo_master = $obj->gethouseinfo_master($project_id);
$getfloormaster_info = $obj->getfloormaster_info($project_id);
$getductwork_masterinfo = $obj->getductwork_masterinfo($project_id);
$getfloors_masterinfo = $obj->getfloors_masterinfo($project_id);
$getappliances_info = $obj->getappliances_info($project_id);
$getdoors_info = $obj->getdoors_info($project_id);
$getfloor_info = $obj->getfloor_info($project_id);
$getabovegrade_walls_master = $obj->getabovegrade_walls_master($project_id);
$getbelowgrade_walls_master = $obj->getbelowgrade_walls_master($project_id);
$getceilings_master = $obj->getceilings_master($project_id);
//echo '<pre>';
//print_r($getabovegrade_walls_master);

$conditioned_sqft = $gethouseinfo_master[0]['conditioned_sqft'];
$numof_residents = $gethouseinfo_master[0]['num_of_residents'];
$winter_out_design_tmp = $gethouseinfo_master[0]['winter_out_design_tmp'];

/* DUCTWORK MASTER */
	
$roof_surface = $getductwork_masterinfo[0]['roof_surface'];	
$attic_temperature = $getductwork_masterinfo[0]['attic_temperature'];	
$supply_geometry = $getductwork_masterinfo[0]['supply_geometry'];	
$return_geometry = $getductwork_masterinfo[0]['return_geometry'];	
$outlet_location = $getductwork_masterinfo[0]['outlet_location'];	
$insulation_r_value = $getductwork_masterinfo[0]['insulation_r_value'];

if($getductwork_masterinfo[0]['bypass_humidifier'] == 'Bypass humidifier')
{
	$bypass_humidifier = '1';	
}
else 
{
	$bypass_humidifier = '0';
}

if($project_id > 0)
{
	$tbl7_duct_load = $obj->tbl7_duct_load($roof_surface,$attic_temperature,$supply_geometry,$return_geometry,$outlet_location);
	$Table_Number = $tbl7_duct_load[0]['Table_Number']; 
}

if(!empty($Table_Number))
{
	$table7_bhlf = $obj->table7_bhlf($Table_Number,$conditioned_sqft);
	$table7_bsgf = $obj->table7_bsgf($Table_Number,$conditioned_sqft);
	$table7_bhlf_r_value_correction = $obj->table7_bhlf_r_value_correction($Table_Number,$insulation_r_value);
	$table7_bsgf_r_value_corection = $obj->table7_bsgf_r_value_corection($Table_Number,$insulation_r_value);
	$table7_bhlfleackage_correction = $obj->table7_bhlfleackage_correction($Table_Number);
	$table7_bsgfleakage_correction = $obj->table7_bsgfleakage_correction($Table_Number);
	$table7_blgleakage_correction = $obj->table7_blgleakage_correction($Table_Number);
	$table7blg = $obj->table7blg($Table_Number);
	$table7_ductwall_surface_area = $obj->table7_ductwall_surface_area($Table_Number);
	$table7_surfacearea_factor = $obj->table7_surfacearea_factor($Table_Number);
	$table12_outdoor_grains = $obj->table12_outdoor_grains($winter_out_design_tmp);
	$table12_indoor_grains = $obj->table12_indoor_grains($winter_out_design_tmp);
}
//echo '<pre>';
//print_r($table12_outdoor_grains);
	
/* END */

$Framing_Material = $getabovegrade_walls_master[0]['Framing_Material'];
$Frame_Construction = $getabovegrade_walls_master[0]['Frame_Construction'];
$Cavity_Insulation = $getabovegrade_walls_master[0]['Cavity_Insulation'];
$Board_Insulation = $getabovegrade_walls_master[0]['Board_Insulation'];
$Exterior_Finish = $getabovegrade_walls_master[0]['Exterior_Finish'];
$Block_Core = $getabovegrade_walls_master[0]['Block_Core'];
$Stud_material = $getabovegrade_walls_master[0]['Stud_material'];

$attic_temperature = $getceilings_master[0]['attic_temperature'];
$attic_ventilation = $getceilings_master[0]['attic_ventilation'];
$roof_material = $getceilings_master[0]['roof_material'];
$r_value = $getceilings_master[0]['r_value'];

$ctd = $getval_of_wa[0]['Cooling_DB_1'] - $gethouseinfo_master[0]['summer_in_design_tmp'];
$tbl4aceiling = $obj->tbl4aceiling($attic_temperature,$attic_ventilation,$roof_material,$r_value,$getval_of_wa[0]['Daily_Range'],$ctd);

if($Framing_Material == 'Block') 
{
	$tblblockwall_partation = $obj->tblblockwall_partation($Frame_Construction,$Cavity_Insulation,$Board_Insulation,$Exterior_Finish,$Block_Core,$Stud_material);
	$Group_Number = $tblblockwall_partation[0]['Group_Number'];
}
else if($Framing_Material == 'Wood' && $Framing_Material == 'Metal')	
{
	$tblframewall_partation = $obj->tblframewall_partation($Frame_Construction,$Cavity_Insulation,$Board_Insulation,$Exterior_Finish,$Block_Core,$Stud_material);
	$Group_Number = $tblframewall_partation[0]['Group_Number'];
}
else
{
	$tblaltwall_partation = $obj->tblaltwall_partation($Frame_Construction,$Cavity_Insulation,$Board_Insulation,$Exterior_Finish,$Block_Core,$Stud_material);
	$Group_Number = $tblframewall_partation[0]['Group_Number'];
}

//echo '<pre>';
//print_r($tblblockwall_partation);

if(count($getdoors_info) > 0)
{
	for($a=0;$a < count($getdoors_info);$a++)
	{				
		$Door_Material = $getdoors_info[$a]['Door_Material'];
		$Core_Material = $getdoors_info[$a]['Core_Material'];
	}
}

$ctd = $getval_of_wa[0]['Cooling_DB_1'] - $gethouseinfo_master[0]['summer_in_design_tmp'];  
$gettbl_woodmetaldoor = $obj->gettbl_woodmetaldoor($Door_Material,$Core_Material,$getval_of_wa[0]['Daily_Range'],$ctd);
//echo '<pre>';
//print_r($gettbl_woodmetaldoor);


if(count($getskylightinfo) > 0)
{
	for($a=0;$a < count($getskylightinfo);$a++)
	{				
		$Type_of_Skylight = $getskylightinfo[$a]['Type_of_Skylight'];
		$Light_Shaft_Material = $getskylightinfo[$a]['Light_Shaft_Material'];
		$Curb_Size = $getskylightinfo[$a]['Curb_Size'];
		$Curb_Area = $getskylightinfo[$a]['Curb_Area'];
		$U_value = $getskylightinfo[$a]['U_value'];
		$Tilt_Angle = $getskylightinfo[$a]['Tilt_Angle'];
		$shgc_value = $getskylightinfo[$a]['shgc_value'];
		$Light_Shaft_Material = $getskylightinfo[$a]['Light_Shaft_Material'];
		$Curb_Construction = $getskylightinfo[$a]['Curb_Construction'];
	}
}


if(count($getwinglassinfo) > 0)
{
	for($a=0;$a < count($getwinglassinfo);$a++)
	{				
		$type_of_Window_Door = $getwinglassinfo[$a]['type_of_Window_Door'];
		$winne_nw = $getwinglassinfo[$a]['ne_nw'];
		$winew = $getwinglassinfo[$a]['e_w'];
		$winsesw = $getwinglassinfo[$a]['se_sw'];
		$wn = $getwinglassinfo[$a]['n'];
		$ws = $getwinglassinfo[$a]['s'];
		$winPane = $getwinglassinfo[$a]['Pane'];
		$Glazing_Option = $getwinglassinfo[$a]['Glazing_Option'];
		$Color_Class = $getwinglassinfo[$a]['Color_Class'];
		$Internal_shade = $getwinglassinfo[$a]['Internal_shade'];
		$U_valuewin = $getwinglassinfo[$a]['U_value'];
		$shgc_value = $getwinglassinfo[$a]['shgc_value'];
		$External_Shading = $getwinglassinfo[$a]['External_Shading'];
		$area_sqft = $getwinglassinfo[$a]['area_sqft'];
	}
}



$iscvalue = $obj->iscvalue($winPane,$Glazing_Option,$Color_Class);

if($Internal_shade == 'Internal shade')
{
	$inshade = 'Yes';
}
else
{
	$inshade = 'No';
}
//echo '<pre>';
//print_r($CLFvalue);

$flooradd = $getworksheet_projinfo[0]['address'];

$p = '2' * $Curb_Area;
$acurb = $Curb_Area / '12';
$arcurb = $acurb / $Curb_Area;
$ashaft = $p * $Curb_Area;
$arshaft = $ashaft / $Curb_Area;


$tbl2b3_default_u_values = $obj->tbl2b3_default_u_values($Light_Shaft_Material);
$tbl2aglass = $obj->tbl2aglass($type_of_Window_Door);
$tblskylight = $obj->tblskylight($Type_of_Skylight);
$tbl2b3defaultuvalue = $obj->tbl2b3defaultuvalue($Light_Shaft_Material);

$Ucurb = $tbl2b3defaultuvalue[0]['Default_U_Value_Ucurb']; 
$Ushaft = $tbl2b3defaultuvalue[0]['Default_U_Value_Ushaft']; 

$ueff =  $U_value + ($Ucurb * $arcurb) + ($Ushaft * $arshaft);
$solh = $Tilt_Angle * '1';
$solv = $Tilt_Angle * '1';

//$tbl2b4 = $obj->tbl2b4($Curb_Size);
//echo '<pre>';
//print_r($getfloormaster_info);
//exit;
?>
<?php
if(!empty($flooradd))
{
	$getval_of_wa = $obj->getval_microclimate_table($gethouseinfo_master[0]['city_id']);
	$heathtm = $ueff * $getval_of_wa[0]['Heating_DR_99'];
	$ctd = $getval_of_wa[0]['Cooling_DB_1'];
	
	$coolhtm = ('1' * '1') * ($shgc_value / 0.87) + $ueff * ($ctd + 15);
	
}

/* FOR worksheet D*/


//if(count($getdoors_info) > 0)
//{
//for($a=0;$a < count($getdoors_info);$a++){
					
$grossarea = $getdoors_info[0]['width'] * $getdoors_info[0]['width'] * $getdoors_info[0]['qty'];
$construction_number = $obj->construction_number($getdoors_info[0]['Door_Material'],$getdoors_info[0]['Core_Material']);

//}
//}

//echo '<pre>';
//print_r($construction_number);

/* D end*/
/* FOR worksheet E*/

$numofbedroom = $gethouseinfo_master[0]['num_of_residents'];
$numofpeople = $numofbedroom + '1';
$abovegradevol = ($getfloormaster_info[0]['area'] * $gethouseinfo_master[0]['avg_ceiling_height']);
$htdctd = $getval_of_wa[0]['Heating_DR_99'] + $getval_of_wa[0]['Cooling_DB_1']; 
$oacfmach = '0.35' * $abovegradevol / '60';

$forpsfval = number_format($new_lt,0);

if($winne_nw >0)
{
	$explosure = 'NE/NW';
	$CLFvaluenenw = $obj->CLFvaluenenw($inshade,$explosure);
	$psfvaluenenw = $obj->psfvaluenenw($forpsfval,$explosure);
	//echo "<pre>";
	//print_r($psfvaluenenw);
	
	$CLFnenw = $CLFvaluenenw[0]['CLF'];
	
	
	$coolhtmdnnenw = ($psfvaluenenw[0]['PSF_Value'] * $CLFnenw) * ($shgc_value / '0.87') * $iscvalue[0]['ISC_Ratios'] + $U_valuewin * $ctd;

	$shadedarea = $area_sqft * $External_Shading;
	$unshadedarea = $area_sqft - $shadedarea;
	$btuhgain = $shadedarea * $coolhtmdnnenw + $unshadedarea * $coolhtmdnnenw;
	$htmohnenw = $btuhgain / $area_sqft;	

}
if($winew >0)
{
	$explosure = 'E/W';
	$CLFvalueew = $obj->CLFvalueew($inshade,$explosure);
	$psfvalueew = $obj->psfvalueew($forpsfval,$explosure);
	
	$CLFew = $CLFvalueew[0]['CLF'];
	$coolhtmdnew = ($psfvalueew[0]['PSF_Value'] * $CLFew) * ($shgc_value / '0.87') * $iscvalue[0]['ISC_Ratios'] + $U_valuewin * $ctd;

	$shadedarea = $area_sqft * $External_Shading;
	$unshadedarea = $area_sqft - $shadedarea;
	$btuhgain = $shadedarea * $coolhtmdnew + $unshadedarea * $coolhtmdnew;
	$htmohew = $btuhgain / $area_sqft;	
	
}
if($winsesw >0)
{
	$explosure = 'SE/SW';
	$CLFvaluesesw = $obj->CLFvaluesesw($inshade,$explosure);
	$psfvaluesesw = $obj->psfvaluesesw($forpsfval,$explosure);
	
	$CLFsesw = $CLFvaluesesw[0]['CLF'];
	$coolhtmdnsesw = ($psfvaluesesw[0]['PSF_Value'] * $CLFsesw) * ($shgc_value / '0.87') * $iscvalue[0]['ISC_Ratios'] + $U_valuewin * $ctd;

	$shadedarea = $area_sqft * $External_Shading;
	$unshadedarea = $area_sqft - $shadedarea;
	$btuhgain = $shadedarea * $coolhtmdnsesw + $unshadedarea * $coolhtmdnsesw;
	$htmohsesw = $btuhgain / $area_sqft;	
	
}
if($wn >0)
{
	$explosure = 'N';
	$CLFvaluen = $obj->CLFvaluen($inshade,$explosure);
	$psfvaluen = $obj->psfvaluen($forpsfval,$explosure);
	
	$CLFn = $CLFvaluen[0]['CLF'];
	$coolhtmdnn = ($psfvaluen[0]['PSF_Value'] * $CLFn) * ($shgc_value / '0.87') * $iscvalue[0]['ISC_Ratios'] + $U_valuewin * $ctd;

	$shadedarea = $area_sqft * $External_Shading;
	$unshadedarea = $area_sqft - $shadedarea;
	$btuhgain = $shadedarea * $coolhtmdnn + $unshadedarea * $coolhtmdnn;
	$htmohn = $btuhgain / $area_sqft;	
	
}
if($ws >0)
{
	$explosure = 'S';
	$CLFvalues = $obj->CLFvalues($inshade,$explosure);
	$psfvalues = $obj->psfvalues($forpsfval,$explosure);
	
	//echo "<pre>";
	//print_r($psfvalues);
	
	$CLFs = $CLFvalues[0]['CLF'];
	$coolhtmdns = ($psfvalues[0]['PSF_Value'] * $CLFs) * ($shgc_value / '0.87') * $iscvalue[0]['ISC_Ratios'] + $U_valuewin * $ctd;

	$shadedarea = $area_sqft * $External_Shading;
	$unshadedarea = $area_sqft - $shadedarea;
	$btuhgain = $shadedarea * $coolhtmdns + $unshadedarea * $coolhtmdns;
	$htmohs = $btuhgain / $area_sqft;	
	
}

/* End */

if(!empty($gethouseinfo_master[0]['type_of_construction']))
{
	$tbl5a5b = $obj->tbl5a5b($gethouseinfo_master[0]['type_of_construction'],$gethouseinfo_master[0]['house_type'],$gethouseinfo_master[0]['conditioned_sqft']);
	$tbl5a5b1 = $obj->tbl5a5b1($gethouseinfo_master[0]['type_of_construction'],$gethouseinfo_master[0]['house_type'],$gethouseinfo_master[0]['conditioned_sqft']);	
}
					
/* today code */
$numofresidents = $gethouseinfo_master[0]['num_of_residents'] + '1';
$table10a = $obj->table10a($getval_of_wa[0]['Latitude']);
//echo "<pre>";
//print_r($table10a);
$suggestventilation = ($numofresidents * 20) - $tbl5a5b[0]['Infiltration_CFM_For_1_Fireplace']; 
$outdooraircfm = 0.35 * $abovegradevol / 60; 


		if($oacfmach > $outdooraircfm)
		{
			$codevalfor_cfm = $oacfmach;
		}
		else
		{
			$codevalfor_cfm = $outdooraircfm;
		}
		
$outdoorcfmrequirment = $outdooraircfm - $tbl5a5b[0]['Infiltration_CFM_For_1_Fireplace'];		


	if($outdoorcfmrequirment > $suggestventilation)
	{
		$PractitionerspecifiedVCFM = $outdoorcfmrequirment;
	}
	else
	{
		$PractitionerspecifiedVCFM = $suggestventilation;	
	}		
	
/* End */

?>

	<table width="100%" border="1" cellpadding="5px" cellspacing="5px">
	
	<tr>
		<td colspan="8">
		<table border="1" width="100%">
			<tr style=" text-align:center;">
					<td colspan="8" ><h4>Supporting Detail</h4></td>
			</tr>
			
			<tr>
				<td>Project Name: <?php echo $get_projname[0]['project_name'];?></td>			
				<td>Date: <?php echo date("d/m/Y"); ?></td>			
			</tr>
			<tr>
				<td>Address: <?php echo $getworksheet_projinfo[0]['address'];?></td>
			</tr>
			<tr>
				<td>Phone:</td>			
				<td>Job ID:</td>
			</tr>
		</table>
		</td>
	</tr>
	<!-- Worksheet A -->
	<tr>
		<td colspan="8">				
			<table border="1" width="100%" align="left">
			<tr style=" text-align:center;">
				<td colspan="8" ><h4>Worksheet A<br/>Location and Design Conditions</h4></td>
			</tr>			
			<tr>
				<td>State:</td>
				<td><?php echo $getval_of_wa[0]['State']; ?></td>
				<td>City:</td>
				<td><?php echo $getval_of_wa[0]['City_Town']; ?></td>
				<td>Elevation:</td>
				<td><?php echo $getval_of_wa[0]['Elevation_Ft']; ?></td>
				<td>Latitude</td>
				<td><?php echo $getval_of_wa[0]['Latitude']; ?></td>				
			</tr>
			<tr>
				<td>Indoor Conditions, Heating: DB </td>
				<td><?php echo $gethouseinfo_master[0]['winter_in_design_tmp']; ?></td>
				<td>RH </td>
				<td><?php echo '25'; ?></td>
				<td>Indoor Conditions, Cooling: DB </td>
				<td><?php echo $gethouseinfo_master[0]['summer_in_design_tmp']; ?></td>
				<td>RH =</td>
				<td><?php echo '50'; ?></td>				
			</tr>
			<tr>
				<td>Table 1 Conditions 99% DB </td>
				<td><?php echo $getval_of_wa[0]['Heating_DR_99']; ?></td>				
				<td>1% DB </td>
				<td><?php echo $getval_of_wa[0]['Cooling_DB_1']; ?></td>				
				<td>Grains Difference </td>
				<td><?php echo $getval_of_wa[0]['DG_50_RH']; ?></td>				
				<td>Daily Range </td>
				<td><?php echo $getval_of_wa[0]['Daily_Range']; ?></td>				
			</tr>
			<tr>
				<td>Design Temperature Differences</td>				
				<td>HTD </td>
				<td><?php echo $htd = $gethouseinfo_master[0]['winter_in_design_tmp'] - $getval_of_wa[0]['Heating_DR_99']; ?></td>
				<td>CTD </td>
				<td><?php echo $ctd = $getval_of_wa[0]['Cooling_DB_1'] - $gethouseinfo_master[0]['summer_in_design_tmp']; ?></td>
			</tr>
		</table>						
		</td>
	</tr>	
	<!-- Worksheet A END -->
	<!-- Worksheet B -->
				
	<tr>
		<td colspan="8">			
			<table border="1">
	<tr style=" text-align:center;">
		<td colspan="8" ><h4>Worksheet B<br/>HTM Values for Windows and Glass Doors</h4></td>
	</tr>
	<tr>
		<td colspan="8">
			<table border="1" width="100%">
				<tr>
					<td colspan="2">Lat = <?php echo $getval_of_wa[0]['Latitude']; ?></td>
					<td colspan="2">HTD = <?php echo $htd; ?></td>
					<td colspan="3">CTD = <?php echo $ctd; ?></td>
					<td colspan="3">Table 3D Values</td>
					<td rowspan="2">Heat HTM</td>
					<td rowspan="2">Cool HTM<sub>D</sub> HTM<sub>N</sub></td>
					<td rowspan="2">Screen or Proj. Adjust</td>
					<td rowspan="2">AHTM<sub>D</sub> AHTM<sub>M</sub></td>
					<td rowspan="2">Adjust for SS or OH</td>
					<td rowspan="2">AHTM<sub>D</sub></td>
					<td rowspan="2">AHTM<sub>M</sub></td>
					<td rowspan="2">SC<sub>SS</sub></td>
					<td rowspan="2">HTM<sub>SS</sub></td>
					<td rowspan="2">AHTM<sub>D</sub></td>
					<td rowspan="2">AHTM<sub>M</sub></td>
					<td rowspan="2">HTM<sub>OH</sub></td>
				</tr>
				<tr>
					<td colspan="2">Type of Panel</td>
					<td>Const.Number</td>
					<td>Internal Shade</td>
					<td>Faces</td>
					<td>U-Value 2A or NFRC</td>
					<td>SHGC 2A or NFRC</td>
					<td>PSF 3D-2</td>
					<td>CLF<sub>Avg</sub> 3D-3</td>
					<td>ISC 3D-4</td>
				</tr>
				<?php 
				if(count($getwinglassinfo) > 0)
				{
				for($a=0;$a < count($getwinglassinfo);$a++){
				?>
				<?php if($winne_nw >0) { ?>
				<tr>
					<td width="10px">a</td>
					<td><?php echo $getwinglassinfo[$a]['type_of_Window_Door']; ?></td>
					<td><?php echo $tbl2aglass[0]['Construction_Number'];?></td>
					<td><?php echo $Internal_shade; ?></td>
					<td><?php echo "NE/NW";?></td>
					<td><?php echo $tbl2aglass[0]['U_Value'];?></td>
					<td><?php echo $tbl2aglass[0]['SHGC'];?></td>
					<td><?php echo $psfvaluenenw[0]['PSF_Value']; ?></td>
					<td><?php echo $CLFvaluenenw[0]['CLF'];?></td>
					<td><?php echo $iscvalue[0]['ISC_Ratios']; ?></td>
					<td><?php echo $wsbheathtm = ($htd * $getwinglassinfo[$a]['U_value']); ?></td>
					<td><?php echo number_format($coolhtmdnnenw,4); ?></td>
					<?php 
					
						if($getwinglassinfo[$a]['Insect_Screen'] == 'Outdoor Full')
						{
							$screenprojadjust = '0.8';
						}
						else if($getwinglassinfo[$a]['Insect_Screen'] == 'Outdoor Half')
						{
							$screenprojadjust = '0.9';	
						}
						else if($getwinglassinfo[$a]['Insect_Screen'] == 'Indoor Full')
						{
							$screenprojadjust = '0.9';
						}
						else 
						{
							$screenprojadjust = '0.95';
						}
						 
					?>
					<td> <?php echo $screenprojadjust; ?> </td>
					<?php $ATHMM = $coolhtmdnnenw * $screenprojadjust; ?>
					<td><?php echo number_format($coolhtmdnnenw,4);?></td>
					<?php
					if($getwinglassinfo[$a]['External_Shading'] > 0)
					{
						$SSOHnenw = $getwinglassinfo[$a]['External_Shading'];
					}
					else 
					{
						$SSOHnenw = '0';						
					}
					 ?>
					<td><?php echo $SSOHnenw; ?></td>
					<td><?php echo number_format($coolhtmdnnenw,4) * '1'; ?></td>
					<td><?php echo number_format($ATHMM,4) * '1'; ?></td>
					<td><?php if($getwinglassinfo[$a]['SC_Value'] > 0){echo $getwinglassinfo[$a]['SC_Value'];}else{echo '-';} ?></td>
					<?php
					$htmssnenw = ($coolhtmdnnenw - $ATHMM) * $getwinglassinfo[$a]['SC_Value'] + $ATHMM; ?>
					<td><?php echo number_format($htmssnenw,2); ?></td>
					<td><?php echo number_format($coolhtmdnnenw,4) * '1'; ?></td>
					<td><?php echo number_format($ATHMM,4) * '1'; ?></td>
					<td><?php echo number_format($htmohnenw,2); ?></td>
				</tr>
				<?php 
					}
					if($winsesw >0) { ?>
				<tr>
					<td width="10px">b</td>
					<td><?php echo $getwinglassinfo[0]['type_of_Window_Door']; ?></td>
					<td><?php echo $tbl2aglass[0]['Construction_Number'];?></td>
					<td><?php echo $Internal_shade; ?></td>
					<td><?php echo "SE/SW";?></td>
					<td><?php echo $tbl2aglass[0]['U_Value'];?></td>
					<td><?php echo $tbl2aglass[0]['SHGC'];?></td>
					<td><?php echo $psfvaluesesw[0]['PSF_Value']; ?></td>
					<td><?php echo $CLFvaluesesw[0]['CLF'];?></td>
					<td><?php echo $iscvalue[0]['ISC_Ratios']; ?></td>
					<td><?php echo $wsbheathtm = ($htd * $getwinglassinfo[$a]['U_value']); ?></td>
					<td><?php echo number_format($coolhtmdnsesw,4); ?></td>
					<?php 
					
						if($getwinglassinfo[$a]['Insect_Screen'] == 'Outdoor Full')
						{
							$screenprojadjust = '0.8';
						}
						else if($getwinglassinfo[$a]['Insect_Screen'] == 'Outdoor Half')
						{
							$screenprojadjust = '0.9';	
						}
						else if($getwinglassinfo[$a]['Insect_Screen'] == 'Indoor Full')
						{
							$screenprojadjust = '0.9';
						}
						else 
						{
							$screenprojadjust = '0.95';
						}
						 
					?>
					<td> <?php echo $screenprojadjust; ?> </td>
					<?php $ATHMMsesw = $coolhtmdnsesw * $screenprojadjust; ?>
					<td><?php echo number_format($coolhtmdnsesw,4);?></td>
					<?php
					if($getwinglassinfo[$a]['External_Shading'] > 0)
					{
						$SSOHsesw = $getwinglassinfo[$a]['External_Shading'];
					}
					else 
					{
						$SSOHsesw = '0';
					}
					 ?>
					<td><?php echo $SSOHsesw; ?></td>
					<td><?php echo number_format($coolhtmdnsesw,4) * '1'; ?></td>
					<td><?php echo number_format($ATHMMsesw,4) * '1'; ?></td>
					<td><?php if($getwinglassinfo[$a]['SC_Value'] > 0){echo $getwinglassinfo[$a]['SC_Value'];}else{echo '-';} ?></td>
					<?php $htmsssesw = ($coolhtmdnnenw - $ATHMM) * $getwinglassinfo[$a]['SC_Value'] + $ATHMM; ?>
					<td><?php echo number_format($htmsssesw,2); ?></td>
					<td><?php echo number_format($coolhtmdnsesw,4) * '1'; ?></td>
					<td><?php echo number_format($ATHMMsesw,4) * '1'; ?></td>
					<td><?php echo number_format($htmohsesw,2); ?></td>
				</tr>
				<?php 
					}
					if($winew >0) { ?>
				<tr>
					<td width="10px">b</td>
					<td><?php echo $getwinglassinfo[0]['type_of_Window_Door']; ?></td>
					<td><?php echo $tbl2aglass[0]['Construction_Number'];?></td>
					<td><?php echo $Internal_shade; ?></td>
					<td><?php echo "E/W";?></td>
					<td><?php echo $tbl2aglass[0]['U_Value'];?></td>
					<td><?php echo $tbl2aglass[0]['SHGC'];?></td>
					<td><?php echo $psfvalueew[0]['PSF_Value']; ?></td>
					<td><?php echo $CLFvalueew[0]['CLF'];?></td>
					<td><?php echo $iscvalue[0]['ISC_Ratios']; ?></td>
					<td><?php echo $wsbheathtm = ($htd * $getwinglassinfo[$a]['U_value']); ?></td>
					<td><?php echo number_format($coolhtmdnew,4); ?></td>
					<?php 
					
						if($getwinglassinfo[$a]['Insect_Screen'] == 'Outdoor Full')
						{
							$screenprojadjust = '0.8';
						}
						else if($getwinglassinfo[$a]['Insect_Screen'] == 'Outdoor Half')
						{
							$screenprojadjust = '0.9';	
						}
						else if($getwinglassinfo[$a]['Insect_Screen'] == 'Indoor Full')
						{
							$screenprojadjust = '0.9';
						}
						else 
						{
							$screenprojadjust = '0.95';
						}
						 
					?>
					<td> <?php echo $screenprojadjust; ?> </td>
					<?php $ATHMMew = $coolhtmdnew * $screenprojadjust; ?>
					<td><?php echo number_format($coolhtmdnew,4);?></td>
					<?php
					if($getwinglassinfo[$a]['External_Shading'] > 0)
					{
						$SSOHew = $getwinglassinfo[$a]['External_Shading'];
					}
					else 
					{
						$SSOHew = '0';
					}
					 ?>
					<td><?php echo $SSOHew; ?></td>
					<td><?php echo number_format($coolhtmdnew,4) * '1'; ?></td>
					<td><?php echo number_format($ATHMMew,4) * '1'; ?></td>
					<td><?php if($getwinglassinfo[$a]['SC_Value'] > 0){echo $getwinglassinfo[$a]['SC_Value'];}else{echo '-';} ?></td>
					<?php $htmssew = ($coolhtmdnnenw - $ATHMM) * $getwinglassinfo[$a]['SC_Value'] + $ATHMM; ?>
					<td><?php echo number_format($htmssew,2); ?></td>
					<td><?php echo number_format($coolhtmdnew,4) * '1'; ?></td>
					<td><?php echo number_format($ATHMMew,4) * '1'; ?></td>
					<td><?php echo number_format($htmohew,2); ?></td>
				</tr>	
				<?php 
					}
				if($wn >0) { ?>	
				<tr>
					<td width="10px">b</td>
					<td><?php echo $getwinglassinfo[0]['type_of_Window_Door']; ?></td>
					<td><?php echo $tbl2aglass[0]['Construction_Number'];?></td>
					<td><?php echo $Internal_shade; ?></td>
					<td><?php echo "N";?></td>
					<td><?php echo $tbl2aglass[0]['U_Value'];?></td>
					<td><?php echo $tbl2aglass[0]['SHGC'];?></td>
					<td><?php echo $psfvaluen[0]['PSF_Value']; ?></td>
					<td><?php echo $CLFvaluen[0]['CLF'];?></td>
					<td><?php echo $iscvalue[0]['ISC_Ratios']; ?></td>
					<td><?php echo $wsbheathtm = ($htd * $getwinglassinfo[$a]['U_value']); ?></td>
					<td><?php echo number_format($coolhtmdnn,4); ?></td>
					<?php 
					
						if($getwinglassinfo[$a]['Insect_Screen'] == 'Outdoor Full')
						{
							$screenprojadjust = '0.8';
						}
						else if($getwinglassinfo[$a]['Insect_Screen'] == 'Outdoor Half')
						{
							$screenprojadjust = '0.9';	
						}
						else if($getwinglassinfo[$a]['Insect_Screen'] == 'Indoor Full')
						{
							$screenprojadjust = '0.9';
						}
						else 
						{
							$screenprojadjust = '0.95';
						}
						 
					?>
					<td> <?php echo $screenprojadjust; ?> </td>
					<?php $ATHMMn = $coolhtmdnn * $screenprojadjust; ?>
					<td><?php echo number_format($coolhtmdnn,4);?></td>
					<?php
					if($getwinglassinfo[$a]['External_Shading'] > 0)
					{
						$SSOHn = $getwinglassinfo[$a]['External_Shading'];
					}
					else 
					{
						$SSOHn = '0';
					}
					 ?>
					<td><?php echo $SSOHn; ?></td>
					<td><?php echo number_format($coolhtmdnn,4) * '1'; ?></td>
					<td><?php echo number_format($ATHMMn,4) * '1'; ?></td>
					<td><?php if($getwinglassinfo[$a]['SC_Value'] > 0){echo $getwinglassinfo[$a]['SC_Value'];}else{echo '-';} ?></td>
					<?php $htmssn = ($coolhtmdnnenw - $ATHMM) * $getwinglassinfo[$a]['SC_Value'] + $ATHMM; ?>
					<td><?php echo number_format($htmssn,2); ?></td>
					<td><?php echo number_format($coolhtmdnn,4) * '1'; ?></td>
					<td><?php echo number_format($ATHMMn,4) * '1'; ?></td>
					<td><?php echo number_format($htmohn,2); ?></td>
				</tr>
				<?php 
					}
				if($ws >0) { ?>		
				<tr>
					<td width="10px">b</td>
					<td><?php echo $getwinglassinfo[$a]['type_of_Window_Door']; ?></td>
					<td><?php echo $tbl2aglass[0]['Construction_Number'];?></td>
					<td><?php echo $Internal_shade; ?></td>
					<td><?php echo "S";?></td>
					<td><?php echo $tbl2aglass[0]['U_Value'];?></td>
					<td><?php echo $tbl2aglass[0]['SHGC'];?></td>
					<td><?php echo $psfvalues[0]['PSF_Value']; ?></td>
					<td><?php echo $CLFvalues[0]['CLF'];?></td>
					<td><?php echo $iscvalue[0]['ISC_Ratios']; ?></td>
					<td><?php echo $wsbheathtm = ($htd * $getwinglassinfo[$a]['U_value']); ?></td>
					<td><?php echo number_format($coolhtmdns,4); ?></td>
					<?php 
					
						if($getwinglassinfo[$a]['Insect_Screen'] == 'Outdoor Full')
						{
							$screenprojadjust = '0.8';
						}
						else if($getwinglassinfo[$a]['Insect_Screen'] == 'Outdoor Half')
						{
							$screenprojadjust = '0.9';	
						}
						else if($getwinglassinfo[$a]['Insect_Screen'] == 'Indoor Full')
						{
							$screenprojadjust = '0.9';
						}
						else 
						{
							$screenprojadjust = '0.95';
						}
						 
					?>
					<td> <?php echo $screenprojadjust; ?> </td>
					<?php $ATHMMs = $coolhtmdns * $screenprojadjust; ?>
					<td><?php echo number_format($coolhtmdns,4);?></td>
					<?php
					if($getwinglassinfo[$a]['External_Shading'] > 0)
					{
						$SSOH = $getwinglassinfo[$a]['External_Shading'];
					}
					else 
					{
						$SSOH = '0';
					}
					 ?>
					<td><?php echo $SSOH; ?></td>
					<td><?php echo number_format($coolhtmdns,4) * '1'; ?></td>
					<td><?php echo number_format($ATHMMs,4); ?></td>
					<td><?php if($getwinglassinfo[$a]['SC_Value'] > 0){echo $getwinglassinfo[$a]['SC_Value'];}else{echo '-';} ?></td>
					<?php $htmsss = ($coolhtmdnnenw - $ATHMM) * $getwinglassinfo[$a]['SC_Value'] + $ATHMM; ?>
					<td><?php echo number_format($htmsss,2); ?></td>
					<td><?php echo number_format($coolhtmdns,4) * '1'; ?></td>
					<td><?php echo number_format($ATHMMs,4); ?></td>
					<td><?php echo number_format($htmohs,2); ?></td>
				</tr>
				<?php } ?>
				<?php
				}
				}
				?>
			</table>
		</td>
	</tr>
	</table>
		</td>
	</tr>
	<!-- Worksheet B END -->
	<!-- Worksheet C -->
	<tr>
		<td colspan="8">
			<table border="1">
	<tr style=" text-align:center;">
		<td colspan="8" ><h4>Worksheet C <br/>HTM Values for Skylights Step 1</h4></td>
	</tr>
	<tr>
		<td colspan="8">
			<table border="1" width="100%">
				<tr>
					<td colspan="15"><b>Step 1 - Enter Construction Data</b></td>
				</tr>	
				<tr>
					<td colspan="3"><b>Lat. = </b></td>
					<td colspan="2"><b>HTD = <?php echo $htd; ?></b></td>
					<td colspan="2"><b>CTD = <?php echo $ctd; ?></b></td>
					<td colspan="5"><b>Skylight Construction Data</b></td>
					<td colspan="3"><b>2B-3 Defaults or Custom</b></td>
				</tr>
				<tr>
					<td colspan="2"><b>Type of Skylight</b></td>
					<td><b>Glazing Type</b></td>
					<td><b>Tilt Angle &Oslash;</b></td>
					<td><b>Glazing Faces</b></td>
					<td><b>U-Value 2A or NFRC</b></td>
					<td><b>SHGC 2A or NFRC</b></td>
					<td><b>Curb Height H (In)</b></td>
					<td><b>Curb L x W (SqFt)</b></td>
					<td><b>Curb Size 2B-4</b></td>
					<td><b>Curb Type</b></td>
					<td><b>Light Shaft Type</b></td>
					<td><b>U-Value Curb</b></td>
					<td><b>Lt'shaft Height (Feet) DF = 5.0</b></td>
					<td><b>U-Value Lt'shaft Wall</b></td>
				</tr>
				<tr>
					<td>a</td>
					<td><?php echo $getskylightinfo[0]['Type_of_Skylight']; ?></td>
					<td><?php echo $tblskylight[0]['Glazing_Type']; ?></td>
					<td><?php echo $getskylightinfo[0]['Tilt_Angle']; ?></td>
					<td><?php echo $getskylightinfo[0]['faces']; ?></td>
					<td><?php echo $getskylightinfo[0]['U_value']; ?></td>
					<td><?php echo $getskylightinfo[0]['shgc_value']; ?></td>
					<td><?php echo $getskylightinfo[0]['Curb_Height']; ?></td>
					<td><?php echo $getskylightinfo[0]['Curb_Area']; ?></td>
					<td><?php echo $getskylightinfo[0]['Curb_Size']; ?></td>
					<td><?php echo $Curb_Construction; ?></td>
					<?php
					if($getskylightinfo[0]['Light_Shaft_Material'] == 'Plywood Shaft' && ($getskylightinfo[0]['Light_Shaft_Height'] >= 0 || $getskylightinfo[0]['Light_Shaft_Height'] == ''))
					{
						$lightshafttype = '';
						$uval_ltshaft = '';
					}
					else 
					{
						$lightshafttype = $getskylightinfo[0]['Light_Shaft_Material'];
						$uval_ltshaft = $tbl2b3_default_u_values[0]['Default_U_Value_Ushaft'];
					}
					?>
					<td><?php echo $lightshafttype; ?></td>
					<td><?php echo $tbl2b3_default_u_values[0]['Default_U_Value_Ucurb']; ?></td>
					<td><?php echo $getskylightinfo[0]['Light_Shaft_Height']; ?></td>
					<td><?php echo $uval_ltshaft; ?></td>
				</tr>				
				
				<tr>
					<td colspan="15"><b>Step 2 - Calculate Ueff for Skylight, Curb and Light Shaft</b></td>
				</tr>
				<tr>
					<td colspan="5"><b>Data from Step 1</b></td>
					<td colspan="2"><b>2B-3 Defaults</b></td>
					<td><b>Curb</b></td>
					<td colspan="3"><b>Custom Curb</b></td>
					<td colspan="4"><b>Custom Shaft</b></td>
				</tr>
				<tr>
					<td colspan="3"><b>UNFRC Panel</b></td>
					<td><b>Ucurb</b></td>
					<td><b>Ushaft</b></td>
					<td><b>ARcurb</b></td>
					<td><b>ARshaft</b></td>
					<td><b>Perim &rsquo; tr P (Ft)</b></td>
					<td><b>Apanel</b></td>
					<td><b>Acurb</b></td>
					<td><b>ARcurb</b></td>
					<td><b>Apanel</b></td>
					<td><b>Ashaft</b></td>
					<td><b>ARshaft</b></td>
					<td><b>Asm'bly<sub> Ueff</sub></b></td>
				</tr>
				
				<tr>
					<td>a</td>
					<td colspan="2"><?php echo $getskylightinfo[0]['U_value']; ?></td>
					<td><?php echo $tbl2b3defaultuvalue[0]['Default_U_Value_Ucurb']; ?></td>
					<td><?php echo $tbl2b3defaultuvalue[0]['Default_U_Value_Ushaft']; ?></td>
					<td><?php echo number_format($arcurb,3); ?></td>
					<td><?php echo $arshaft; ?></td>
					<td><?php echo $p; ?></td>
					<td><?php echo $getskylightinfo[0]['Curb_Area']; ?></td>
					<td><?php echo number_format($acurb,3); ?></td>
					<td><?php echo number_format($arcurb,3); ?></td>
					<td><?php echo $getskylightinfo[0]['Curb_Area']; ?></td>
					<td><?php echo $ashaft; ?></td>
					<td><?php echo $arshaft; ?></td>
					<td><?php echo $ueff; ?></td>					
				</tr>
				
				<tr>
					<td colspan="15"><b>Step 3 - Calculate the heating and Cooling HTM Values for Skylight Assembly</b></td>
				</tr>
				<tr>
					<td colspan="3" rowspan="2"><b>Construction Number</b></td>
					<td colspan="4"><b>Horizontal</b></td>
					<td colspan="4"><b>Vertical</b></td>
					<td rowspan="2"><b>Sol H + Sol V</b></td>
					<td colspan="3">HTD SHGC and CTD from Step 1 Ueff from Step 2</td>
				</tr>
				<tr>
					<td><b>Cos Ø</b></td>
					<td><b>PSF 3D-2</b></td>
					<td><b>CLFavg 3D-3</b></td>
					<td><b>Sol <sub>H</sub></b></td>
					<td><b>Sine Ø</b></td>
					<td><b>PSF 3D-2</b></td>
					<td><b>CLFavg 3D-3</b></td>
					<td><b>Sol <sub>V</sub></b></td>
					<td><b>Heat HTM</b></td>
					<td colspan="2"><b>Cool HTM</b></td>
				</tr>
				<tr>
					<td>a</td>
					<td colspan="2"></td>
					<td><?php echo $getskylightinfo[0]['Tilt_Angle']; ?></td>
					<td> 1 </td>
					<td> 1 </td>
					<td><?php echo $solh; ?></td>
					<td><?php echo $getskylightinfo[0]['Tilt_Angle']; ?></td>
					<td>1</td>						
					<td>1</td>
					<td><?php echo $solv; ?></td>
					<td><?php echo $com = $solv + $solh; ?></td>
					<td><?php echo number_format($heathtm,2); ?></td>
					<td colspan="2"><?php echo number_format($coolhtm,2); ?></td>					
				</tr>
				
			</table>
		</td>
	</tr>
	</table>	
		</td>
	</tr>
	<!-- Worksheet C END -->	
	<!-- Worksheet D -->	
	<tr>
		<td colspan="8">
			<table border="1">
		<tr style=" text-align:center;">
			<td colspan="8" ><h4>Worksheet D<br/>HTM Values and Net Area for Opaque Panels</h4></td>
		</tr>
		<tr>
			<td colspan="8">
				<table border="1">
				<tr>
					<td colspan="2">Construction Number and Exposure Direction, or Ceiling Slope</td>
					<td colspan="2">HTD = <?php echo $htd; ?></td>
					<td colspan="2">CTD = <?php echo $ctd; ?></td>
					<td colspan="3">Daily Range = <?php echo $getval_of_wa[0]['Daily_Range']; ?></td>
					<td colspan="5">
						Heating HTM = U x HTD or U x PTDH</br>
						Cooling HTM = U x CLTD or U x PTDC
					</td>			
				</tr>
				<tr>
					<td colspan="2"></td>
					<td>Length (Ft)</td>				
					<td>Average Height / Width (Ft)</td>
					<td>Gross Area (SqFt)</td>
					<td>Opening Area (SqFt)</td>
					<td>Net Area (SqFt)</td>
					<td>Slab Edge (Ft)</td>
					<td>U-Value or Slab F-Value 4A</td>
					<td>HTD or PTDH</td>
					<td>Group Number 4A</td>
					<td>CLTD 4B or PTDC</td>
					<td>Heating HTM</td>
					<td>Cooling HTM</td>						
				</tr>
				<tr style=" text-align:left;">
					<td colspan="15" >Wood and Metal Doors (Construction 11) </td>
				</tr>
				<?php
				//if(count($getdoors_info) > 0)
				//{
				//for($a=0;$a < count($getdoors_info);$a++){
				?>
				<tr>
					<td>a</td>
					<td><?php echo $construction_number[0]['Construction_Number']; ?></td>
					<?php $avghw = $getdoors_info[0]['height'] / '12';?>
					<?php $heatHTM = $getdoors_info[0]['U_value'] * $htd; ?>
					<?php $coolHTM = $getdoors_info[0]['U_value'] * $gettbl_woodmetaldoor[0]['CLTD_Value']; ?>
					<?php $openingarea = $getdoors_info[0]['glass'] * $grossarea; ?>
					<?php $lenght = $getdoors_info[0]['width'] / '12'; ?>
					<td><?php echo number_format($lenght,2); ?></td>
					<td><?php echo number_format($avghw,2); ?></td>
					<td><?php echo $grossarea; ?></td>
					<td><?php echo $openingarea; ?></td>
					<td><?php echo $wkDnetarea = $grossarea - $openingarea; ?></td>
					<td><?php echo $getfloormaster_info[0]['slab_edge']; ?></td>
					<?php //if($getfloormaster_info[0]['concrete_slab_GF'] == 'Concrete Slab on Grade Floor') 
					//{
						//$UValue_SlabF_Value	= $getdoors_info[0]['U_value'];
					//}
					//else
					//{
						//$UValue_SlabF_Value	= 'N/A';
					//}					
					?>
					<td><?php echo $getdoors_info[0]['U_value']; ?></td>
					<td><?php echo $htd; ?></td>
					<td>N/A</td>
					<td><?php echo $gettbl_woodmetaldoor[0]['CLTD_Value'];?></td>
					<td><?php echo $heatHTM;?></td>
					<td><?php echo $coolHTM;?></td>						
				</tr>
				<?php
				//}
				//}
				?>
				<tr>
					<td>b</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>				
				<tr style=" text-align:left;">
					<td colspan="15">Above Grade Walls (Construction 12, 13 and 14)</td>
				</tr>
				<?php
				if($getabovegrade_walls_master[0]['outsidewall'] == 'Outside Walls')
				{
					$construct = 'Wall';
				}
				else 
				{
					$construct = 'Partition';	
				}	
				?>	
				<?php
				if($project_id > 0)
				{
					$table4b_wall_cltd_values = $obj->table4b_wall_cltd_values($Group_Number,$getval_of_wa[0]['Daily_Range'],$ctd,$construct);
				}
				?>			
				<?php
				if($getabovegrade_walls_master[0]['outsidewall'] == 'Outside Walls')
				{
				?>
				<tr>
					<td>a</td>
					<td>N/A</td>
					<?php //$getfloor_info[0]['zone']; ?>
					<td><?php echo "all"; ?></td>
					<td><?php echo $gethouseinfo_master[0]['avg_ceiling_height'];?></td>					
					<td><?php echo $grossareasec2agw = $getabovegrade_walls_master[0]['ne_nw'] + $getabovegrade_walls_master[0]['e_w'] + $getabovegrade_walls_master[0]['se_sw'] + $getabovegrade_walls_master[0]['n'] + $getabovegrade_walls_master[0]['s']; ?></td>					
					<td><?php echo $openareastep2  = $getwinglassinfo[0]['ne_nw'] + $getwinglassinfo[0]['e_w'] + $getwinglassinfo[0]['se_sw'] + $getwinglassinfo[0]['n'] + $getwinglassinfo[0]['s'] + $wkDnetarea; ?></td>
					<td><?php echo $netarea = $grossareasec2agw - $openareastep2; ?></td>
					<td>N/A</td>
					<td><?php echo $getabovegrade_walls_master[0]['U_value'];?></td>
					<td><?php echo $htd; ?></td>
					<td><?php echo $Group_Number; ?></td>
					<td><?php echo $table4b_wall_cltd_values[0]['CLTD_Value']; ?></td>
					<td><?php echo $heatingHTM = $htd * $getabovegrade_walls_master[0]['U_value'];?></td>
					<td><?php echo $abgwcolhtm = $getabovegrade_walls_master[0]['U_value'] * $table4b_wall_cltd_values[0]['CLTD_Value']; ?></td>						
				</tr>
				<?php
				}
				else
				{
				?>
				<tr>
					<td>a</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<?php } ?>				
				<tr>
					<td>b</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<tr>
					<td>c</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<tr style=" text-align:left;">
					<td colspan="15">Partition Walls (Construction 12, 13 and 14) - Use estimated partition temperature dierence for heating (PTDH) and cooling (PTDC)</td>
				</tr>
				<?php
				if($getabovegrade_walls_master[0]['partition'] == 'Partition')
				{
				?>
				<tr>
					<td>a</td>
					<td>N/A</td>
					<td><?php echo "all"; ?></td>
					<td><?php echo $gethouseinfo_master[0]['avg_ceiling_height'];?></td>
					<td><?php echo $wkdptoin_garea = $getabovegrade_walls_master[0]['ne_nw'] + $getabovegrade_walls_master[0]['e_w'] + $getabovegrade_walls_master[0]['se_sw'] + $getabovegrade_walls_master[0]['n'] + $getabovegrade_walls_master[0]['s'] * $gethouseinfo_master[0]['avg_ceiling_height']; ?> </td>
					<td><?php echo $area_sqft; ?></td>
					<td><?php echo $netarea = $wkdptoin_garea - $area_sqft; ?></td>
					<td>N/A</td>
					<td><?php echo $getabovegrade_walls_master[0]['U_value'];?></td>
					<td><?php echo $htd; ?></td>
					<td><?php echo $Group_Number; ?></td>
					<td><?php echo $table4b_wall_cltd_values[0]['CLTD_Value']; ?></td>
					<td><?php echo $heatingHTM = $htd * $getabovegrade_walls_master[0]['U_value'];?></td>
					<td><?php echo $abgwcolhtm = $getabovegrade_walls_master[0]['U_value'] * $table4b_wall_cltd_values[0]['CLTD_Value']; ?></td>						
				</tr>
				<?php
				}
				else
				{
				?>
				<tr>
					<td>a</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<?php } ?>
				<tr>
					<td>b</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				
				<tr style=" text-align:left;">
					<td colspan="15">Below Grade Walls (Construction 15)</td>
				</tr>
				<tr>
					<td>a</td>
					<td>N/A</td>
					<td><?php echo "all"; ?></td>
					<td><?php echo $gethouseinfo_master[0]['avg_ceiling_height'];?></td>
					<td><?php echo $grossarea_ofBGW = $getbelowgrade_walls_master[0]['area'] * $getbelowgrade_walls_master[0]['avg_dbg']; ?></td>
					<td><?php echo $area_sqft; ?></td>
					<td><?php echo $area_sqft * $area_sqft; ?></td>
					<td>N/A</td>
					<td><?php echo $getbelowgrade_walls_master[0]['U_value']; ?></td>
					<td><?php echo $htd; ?></td>
					<td>N/A</td>
					<td>N/A</td>
					<td><?php echo $bgwheatingHTM = $getbelowgrade_walls_master[0]['U_value'] * $htd;?></td>
					<td>N/A</td>						
				</tr>
				<tr>
					<td>b</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				
				<tr style=" text-align:left;">
					<td colspan="15">Ceilings (Construction 16, 17 and 18) - For sloped ceiling, note slope angle in degrees; then Gross Area = (L x W) / Cosine of slope angle</td>
				</tr>
				<tr>
					<td>a</td>
					<td>N/A</td>
					<td><?php //echo $External_Shading; ?></td>
					<td><?php //echo $gethouseinfo_master[0]['avg_ceiling_height'];?></td>
					<td><?php echo $grossarea; ?></td>
					<td><?php echo $getskylightinfo[0]['Curb_Area']; ?></td>
					<td><?php echo $wkDceling_netarea = $grossarea - $getskylightinfo[0]['Curb_Area']; ?></td>
					<td>N/A</td>
					<td><?php echo $getceilings_master[0]['U_value'];?></td>
					<td><?php echo $htd; ?></td>
					<td>N/A</td>
					<td><?php echo $tbl4aceiling[0]['CLTD_Value']; ?></td>
					<td><?php echo $ceiling_heatingHTM = $getceilings_master[0]['U_value'] * $htd;?></td>
					<td><?php echo $ceiling_coolingHTM = $getceilings_master[0]['U_value'] * $tbl4aceiling[0]['CLTD_Value'];?></td>						
				</tr>
				<tr>
					<td>b</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				
				<tr style=" text-align:left;">
					<td colspan="15">Partition Ceilings (Construction 16) - Use estimated partition temperature dierence for heating (PTDH) and cooling (PTDC)</td>
				</tr>
				<tr>
					<td>a</td>
					<td>N/A</td>
					<td><?php //echo $External_Shading; ?></td>
					<td><?php //echo $gethouseinfo_master[0]['avg_ceiling_height'];?></td>
					<td><?php echo $grossarea; ?></td>
					<td><?php echo $area_sqft; ?></td>
					<td><?php echo $area_sqft * $area_sqft; ?></td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<tr>
					<td>b</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				
				<tr style=" text-align:left;">
					<td colspan="15">Passive Floors (Construction Numbers 20, 21 and 22) - Note: Use F-value and running feet of exposed edge for slab floors</td>
				</tr>
				<?php
				//echo $htd;
				//echo $getfloors_masterinfo[0]['floor_ins'];
				//echo $getfloors_masterinfo[0]['floor_cover'];				
				if($getfloors_masterinfo[0]['floor_over_ucsb'] != 'Floor over Enclosed Unconditioned Crawl Space or Basement')
				{
						
					$tbl_4a_partitionfloorhtg = $obj->tbl_4a_partitionfloorhtg($getfloors_masterinfo[0]['floor_over_ucsb'],$getfloors_masterinfo[0]['floor_ins'],$getfloors_masterinfo[0]['floor_cover'],$htd);
				?>
				<tr>
					<td>a</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td><?php echo $getfloors_masterinfo[0]['area']; ?></td>
					<td>N/A</td>
					<td><?php echo $area_sqft * $area_sqft; ?></td>
					<td>N/A</td>
					<td><?php echo $getfloors_masterinfo[0]['U_value']; ?></td>
					<td><?php echo $getval_of_wa[0]['Heating_DR_99']; ?></td>
					<td>N/A</td>
					<td>N/A</td>
					<td><?php echo $pfheatingHTM = $getfloors_masterinfo[0]['U_value'] * $getval_of_wa[0]['Heating_DR_99']; ?></td>
					<td>N/A</td>						
				</tr>
				<?php 
				}
				else
				{
				?>
				<tr>
					<td>a</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<?php 
				}
				?>
				<tr>
					<td>b</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<tr>
					<td>c</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<tr style=" text-align:left;">
					<td colspan="15">Passive Partition Floors (Construction Number 19) - Use Table 4A-19 PTDH for heating and PTDC for cooling</td>
				</tr>
				<?php
				//echo $getfloors_masterinfo[0]['floor_type'];
				//echo $getfloors_masterinfo[0]['wall_ins'];
				//echo $getfloors_masterinfo[0]['tightness'];
				
				if($getfloors_masterinfo[0]['floor_over_ucsb'] == 'Floor over Enclosed Unconditioned Crawl Space or Basement')
				{
					$tbl_4a_partitionfloorhtg = $obj->tbl_4a_partitionfloorhtg($getfloors_masterinfo[0]['floor_over_ucsb'],$getfloors_masterinfo[0]['floor_type'],$getfloors_masterinfo[0]['wall_ins'],$getfloors_masterinfo[0]['tightness'],$getfloors_masterinfo[0]['floor_ins'],$getfloors_masterinfo[0]['floor_cover'],$htd);
				?>
				<tr>
					<td>a</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td><?php echo $getfloors_masterinfo[0]['area']; ?></td>
					<td>N/A</td>
					<td><?php echo $area_sqft * $area_sqft; ?></td>
					<td>N/A</td>
					<td><?php echo $getfloors_masterinfo[0]['U_value']; ?></td>
					<td><?php echo $tbl_4a_partitionfloorhtg[0]['PTDH'];?></td>
					<td>N/A</td>
					<td>N/A</td>
					
					<td><?php echo $ppfheatingHTM = $getfloors_masterinfo[0]['U_value'] * $tbl_4a_partitionfloorhtg[0]['PTDH'];?></td>
					<td>N/A</td>						
				</tr>
				<?php 
				}
				else
				{
				?>
				<tr>
					<td>a</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<?php 
				}
				?>
				<tr>
					<td>b</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<tr>
					<td>c</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<tr style=" text-align:left;">
					<td colspan="15">Radiant Floors (Construction Numbers 20, 21 and 22) - Note: Use F-value and running feet of exposed edge for slab floors</td>
				</tr>
				<tr>
					<td>a</td>
					<td>N/A</td>
					<td><?php echo $External_Shading; ?></td>
					<td><?php echo $gethouseinfo_master[0]['avg_ceiling_height'];?></td>
					<td><?php echo $grossarea; ?></td>
					<td><?php echo $area_sqft; ?></td>
					<td><?php echo $area_sqft * $area_sqft; ?></td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<tr>
					<td>b</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<tr>
					<td>c</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<tr style=" text-align:left;">
					<td colspan="15">Radiant Partition Floors (Construction Number 19) - Use Table 4A-19 PTDH for heating and PTDC for cooling</td>
				</tr>
				<tr>
					<td>a</td>
					<td>N/A</td>
					<td><?php echo $External_Shading; ?></td>
					<td><?php echo $gethouseinfo_master[0]['avg_ceiling_height'];?></td>
					<td><?php echo $grossarea; ?></td>
					<td><?php echo $area_sqft; ?></td>
					<td><?php echo $area_sqft * $area_sqft; ?></td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>
				<tr>
					<td>b</td>
					<td>N/A</td>
					<td>N/A</td>				
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>						
				</tr>				
				
				</table>
			</td>
		
		</tr>
	</table>
		</td>
	</tr>
	<!-- Worksheet D END -->	
	
	<!-- Worksheet E -->	
	<tr>
		<td colspan="8">
			<table width="100%" border="1">
	<tr style=" text-align:center;">
		<td colspan="8" ><h4>Worksheet E<br/>Infiltration Loads HTD</h4></td>
	</tr>
	<tr>
		<td colspan="8">
			<table border="1" width="100%">
				<tr>
					<td colspan="2">HTD = <?php echo $htd; ?></td>
					<td colspan="2">CTD = <?php echo $ctd; ?></td>
					<td colspan="2">Design Grains = <?php echo $getval_of_wa[0]['DG_50_RH']; ?></td>
					<td colspan="2">Elevation = <?php echo $getval_of_wa[0]['Elevation_Ft']; ?></td>
					<td colspan="2">Table 10A ACF = <?php echo $table10a[0]['ACF']; ?> </td>
				</tr>
				<tr>
					<td colspan="10">Step 1 - Table 8 Outdoor Air Requirement</td>
				</tr>
				<tr>
					<td>Operating Mode</td>
					<td>Above Grade Volume AGV (CuFt)</td>
					<td>Number of Bed Rooms</td>
					<td>Number of People</td>
					<td>Default Burner Btuh</td>
					<td>Installed Burner Btuh</td>
					<td>OA Cfm for 0.35 ACH</td>
					<td>OA Cfm for People</td>
					<td>OA Cfm for Furnace</td>
					<td>Table 8 OA Cfm</td>
				</tr>
				<tr>
					<td><b>Heat</b></td>
					<td><?php echo $abovegradevol; ?></td>
					<td><?php echo $numofbedroom; ?></td>
					<td><?php echo $numofpeople; ?></td>
					<td>N/A</td>
					<td>N/A</td>
					<td><?php echo number_format($oacfmach,2); ?></td>
					<td><?php echo $oacfmpeople = ('20' * $numofpeople); ?></td>
					<td><?php echo $oacfm_furnace = '0.5' * (0) / 1000 ;?></td>
					<?php
					if($oacfmach > $oacfmpeople)
					{
						$table8oacfm = $oacfmach;
					}
					else if($oacfmpeople > $oacfmach)
					{
						$table8oacfm = $oacfmpeople;
					}
					else
					{
						$table8oacfm = $oacfm_furnace;
					}
					?>
					<td><?php echo number_format($table8oacfm,2); ?></td>
				</tr>
				<tr>
					<td><b>Cool</b></td>
					<td><?php echo $abovegradevol; ?></td>
					<td><?php echo $numofbedroom; ?></td>
					<td><?php echo $numofpeople; ?></td>
					<td>N/A</td>
					<td>N/A</td>
					<td><?php echo number_format($oacfmach,2); ?></td>
					<td><?php echo $oacfmpeople = ('20' * $numofpeople); ?></td>
					<td><?php echo $oacfm_furnace = '0.5' * (0) / 1000 ;?></td>
					<?php
					if($oacfmach > $oacfmpeople)
					{
						$table8oacfm = $oacfmach;
					}
					else if($oacfmpeople > $oacfmach)
					{
						$table8oacfm = $oacfmpeople;
					}
					else
					{
						$table8oacfm = $oacfm_furnace;
					}
					?>
					<td><?php echo number_format($table8oacfm,2); ?></td>
				</tr>
				
				<tr>
					<td colspan="10">Step 2, Option 1 - Table 5 Defaults</td>
				</tr>	
				<tr>
					<td>Operating Mode</td>
					<td>Floor Area (SqFt)</td>
					<td>Type of Const.</td>
					<td>Space ACH</td>
					<td>AGV (CuFt)</td>
					<td>Space ICFM</td>
					<td>Fireplace ICFM</td>
					<td>Total ICFM (Note 1) (Note 2)</td>
					<td>Table 8 OA CFM</td>
					<td>Table 8 Vent CFM</td>
				</tr>				
				
				<tr>
					<td><b>Heat</b></td>
					<td><?php echo $getfloormaster_info[0]['area']; ?></td>
					<td><?php echo $gethouseinfo_master[0]['type_of_construction'];?></td>					
					<td><?php echo $tbl5a5b[0]['air_changes']; ?></td>
					<td><?php echo $abovegradevol; ?></td>
					<?php $spaceICFM = ($tbl5a5b[0]['air_changes'] * $abovegradevol) / '60'; ?>
					<td><?php echo number_format($spaceICFM,2); ?></td>
					<td><?php echo $tbl5a5b[0]['Infiltration_CFM_For_1_Fireplace']; ?></td>
					<?php $totalICFM = $tbl5a5b[0]['Infiltration_CFM_For_1_Fireplace'] + $spaceICFM; ?>
					<td><?php echo number_format($totalICFM,2); ?></td>
					<td rowspan="2"><?php echo $oacfm_furnace = '0.5' * (0) / 1000 ;?></td>
					<?php if($tbl5a5b[0]['Infiltration_CFM_For_1_Fireplace'] > $totalICFM)
					{
						$table8ventcfm = $tbl5a5b[0]['Infiltration_CFM_For_1_Fireplace'];
					}
					else if($totalICFM > $tbl5a5b[0]['Infiltration_CFM_For_1_Fireplace'])
					{
						$table8ventcfm = $totalICFM;
					}
					else
					{
						$table8ventcfm = $oacfm_furnace;
					}
					?>
					<td rowspan="2"><?php echo number_format($table8ventcfm,2); ?></td>
				</tr>
				<tr>
					<td><b>Cool</b></td>
					<td><?php echo $getfloormaster_info[0]['area']; ?></td>
					<td><?php echo $gethouseinfo_master[0]['type_of_construction'];?></td>
					<?php
					if(!empty($gethouseinfo_master[0]['type_of_construction']))
					{
						$gethouseinfo_master[0]['house_type'];	
						$tbl5a5b1 = $obj->tbl5a5b1($gethouseinfo_master[0]['type_of_construction'],$gethouseinfo_master[0]['house_type'],$gethouseinfo_master[0]['conditioned_sqft']);
					}
					?>
					<td><?php echo $tbl5a5b1[0]['air_changes']; ?></td>
					<td><?php echo $abovegradevol; ?></td>
					<?php $spaceICFM = ($tbl5a5b1[0]['air_changes'] * $abovegradevol) / '60'; ?>
					<td><?php echo number_format($spaceICFM,2); ?></td>
					<td><?php echo $tbl5a5b1[0]['Infiltration_CFM_For_1_Fireplace']; ?></td>
					<?php $totalICFM = $tbl5a5b1[0]['Infiltration_CFM_For_1_Fireplace'] + $spaceICFM; ?>
					<td><?php echo number_format($totalICFM,2); ?></td>								
				</tr>
				<tr>
					<td colspan="10">Step 2, Option 2 - Component Leakage Area Method</td>
				</tr>	
					<tr>
						<td rowspan="2">Operating Mode</td>
						<td rowspan="2">HTD and CTD</td>
						<td rowspan="2">Wind Velocity (MPH)</td>
						<td rowspan="2">Table 5C ELA4 (SqIn)</td>
						<td colspan="3" align="center">Table 5D</td>
						<td rowspan="2">ICFM</td>						
						<td rowspan="2">Table 8 OA CFM</td>
						<td rowspan="2">Table 8 Vent CFM</td>
					</tr>
					<tr>						
						<td>Cs</td>
						<td>Shielding Class</td>
						<td>Cw</td>						
					</tr>					
					<tr>
						<td><b>Heat</b></td>
						<td><?php echo $htdctd; ?></td>
						<td> 15 </td>
						<td rowspan="2">N/A</td>
						<td rowspan="2">N/A</td>
						<td rowspan="2">N/A</td>
						<td rowspan="2">N/A</td>
						<td>N/A</td>						
						<td rowspan="2">N/A</td>
						<td rowspan="2">N/A</td>
					</tr>
					<tr>
						<td><b>Cool</b></td>
						<td><?php echo $htdctd; ?></td>						
						<td> 7.5 </td>
						<td>N/A</td>												
					</tr>
				
					<tr>
						<td colspan="10">Step 2, Option 3 - Blower Door Method</td>
					</tr>	
					<tr>
						<td rowspan="2">Operating Mode</td>
						<td rowspan="2">HTD and CTD</td>
						<td rowspan="2">Wind Velocity (MPH)</td>
						<td rowspan="2">Table 5C ELA4 (SqIn)</td>
						<td colspan="3" align="center">Table 5D</td>
						<td rowspan="2">ICFM</td>						
						<td rowspan="2">Table 8 OA CFM</td>
						<td rowspan="2">Table 8 Vent CFM</td>
					</tr>
					<tr>						
						<td>Cs</td>
						<td>Shielding Class</td>
						<td>Cw</td>						
					</tr>
										
					<tr>
						<td><b>Heat</b></td>
						<td><?php echo $htdctd; ?></td>
						<td> 15 </td>
						<td rowspan="2">N/A</td>
						<td rowspan="2">N/A</td>
						<td rowspan="2">N/A</td>
						<td rowspan="2">N/A</td>
						<td>N/A</td>						
						<td rowspan="2">N/A</td>
						<td rowspan="2">N/A</td>
					</tr>
					<tr>
						<td><b>Cool</b></td>
						<td><?php echo $htdctd; ?></td>						
						<td> 7.5 </td>
						<td>N/A</td>												
					</tr>
					<tr>
						<td colspan="10">Step 3 - Infiltration Loads on Central Equipment</td>
					</tr>	
					<tr>
						<td>Type of Load</td>
						<td>Wrksht. H Value for Vent CFM</td>
						<td>Exhaust CFM</td>
						<td>CFMimb</td>
						<td>ICFM (Option __ )</td>
						<td>Net Infilt. CFM NCFM</td>						
						<td colspan="4">H & C Loads (Btuh)</td>								
					</tr>
					
					<tr>						
						<td>Heat Load</td>
						<td><?php echo number_format($PractitionerspecifiedVCFM,2); ?></td>
						<td>N/A</td>						
						<td>N/A</td>
						<td><?php echo number_format($totalICFM,2); ?></td>
						<td><?php echo $tbl5a5b[0]['Infiltration_CFM_For_1_Fireplace']; ?></td>
						<td><?php echo $Estep3heatload = '1.1' * $table10a[0]['ACF'] * $tbl5a5b[0]['Infiltration_CFM_For_1_Fireplace'] * $getval_of_wa[0]['Heating_DR_99']; ?></td>
					</tr>
					<tr>						
						<td>Sens Load</td>
						<td rowspan="2">N/A</td>
						<td rowspan="2">N/A</td>	
						<td rowspan="2">N/A</td>
						<td rowspan="2">N/A</td>
						<td rowspan="2">N/A</td>
						<td><?php echo $Estep3sensload = '1.1' * $table10a[0]['ACF'] * $tbl5a5b[0]['Infiltration_CFM_For_1_Fireplace'] * $getval_of_wa[0]['Cooling_DB_1']; ?></td>
					</tr>
					<tr>						
						<td>Lat Load</td>
						<td><?php echo $Estep3latload = '0.68' * $table10a[0]['ACF'] * $tbl5a5b[0]['Infiltration_CFM_For_1_Fireplace'] * $getval_of_wa[0]['DG_50_RH']; ?></td>																	
					</tr>								
			</table>
		</td>
	</tr>
	</table>
		</td>
	</tr>
	<!-- End Worksheet E -->
	
	<!--Worksheet F-->
	<tr style=" text-align:center;">
		<td colspan="8" ><h4>Worksheet F <br/>Internal Loads</h4></td>
	</tr>
	<tr>
		<td colspan="8">
			<table border="1" width="100%">
				<tr>
					<th colspan="2">Source of Internal Load</th>
					<th>Count</th>
					<th>Sensible Factor (Btuh)</th>
					<th>Latent Factor (Btuh)</th>
					<th>Load Factor</th>
					<th>Use Factor</th>
					<th>Sensible Load (Btuh)</th>
					<th>Latent Load (Btuh)</th>
				</tr>
				<tr>
					<td width="10px" rowspan="3"><b>a</b></td>
					<td colspan="9"><b>Occupants</b></td>
				</tr>
				<tr>
					<td>Default = Number bedrooms + 1</td>
					<td><?php echo $numbd = $numofbedroom + '1'; ?></td>
					<td><?php echo $senfector = $numbd * '230'; ?></td>
					<td><?php echo $latfector = $numbd * '200'; ?></td>
					<td><?php echo $loadfector = $numbd * '1.0'; ?></td>
					<td><?php echo $usefector = $numbd * '1.0'; ?></td>
					<td><?php echo $sensibleload = ($numbd * $senfector * $loadfector * $usefector);?></td>
					<td><?php echo $latentload = ($numbd * $latfector * $loadfector * $usefector);?></td>
				</tr>	
				<tr>
					<td>Additional specified by designer</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td><?php echo $sensibleload = ($numbd * $senfector * $loadfector * $usefector);?></td>
					<td><?php echo $latentload = ($numbd * $latfector * $loadfector * $usefector);?></td>
				</tr>	
				<tr>
					<td colspan="7" style="text-align: right;">Total occupancy loads for Form J1 (Btuh) =</td>
					<td><?php echo $sensibleload + $sensibleload;?></td>
					<td><?php echo $latentload + $latentload;?></td>
				</tr>
				
				<tr>
					<td width="10px" rowspan="5"><b>b</b></td>
					<td colspan="9"><b>Default Scenario</b></td>
				</tr>
				<tr>
					<td>Refrigerator and range / or dishwasher (A)</td>
					<td>N/A</td>
					<td>1,200</td>
					<td>N/A</td>
					<td rowspan="3">1.0</td>
					<td rowspan="3">1.0</td>
					<td><?php echo $sensibleload_sectionB1 = 0 * 1200 * 1.0 * 1.0; ?></td>
					<td><?php echo $latentload_sectionB1 = 0 * 1.0 * 1.0; ?></td>
				</tr>	
				<tr>
					<td>Scenario option 1</td>
					<td>N/A</td>
					<td>2,400</td>
					<td>N/A</td>					
					<td><?php echo $sensibleload_sectionB2 = 0 * 2400 * 1.0 * 1.0; ?></td>
					<td><?php echo $latentload_sectionB2 = 0 * 1.0 * 1.0; ?></td>
				</tr>	
				<tr>
					<td>Scenario option 1</td>
					<td>N/A</td>
					<td>3,400</td>
					<td>N/A</td>
					<!--<td colspan="2" width="10px"></td>-->
					<td><?php echo $sensibleload_sectionB2 = 0 * 3400 * 1.0 * 1.0; ?></td>
					<td><?php echo $latentload_sectionB3 = 0 * 1.0 * 1.0; ?></td>
				</tr>
				<tr>
					<td colspan="6" style="text-align: right;">Default scenario load for Form J1 (Btuh) =</td>
					<td><?php echo $sensloadtotal_sectionB = $sensibleload_sectionB1 + $sensibleload_sectionB2 + $sensibleload_sectionB3; ?></td>
					<td><?php echo $latloadtotal_sectionB = $latentload_sectionB1 + $latentload_sectionB2 + $latentload_sectionB3; ?></td>
				</tr>					
				<tr>
					<td width="10px" rowspan="7"><b>c</b></td>
					<td colspan="9"><b>Adjustments to Default Scenario</b></td>
				</tr>
				<tr>
					<td>Unvented range and / or dishwasher (A)</td>
					<td>N/A</td>
					<td>850</td>
					<td>800</td>
					<td rowspan="5">1.0</td>
					<td rowspan="5">1.0</td>
					<td><?php echo $sensibleload_sectionC1 = 0 * 850 * 1.0 * 1.0; ?></td>
					<td><?php echo $latentload_sectionC1 = 0 * 800 * 1.0 * 1.0; ?></td>
				</tr>	
				<tr>
					<td>Water bed (B)</td>
					<td>N/A</td>
					<td>450</td>
					<td>N/A</td>
					
					<td><?php echo $sensibleload_sectionC2 = 0 * 450 * 1.0 * 1.0; ?></td>
					<td><?php echo $latentload_sectionC2 = 0 * 1.0 * 1.0; ?></td>
				</tr>	
				<tr>
					<td>Ceiling fan (C)</td>
					<td>N/A</td>
					<td>250</td>
					<td>N/A</td>
					
					<td><?php echo $sensibleload_sectionC3 = 0 * 250 * 1.0 * 1.0; ?></td>
					<td><?php echo $latentload_sectionC3 = 0 * 1.0 * 1.0; ?></td>
				</tr>
				<tr>
					<td>Heavy use of equipment and appliances (D)</td>
					<td>N/A</td>
					<td>1,400</td>
					<td>N/A</td>
					
					<td><?php echo $sensibleload_sectionC4 = 0 * 1400 * 1.0 * 1.0; ?></td>
					<td><?php echo $latentload_sectionC4 = 0 * 1.0 * 1.0; ?></td>
				</tr>
				<tr>
					<td>500 Watt allowance for lighting load (E)</td>
					<td>N/A</td>
					<td>1,705</td>
					<td>N/A</td>
					
					<td><?php echo $sensibleload_sectionC5 = 0 * 1705 * 1.0 * 1.0; ?></td>
					<td><?php echo $latentload_sectionC5 = 0 * 1.0 * 1.0; ?></td>
				</tr>
				
				
				<tr>
					<td colspan="6" style="text-align: right;">Total for adjustment options for Form J1 (Btuh) =</td>
					<td><?php echo $sensloadtotal_sectionC = $sensibleload_sectionC1 + $sensibleload_sectionC2 + $sensibleload_sectionC3 +$sensibleload_sectionC4 + $sensibleload_sectionC5; ?></td>
					<td><?php echo $latloadtotal_sectionC = $latentload_sectionC1 + $latentload_sectionC2 + $latentload_sectionC3 + $latentload_sectionC4 + $latentload_sectionC5; ?></td>
				</tr>	
				
				<tr>
					<td width="10px" rowspan="24"><b>d</b></td>
					<td colspan="9"><b>Individual Appliance Options</b></td>
				</tr>
				<tr>
					<td>Coffee brewer</td>
					<td><?php echo $count = $getappliances_info[0]['coffee_maker_brewer'];?></td>
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_one = $obj->tbl6individualapp_one($getappliances_info[0]['num_of_coffeebrewer']);
					}
					?>
					<?php $Sensible_load = $count * 1331 * 1.00 * 0.25; ?>
					<?php $Latent_load = $count * 717 * 1.00 * 0.25; ?>
					<td>1,331</td>
					<td>717</td>
					<td>1.00</td>
					<td>0.25</td>
					<td><?php echo $Sensible_load; ?></td>
					<td><?php echo $Latent_load; ?></td>
				</tr>	
				<tr>
					<td>Coffee warmer</td>
					<td><?php echo $count = $getappliances_info[0]['coffee_maker_warmer'];?></td>
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_two = $obj->tbl6individualapp_two($getappliances_info[0]['num_of_makerwarmer']);
					}
					?>
					<?php $Sensible_loadcw = $count * 155 * 1.00 * 0.50; ?>
					<?php $Latent_loadcw = $count * 84 * 1.00 * 0.50; ?>
					<td>155</td>
					<td>84</td>
					<td>1.00</td>
					<td>0.50</td>
					<td><?php echo $Sensible_loadcw; ?></td>
					<td><?php echo $Latent_loadcw; ?></td>
				</tr>	
				<tr>
					<td>Range, four burners on high heat</td>
					<td>N/A</td>
					<td>13,311</td>
					<td>7,167</td>
					<td>0.25</td>
					<td>0.25</td>
					<td>N/A</td>
					<td>N/A</td>
				</tr>	
				<tr>
					<td>Crock pot - low heat</td>
					<td><?php echo $count = $getappliances_info[0]['crockpot_lowheat']; ?></td>	
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_three = $obj->tbl6individualapp_three($getappliances_info[0]['num_crockpot_lowheat']);
					}
					?>	
					<?php $Sensible_loadcplh = $count * 166 * 1.00 * 1.00; ?>
					<?php $Latent_loadcplh = $count * 90 * 1.00 * 1.00; ?>			
					<td>166</td>
					<td>90</td>
					<td>1.00</td>
					<td>1.00</td>
					<td><?php echo $Sensible_loadcplh; ?></td>
					<td><?php echo $Latent_loadcplh; ?></td>
				</tr>	
				
				<tr>
					<td>Crock pot - high heat</td>
					<td><?php echo $count = $getappliances_info[0]['crock_pot_high_heat']; ?></td>					
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_four = $obj->tbl6individualapp_four($getappliances_info[0]['num_crockpot_highheat']);
					}
					?>
					<?php $Sensible_loadcphh = $count * 444 * 1.00 * 0.50; ?>
					<?php $Latent_loadcphh = $count * 230 * 1.00 * 0.50; ?>
					<td>444</td>
					<td>230</td>
					<td>1.00</td>
					<td>0.50</td>
					<td><?php echo $Sensible_loadcphh; ?></td>
					<td><?php echo $Latent_loadcphh; ?></td>
				</tr>	
				<tr>
					<td>Toaster</td>
					<td><?php echo $count = $getappliances_info[0]['toaster']; ?></td>					
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_five = $obj->tbl6individualapp_five($getappliances_info[0]['num_toaster']);
					}
					?>
					<?php $Sensible_loadT = $count * 3532 * 1.00 * 0.10; ?>
					<?php $Latent_loadT = $count * 392 * 1.00 * 0.10; ?>
					<td>3,532</td>
					<td>392</td>
					<td>1.00</td>
					<td>0.10</td>
					<td><?php echo $Sensible_loadT; ?></td>
					<td><?php echo $Latent_loadT; ?></td>
				</tr>	
				<tr>
					<td>Unvented dishwasher</td>
					<td><?php echo $count = $getappliances_info[0]['dishwasher']; ?></td>					
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_six = $obj->tbl6individualapp_six($getappliances_info[0]['num_dishwasher']);
					}
					?>
					<?php $Sensible_loadud = $count * 4096 * 1.00 * 0.25; ?>
					<?php $Latent_loadud = $count * 1433 * 1.00 * 0.25; ?>
					<td>4,096</td>
					<td>1,433</td>
					<td>1.00</td>
					<td>0.25</td>
					<td><?php echo $Sensible_loadud; ?></td>
					<td><?php echo $Latent_loadud; ?></td>
				</tr>	
				<tr>
					<td>Microwave</td>
					<td><?php echo $count = $getappliances_info[0]['microwave']; ?></td>					
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_seven = $obj->tbl6individualapp_seven($getappliances_info[0]['num_microwave']);
					}
					?>
					<?php $Sensible_loadM = $count * 4949 * 0.75 * 0.25; ?>
					<?php $Latent_loadM = $count * 1732 * 0.75 * 0.25; ?>
					<td>4,949</td>
					<td>1,732</td>
					<td>0.75</td>
					<td>0.25</td>
					<td><?php echo $Sensible_loadM; ?></td>
					<td><?php echo $Latent_loadM; ?></td>
				</tr>	
				<tr>
					<td>Vented clothes dryer</td>
					<td><?php echo $count = $getappliances_info[0]['vented_cloth_dry_percentspace']; ?></td>					
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_eight = $obj->tbl6individualapp_eight($getappliances_info[0]['num_ventedcloth_drypercentspace']);
					}
					?>
					<?php $Sensible_loadvcd = $count * 1707 * 0.50 * 0.50; ?>
					<?php $Latent_loadvcd = $count * 0.50 * 0.50; ?>
					<td>1,707</td>
					<td></td>
					<td>0.50</td>
					<td>0.50</td>
					<td><?php echo $Sensible_loadvcd; ?></td>
					<td><?php echo $Latent_loadvcd; ?></td>
				</tr>	
				<tr>
					<td>Clothes washing machine</td>
					<td><?php echo $count = $getappliances_info[0]['cloth_wash_machine_percentspace']; ?></td>					
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_nine = $obj->tbl6individualapp_nine($getappliances_info[0]['num_clothwash_machine_percentspace']);
					}
					?>
					<?php $Sensible_loadcwm = $count * 205 * 0.50 * 0.50; ?>
					<?php $Latent_loadcwm = $count * 0.50 * 0.50; ?>
					<td>205</td>
					<td></td>
					<td>0.50</td>
					<td>0.50</td>
					<td><?php echo $Sensible_loadcwm; ?></td>
					<td><?php echo $Latent_loadcwm; ?></td>
				</tr>	
				<tr>
					<td>Color TV</td>
					<td><?php echo $count = $getappliances_info[0]['color_television']; ?></td>		
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_ten = $obj->tbl6individualapp_ten($getappliances_info[0]['num_color_television']);
					}
					?>	
					<?php $Sensible_loadCTV = $count * 683 * 1.00 * 1.00; ?>
					<?php $Latent_loadCTV = $count * 1.00 * 1.00; ?>		
					<td>683</td>
					<td></td>
					<td>1.00</td>
					<td>1.00</td>
					<td><?php echo $Sensible_loadCTV; ?></td>
					<td><?php echo $Latent_loadCTV; ?></td>
				</tr>	
				
				<tr>
					<td>Stereo system</td>
					<td><?php echo $count = $getappliances_info[0]['stereo']; ?></td>					
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_eleven = $obj->tbl6individualapp_eleven($getappliances_info[0]['num_stereo']);
					}
					?>
					<?php $Sensible_loadSS = $count * 375 * 1.00 * 1.00; ?>
					<?php $Latent_loadSS = $count * 1.00 * 1.00; ?>
					<td>375</td>
					<td></td>
					<td>1.00</td>
					<td>1.00</td>
					<td><?php echo $Sensible_loadSS; ?></td>
					<td><?php echo $Latent_loadSS; ?></td>
				</tr>	
				<tr>
					<td>Desk or clock radio</td>
					<td><?php echo $count = $getappliances_info[0]['desk_radio_clock_radio']; ?></td>					
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_twl = $obj->tbl6individualapp_twl($getappliances_info[0]['num_deskradio_clockradio']);
					}
					?>
					<?php $Sensible_loaddcr = $count * 52 * 0.75 * 1.00; ?>
					<?php $Latent_loaddcr = $count * 0.75 * 1.00; ?>
					<td>52</td>
					<td></td>
					<td>0.75</td>
					<td>1.00</td>
					<td><?php echo $Sensible_loaddcr; ?></td>
					<td><?php echo $Latent_loaddcr; ?></td>
				</tr>	
				<tr>
					<td>Computer and monitor</td>
					<td><?php echo $count = $getappliances_info[0]['computer_monitor']; ?></td>					
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_thrtn = $obj->tbl6individualapp_thrtn($getappliances_info[0]['num_computer_monitor']);
					}
					?>
					<?php $Sensible_loadCM = $count * 1536 * 0.35 * 1.00; ?>
					<?php $Latent_loadCM = $count * 0.35 * 1.00; ?>
					<td>1,536</td>
					<td></td>
					<td>0.35</td>
					<td>1.00</td>
					<td><?php echo $Sensible_loadCM; ?></td>
					<td><?php echo $Latent_loadCM; ?></td>
				</tr>	
				<tr>
					<td>Laser printer</td>
					<td><?php echo $count = $getappliances_info[0]['laser_printer']; ?></td>					
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_fortn = $obj->tbl6individualapp_fortn($getappliances_info[0]['num_laser_printer']);
					}
					?>
					<?php $Sensible_loadLP = $count * 512 * 1.00 * 1.00; ?>
					<?php $Latent_loadLP = $count * 1.00 * 1.00; ?>
					<td>512</td>
					<td></td>
					<td>1.00</td>
					<td>1.00</td>
					<td><?php echo $Sensible_loadLP; ?></td>
					<td><?php echo $Latent_loadLP; ?></td>
				</tr>
				
				<tr>
					<td>Water bed</td>
					<td><?php echo $count = $getappliances_info[0]['water_bed']; ?></td>
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_fiftn = $obj->tbl6individualapp_fiftn($getappliances_info[0]['num_water_bed']);
					}
					?>	
					<?php $Sensible_loadwb = $count * 1365 * 1.00 * 0.33; ?>
					<?php $Latent_loadwb = $count * 1.00 * 0.33; ?>				
					<td>1,365</td>
					<td></td>
					<td>1.00</td>
					<td>0.33</td>
					<td><?php echo $Sensible_loadwb; ?></td>
					<td><?php echo $Latent_loadwb; ?></td>
				</tr>
				<tr>
					<td>100 Watt light</td>
					<td><?php echo $count = $getappliances_info[0]['light_fixture']; ?></td>
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_sixtn = $obj->tbl6individualapp_sixtn($getappliances_info[0]['num_light_fixture']);
					}
					?>
					<?php $Sensible_loadwattlight  = $count * 314 * 1.00 * 1.00; ?>
					<?php $Latent_loadwattlight = $count * 1.00 *1.00; ?>
					<td>341</td>
					<td></td>
					<td>1.00</td>
					<td>1.00</td>
					<td><?php echo $Sensible_loadwattlight; ?></td>
					<td><?php echo $Latent_loadwattlight; ?></td>
				</tr>
				<tr>
					<td>Refrigerator or freezer @ 12 CuFt</td>
					<td><?php echo $count = $getappliances_info[0]['refrigerator_freezer_12CuFt']; ?></td>
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_seventn = $obj->tbl6individualapp_seventn($getappliances_info[0]['num_refrigerator_freezer12CuFt']);
					}
					?>
					<?php $Sensible_loadRFC = $count * 700 * 1.00 * 100; ?>
					<?php $Latent_loadRFC = $count * 1.00 * 100; ?>
					<td>700</td>
					<td></td>
					<td>1.00</td>
					<td>100</td>
					<td><?php echo $Sensible_loadRFC; ?></td>
					<td><?php echo $Latent_loadRFC; ?></td>
				</tr>
				<tr>
					<td>Refrigerator or freezer @ 16CuFt</td>
					<td><?php echo $count = $getappliances_info[0]['refrigerator_freezer_16CuFt']; ?></td>
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_eighttn = $obj->tbl6individualapp_eighttn($getappliances_info[0]['num_refrigerator_freezer16CuFt']);
					}
					?>
					<?php $Sensible_loadRFC16 = $count * 1000 * 1.00 * 1.00; ?>
					<?php $Latent_loadRFC16 = $count * 1.00 * 1.00; ?>
					<td>1,000</td>
					<td></td>
					<td>1.00</td>
					<td>1.00</td>
					<td><?php echo $Sensible_loadRFC16; ?></td>
					<td><?php echo $Latent_loadRFC16; ?></td>
				</tr>
				<tr>
					<td>Ceiling fan</td>
					<td><?php echo $count = $getappliances_info[0]['ceiling_fan']; ?></td>
					<?php 
					if($count > 0)
					{						
						$tbl6individualapp_nintn = $obj->tbl6individualapp_nintn($getappliances_info[0]['num_ceiling_fan']);
					}
					?>
					<?php $Sensible_loadceilingfan = $count * 250 * 1.00 * 1.00; ?>
					<?php $Latent_loadceilingfan = $count * 1.00 * 1.00; ?>					
					<td>250</td>
					<td></td>
					<td>1.00</td>
					<td>1.00</td>
					<td><?php echo $Sensible_loadceilingfan; ?></td>
					<td><?php echo $Latent_loadceilingfan; ?></td>
				</tr>
				<tr>
					<td>Custom option 1:</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
				</tr>
				<tr>
					<td>Custom option 2:</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
				</tr>
				<tr>
					<td>Custom option 2:</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
				</tr>
				<tr>
					<td colspan="7" style="text-align: right;">Total individual appliance loads for Form J1 (Btuh) =</td>
					<td>N/A</td>
					<td>N/A</td>
				</tr>	
				
				<tr>
					<td width="10px" rowspan="4"><b>e</b></td>
					<td colspan="9"><b>Plants</b></td>
				</tr>
				<tr>
					<td>Small</td>
					<td>N/A</td>
					<td> 10 </td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
				</tr>	
				<tr>
					<td>Medium</td>
					<td>N/A</td>
					<td> 20 </td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
				</tr>	
				<tr>
					<td>Large</td>
					<td>N/A</td>
					<td> 30 </td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
				</tr>	
				<tr>
					<td colspan="7" style="text-align: right;">Total plant load for Form J1 (Btuh) =</td>
					<td>N/A</td>
					<td>N/A</td>
				</tr>
			</table>
		</td>
	</tr>
	<!--End Worksheet F-->
	
	<!--Worksheet G-->
	<?php 
	if(count($getfloors_masterinfo) > 0)
	{
	for($a=1;$a < count($getfloors_masterinfo);$a++){
	?>
	<?php $floorarea2level = $getfloors_masterinfo[$a]['area']; ?>
	<?php
	}
	}
	?>
	<tr style=" text-align:center;">
		<td colspan="8" ><h4>Worksheet G <br/>Duct Runs in Unconditioned Space</h4></td>
	</tr>
	<tr>
		<td colspan="2"><b>Location of duct runs:</b></td>
		<td colspan="2"> <?php echo $getductwork_masterinfo[0]['location'];?></td>
		<td colspan="2"><b> served by duct runs (one or two):</b></td>
		<td colspan="2"> <?php echo $getfloor_info[0]['floor_number']; ?> </td>
	</tr>
	<tr>
		<td colspan="2"><b>Percent of duct system in this space:</b></td>
		<td colspan="2"> <?php echo $getductwork_masterinfo[0]['located_uncondition_space']; ?> </td>
		<td colspan="2"><b> Floor area of primary level:</b></td>
		<td colspan="2"> <?php echo $getfloors_masterinfo[0]['area'];?></td>
	</tr>
	<tr>
		<td colspan="2"><b>Airway shape and configuration:</b></td>
		<td colspan="2"> <?php echo $getductwork_masterinfo[0]['return_geometry'] .'&nbsp'.'/'.'&nbsp'. $getductwork_masterinfo[0]['supply_geometry']; ?> </td>
		<td colspan="2"><b> Floor area of second level:</b></td>
		<td colspan="2"> <?php echo $floorarea2level; ?></td>
	</tr>
	<tr>
		<th>Duct Table</th>
		<th>Case</th>
		<th colspan="2">Look-up Floor Area</th>
		<th>SAT Heating</th>
		<th>99% db	</th>
		<th>1% db</th>
		<th>Grains</th>
	</tr>
	<tr>
		<td><?php echo $Table_Number; ?></td>
		<td>N/A</td>
		<td colspan="2"><?php echo $getfloors_masterinfo[0]['area'];?></td>
		<td> 100 </td>
		<td><?php echo $getval_of_wa[0]['Heating_DR_99']; ?></td>
		<td><?php echo $getval_of_wa[0]['Cooling_DB_1']; ?></td>
		<td><?php echo $getval_of_wa[0]['DG_50_RH']; ?></td>				
	</tr>
	
	<tr>
		<td colspan="8" ><b>step 1) Enter base-case load factors and latent heat value from Table 7</b></td>
	</tr>
	<tr style="text-align:center">
		<td width="10px"></td>
		<td colspan="2"><b>Existing Construction</b></td>
		<td width="30px" colspan="3"></td>
		<td colspan="2"><b>Improved Construction</b></td>
	</tr> 
	
	<tr style="text-align:center">
		<td width="10px"></td>
		<td>R-Value</td>
		<td>Base-case factors from table</td>
		<td width="30px" colspan="3"></td>
		<td>R-Value</td>
		<td>Base-case factors from table</td>
	</tr>
	<tr style="text-align:center">
		<td width="10px">1</td>
		<td><?php echo $getductwork_masterinfo[0]['insulation_r_value']; ?></td>
		<td>Heat loss factor = <?php echo $heatlosefact = $table7_bhlf[0]['BHLF']; ?></td>
		<td width="30px" colspan="3"></td>
		<td><?php echo $getductwork_masterinfo[0]['insulation_r_value']; ?></td>
		<td>Heat loss factor = <?php echo $table7_bhlf[0]['BHLF']; ?></td>
	</tr>
	<tr style="text-align:center">
		<td width="10px">2</td>
		<td>Leakage</td>
		<td>Sensible gain factor = <?php echo $table7_bsgf[0]['BSGF']; ?></td>
		<td width="30px" colspan="3"></td>
		<td>Leakage</td>
		<td>Sensible gain factor = <?php echo $table7_bsgf[0]['BSGF']; ?></td>
	</tr>
	<tr style="text-align:center">
		<td width="10px">3</td>
		<td>N/A</td>
		<td>Latent gain (Btuh) = <?php echo $table7blg[0]['BLG']; ?></td>
		<td width="30px" colspan="3"></td>
		<td>N/A</td>
		<td>Latent gain (Btuh) = <?php echo $table7blg[0]['BLG']; ?></td>
	</tr>
	
	<tr>
		<td colspan="8" ><b>step 2) R-Value Correction (WIF)</b></td>
	</tr>
	<tr>
		<td style="text-align:center">4</td>
		<td colspan="3">For heat loss = <?php echo $table7_bhlf_r_value_correction[0]['R_Value_Correction']; ?></td>
		<td width="10px"></td>
		<td colspan="3">For heat loss = <?php echo $table7_bhlf_r_value_correction[0]['R_Value_Correction']; ?></td>
		
	</tr>
	<tr>
		<td style="text-align:center">5</td>
		<td colspan="3">For sensible gain = <?php echo $table7_bsgf_r_value_corection[0]['R_Value_Correction']; ?></td>
		<td width="10px"></td>
		<td colspan="3">For sensible gain = <?php echo $table7_bsgf_r_value_corection[0]['R_Value_Correction']; ?></td>		
	</tr>
	<tr>
		<td style="text-align:center">6</td>
		<td colspan="3">Adjusted heat loss factor = <?php echo $adjustheatlossfact = $heatlosefact * $table7_bhlf_r_value_correction[0]['R_Value_Correction']; ?></td>
		<td width="10px"></td>
		<td colspan="3">< Line 1 factor x line 4 adjustment > </td>
		
	</tr>
	<tr>
		<td style="text-align:center">7</td>
		<td colspan="3">Adjusted sensible gain factor = <?php echo $adjustsensiblefact = $table7_bsgf[0]['BSGF'] * $table7_bsgf_r_value_corection[0]['R_Value_Correction']; ?></td>
		<td width="10px"></td>
		<td colspan="3">< Line 2 factor x line 5 adjustment > </td>
		
	</tr>
	
	<tr>
		<td colspan="8" ><b>Step 3) Leakage Rate Correction (LCF)</b></td>
	</tr>
	<tr>
		<td style="text-align:center">8</td>
		<td colspan="3">For heat loss = <?php echo $table7_bhlfleackage_correction[0]['Leakage_Correction']; ?></td>
		<td width="10px"></td>
		<td colspan="3">For heat loss = <?php echo $table7_bhlfleackage_correction[0]['Leakage_Correction']; ?></td>
		
	</tr>
	<tr>
		<td style="text-align:center">9</td>
		<td colspan="3">For sensible gain = <?php echo $table7_bsgfleakage_correction[0]['Leakage_Correction']; ?></td>
		<td width="10px"></td>
		<td colspan="3">For sensible gain = <?php echo $table7_bsgfleakage_correction[0]['Leakage_Correction']; ?></td>
		
	</tr>
	<tr>
		<td style="text-align:center">10</td>
		<td colspan="3">For latent gain = <?php echo $table7_blgleakage_correction[0]['Leakage_Correction']; ?></td>
		<td width="10px"></td>
		<td colspan="3">For latent gain = <?php echo $table7_blgleakage_correction[0]['Leakage_Correction']; ?></td>
		
	</tr>
	<tr>
		<td style="text-align:center">11</td>
		<td colspan="3">Adjusted heat loss factor = <?php echo $adjustheatlossfactstep3 = $adjustheatlossfact * $table7_bhlfleackage_correction[0]['Leakage_Correction']; ?></td>
		<td width="10px"></td>
		<td colspan="3">< Line 6 factor x line 8 adjustment t > </td>
		
	</tr>
	<tr>
		<td style="text-align:center">12</td>
		<td colspan="3">Adjusted sensible gain factor = <?php echo $adjustsensiblefactstep3 = $adjustsensiblefact * $table7_bsgfleakage_correction[0]['Leakage_Correction']; ?></td>
		<td width="10px"></td>
		<td colspan="3">< Line 7 factor x line 9 adjustment > </td>
		
	</tr>
	<tr>
		<td style="text-align:center">13</td>
		<td colspan="3">Adjusted latent gain (Btuh) = <?php echo $adjustlatentgain = $table7blg[0]['BLG'] * $table7_blgleakage_correction[0]['Leakage_Correction']; ?></td>
		<td width="10px"></td>
		<td colspan="3">< Line 3 value x line 10 adjustment > </td>
		
	</tr>
	
	<tr>
		<td colspan="8" ><b>Step 4) Surface Area Adjustment</b></td>
	</tr>
	<tr>
		<td style="text-align:center">14</td>
		<td colspan="3">Installed supply area (SqFt) = <?php echo $installsopplyarea = $getductwork_masterinfo[0]['located_uncondition_space'] * $table7_ductwall_surface_area[0]['Supply_Duct_Wall_Surface_Area']; ?></td>
		<td width="10px"></td>
		<td colspan="3">Installed supply area (SqFt) = <?php echo $installsopplyarea = $getductwork_masterinfo[0]['located_uncondition_space'] * $table7_ductwall_surface_area[0]['Supply_Duct_Wall_Surface_Area']; ?></td>
		
	</tr>
	<tr>
		<td style="text-align:center">15</td>
		<td colspan="3">Default supply area (SqFt) = <?php echo $table7_ductwall_surface_area[0]['Supply_Duct_Wall_Surface_Area']; ?></td>
		<td width="10px"></td>
		<td colspan="3">Default supply area (SqFt) = <?php echo $table7_ductwall_surface_area[0]['Supply_Duct_Wall_Surface_Area']; ?></td>
		
	</tr>
	<tr>
		<td style="text-align:center">16</td>
		<td colspan="3">Rs = Installed area / default area = </td>
		<td width="10px"></td>
		<td colspan="3">Rs = Installed area / default area = </td>
		
	</tr>
	<tr>
		<td style="text-align:center">17</td>
		<td colspan="3">Installed return area (SqFt) = <?php echo $installsreturnarea = $getductwork_masterinfo[0]['located_uncondition_space'] * $table7_ductwall_surface_area[0]['Return_Duct_Wall_Surface_Area']; ?></td>
		<td width="10px"></td>
		<td colspan="3">Installed return area (SqFt) = <?php echo $installsreturnarea = $getductwork_masterinfo[0]['located_uncondition_space'] * $table7_ductwall_surface_area[0]['Return_Duct_Wall_Surface_Area']; ?></td>
		
	</tr>
	<tr>
		<td style="text-align:center">18</td>
		<td colspan="3">Default return area (SqFt) = <?php echo $table7_ductwall_surface_area[0]['Return_Duct_Wall_Surface_Area']; ?></td>
		<td width="10px"></td>
		<td colspan="3">Default return area (SqFt) = <?php echo $table7_ductwall_surface_area[0]['Return_Duct_Wall_Surface_Area']; ?></td>
		
	</tr>
	<tr>
		<td style="text-align:center">19</td>
		<td colspan="3">Rr = Installed area / default area = </td>
		<td width="10px"></td>
		<td colspan="3">Rr = Installed area / default area = </td>
		
	</tr>
	<tr>
		<td style="text-align:center">20</td>
		<td colspan="3">Ks = <?php echo $ks = $table7_surfacearea_factor[0]['Ks']; ?> Kr = <?php echo $kr = $table7_surfacearea_factor[0]['Kr']; ?></td>
		<td width="10px"></td>
		<td colspan="3">Ks = <?php echo $ks = $table7_surfacearea_factor[0]['Ks']; ?> Kr = <?php echo $kr = $table7_surfacearea_factor[0]['Kr']; ?></td>
		
	</tr>
	<tr>
		<td style="text-align:center">21</td>
		<?php $saa = $ks * ($installsopplyarea / $table7_ductwall_surface_area[0]['Supply_Duct_Wall_Surface_Area']) + $kr * ($installsreturnarea / $table7_ductwall_surface_area[0]['Return_Duct_Wall_Surface_Area']); ?>
		<td colspan="3">SAA (heating and sensible cooling) = <?php echo $saa; ?></td>
		<td width="10px"></td>
		<td colspan="3">< Ks (L20) x Rs (L16) + Kr (L20) x Rr (L19) > </td>
		
	</tr>
	<tr>
		<td style="text-align:center">22</td>
		<?php $lga = $installsreturnarea / $table7_ductwall_surface_area[0]['Return_Duct_Wall_Surface_Area']; ?>
		<td colspan="3">LGA (latent cooling) = <?php echo $lga; ?></td>
		<td width="10px"></td>
		<td colspan="3">< Latent LGA = Rr (L19) > </td>
		
	</tr>
	
	<tr>
		<td colspan="8" ><b>Step 5) Heat Loss and heat gain factors and latent gain (Btuh)</b></td>
	</tr>
	<tr>
		<td style="text-align:center">23</td>
		<?php $ehlf = $adjustheatlossfactstep3 * $saa; ?>
		<td colspan="3">Effective heat loss factor (EHLF) = <?php echo number_format($ehlf,4); ?></td>
		<td width="10px"></td>
		<td colspan="3">< Line 11 Factor x Line 21 SAA value ></td>
		
	</tr>
	
	<tr>
		<td style="text-align:center">24</td>
		<?php $esgf = $adjustsensiblefactstep3 * $saa; ?>
		<td colspan="3">Effective sensible gain factor (ESGF) = <?php echo number_format($esgf,4); ?></td>
		<td width="10px"></td>
		<td colspan="3">< Line 12 Factor x Line 21 SAA value ></td>
		
	</tr>
	<tr>
		<td style="text-align:center">25</td>
		<?php $elg = $adjustlatentgain * $lga; ?>
		<td colspan="3">Effective latent gain Btuh (ELG) = <?php echo number_format($elg,4); ?></td>
		<td width="10px"></td>
		<td colspan="3">< Line 13 gain x Line 22 LGA adjustment ></td>
		
	</tr>
	<!--End Worksheet g-->
	
	<!--Worksheet H-->
	<tr style=" text-align:center;">
		<td colspan="8" ><h4>Worksheet H <br/>Ventilation Loads</h4></td>
	</tr>
	<tr>
		<td>1)</td>
		<td colspan="4" >Air changes per hour (ACH) specified by local code: <?php echo '0.35'; ?></td>
		<td colspan="3" >Cfm specified by local code : </td>
	</tr>
	<tr>
		<td>2)</td>
		<td colspan="4" >Above grade volume (AGV) from Worksheet E: <?php echo $abovegradevol; ?></td>
		<td colspan="3" >< Largest value for heating or cooling</td>
	</tr>
	<tr>
		<td>3)</td>
		<td colspan="4" >Outdoor air Cfm Value for code ACH requirement: <?php echo number_format($outdooraircfm,2); ?></td>
		<td colspan="3" >< ACH x AGV / 60</td>
	</tr>
	<tr>
		<td>4)</td>		
		<td colspan="4" >Code value for outdoor air Cfm : <?php echo number_format($codevalfor_cfm,2); ?></td>
		<td colspan="3" >< Largest value from line 1 or line 3</td>
	</tr>
	<tr>
		<td>5)</td>
		<td colspan="4" >Code Cfm may be provided by any combination of infiltration Cfm and engineered ventilation Cfm : YES </td>
		<td colspan="3" >< Yes or No</td>
	</tr>
	<tr>
		<td>6)</td>
		<td colspan="4" >Code Cfm shall be provided by engineered ventilation only:</td>
		<td colspan="3" >< Yes or No</td>
	</tr>
	<tr>
		<td>7)</td>
		<td colspan="4" >Estimated infiltration Cfm:</td>
		<td colspan="3" >< Enter smallest value from Workshhet E</td>
	</tr>
	<tr>
		<td>8)</td>
		<td colspan="4" >Code outdoor Cfm requirment: <?php echo number_format($outdoorcfmrequirment,2); ?></td>
		<td colspan="3" >< If line 5 = Yes, Cfm = Line 4 - Line 7 - or - if Line 6 = Yes, Cfm = Line 4 value</td>
	</tr>
	
	<tr>
		<td colspan="8" ><b>Design Cfm Value for Engineered Ventilation</b></td>
	</tr>
	<tr>
		<td>9)</td>
		<td colspan="4" >Code Cfm value = <?php echo number_format($codevalfor_cfm,2); ?></td>
		<td colspan="3" >< From line 8 above</td>
	</tr>
	
	<tr>
		<td>10)</td>
		<td colspan="4" >Table 8 Cfm value = <?php echo number_format($table8ventcfm,2); ?></td>
		<td colspan="3" >< Table 8 Vent Cfm value from Worksheet E</td>
	</tr>	
	<tr>
		<td>11</td>
		<td colspan="4" >Practitioner-specified VCFM : <?php echo number_format($PractitionerspecifiedVCFM,2); ?></td>
		<td colspan="3" >< Code value is a mandatory minimum. The system designer may use a larger value.</td>
	</tr>
	
	<tr>
		<td colspan="8" ><b>Ventilation Loads</b></td>
	</tr>
	<tr>
		<td colspan="8" >
			<table border="1">
				<tr>
					<th>Type of Load</th>
					<th>VCFM or CFMdish Note 1</th>
					<th>SER LER for Heat Recovery Ventilator Note 2</th>
					<th>Condition of Air Leaving Ventilation Dehumidifier Note 3</th>
					<th>For VDH Only Indoor Grains for Site Elevation</th>
					<th>Table 1 Outdoor Condition To and Grains</th>
					<th>HTD and CTD From Wrksht A</th>
					<th>LATloss LATgain V-Grains for ventilation air Note 4</th>
					<th>Site Elevation 955 Ft Table 10A</th>
					<th>Ti Indoor Drybulb</th>
					<th>Vent. Loads (Btuh)Note 5</th>
				</tr>
				<tr>
					<td>Heat Load</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>LAT<sub>VDH</sub></td>
					<td>Table 12</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
				</tr>
				<tr>
					<td>Sen Load</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>LAT<sub>VDH</sub></td>
					<td>Table 12</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
				</tr>
				<tr>
					<td>Lat Load</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>Grain<sub>VDH</sub></td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
					<td>N/A</td>
				</tr>