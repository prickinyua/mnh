<?php
class C_Load extends MY_Controller {
	var $rows, $combined_form;

	public function __construct() {
		parent::__construct();
		//print var_dump($this->tValue); exit;
		$this -> rows = '';
		$this -> combined_form;

	}

	public function getFacilityDetails() {
		/*retrieve facility info if any*/
		$this -> load -> model('m_mnh_survey');
		if (($this -> m_mnh_survey -> retrieveFacilityInfo($this -> input ->get_post('fcode',TRUE))) == true) {
			//retrieve existing data..else just load a blank form
			print $this -> m_mnh_survey -> formRecords;
		}
	}

	public function suggestFacilityName() {
		$this -> load -> model('m_autocomplete');
		$facilityName = strtolower($this -> input -> get_post('term', TRUE));
		//term is obtained from the ajax call

		//echo $facilityName; exit;

		//$facilityName='Keri';

		if (!strlen($facilityName) < 2)

			//echo $facilityName;

			try {
				$this -> rows = $this -> m_autocomplete -> getAutocomplete(array('keyword' => $facilityName));
				//die (var_dump($this->rows));
				$json_data = array();

				//foreach($this->rows as $key=>$value)
				//array_push($json_data,$value['facilityName']);
				foreach ($this->rows as $value) {
					array_push($json_data, $value -> facilityName);

					//print $key.' '.$value.'<br />';
					//$json_data=array('code'=>$value->facilityMFC,'name'=>$value->facilityName);
				}
				print json_encode($json_data);
				//die;

			} catch(exception $ex) {
				//ignore
				//$ex->getMessage();
			}

	}

	public function suggest() {
		$this -> load -> model('m_autocomplete');
		//$facilityName=$this->input->post('username',TRUE);

		try {
			$this -> rows = $this -> m_autocomplete -> getAllFacilityNames();
			//die(var_dump($this->rows));
			$json_data = array();

			foreach ($this->rows as $key => $value)
			//array_push($json_names,$value['facilityName']);
				$json_data = array('code' => $value['facilityMFC'], 'name' => $value['facilityName']);
			print json_encode($json_data);
		} catch(exception $ex) {
			//ignore
			$ex -> getMessage();
		}

	}

	
	public function get_new_form()
	 {
		$this -> combined_form.= 
		         '<h5 id="status"></h5>
                 
				<form class="bbq" name="mnh_too" id="mnh_tool" method="POST">

  				 <p id="data" class="feedback"></p>
		         <!--h3 align="center">COMMODITY, SUPPLIES AND EQUIPMENT ASSESSMENT</h3-->
		         <div id="section-1" class="step">
		         <input type="hidden" name="step_name" value="section-1"/>
		          <p style="display:true" class="message success">SECTION 1 of 7</p>
				<table class="centre" >

		       <thead><th colspan="9">FACILITY INFORMATION</th></thead>
		       
			<tr>
			<TD >Facility Name </TD><td>
			<input type="text" id="facilityName" name="facilityName" class="cloned" size="40" disabled/>
			</td> <TD  >Facility Level </TD><td>
			<input type="text" id="facilityLevel" name="facilityLevel" class="cloned"  size="40"/>
			</td><TD  >County </TD><td>
			<select name="facilityCounty" id="facilityCounty" class="cloned" style="width:85%">
							<option value="" selected="selected">Select One</option>
							' . $this -> selectCounties . '
						</select>
			</td>
			</tr>
			<tr>
			<TD >Facility Type </TD><td>
			<select name="facilityType" id="facilityType" class="cloned" style="width:75%">
							<option value="" selected="selected">Select One</option>
							' . $this -> selectFacilityType . '
						</select>

			</td>
			<TD >Owned By </TD><td>
			<select name="facilityOwnedBy" id="facilityOwnedBy" class="cloned" style="width:75%">
							<option value="" selected="selected">Select One</option>
							' . $this -> selectFacilityOwner . '
						</select>
			</td>

			<td>District </TD><td>
			<select name="facilityDistrict" id="facilityDistrict" class="cloned" style="width:85%">
							<option value="" selected="selected">Select One</option>
							' . $this -> selectDistricts . '
						</select>
			</td>
			</tr>
		
		</table>
		<table class="centre">
		<thead>
		<th colspan="12" >FACILITY CONTACT INFORMATION</th>
		</thead>
		<tr >
			<th scope="col" colspan="2" >CADRE</th>
			<th>NAME</th>
			<th >MOBILE</th>
			<th >EMAIL</th>
		</tr>
		<tr>
			<TD  colspan="2">Incharge </TD><td>
			<input type="text" id="facilityInchargename" name="facilityInchargename" class="cloned" size="40"/>
			</td><td>
			<input type="text" id="facilityInchargemobile" name="facilityInchargemobile" class="cloned numbers" size="40"/>
			</td>
			<td>
			<input type="text" id="facilityInchargeemail" name="facilityInchargeemail" class="cloned mail" size="40"/>
			</td>
		</tr>
		<tr>
			<TD  colspan="2">MCH </TD><td>
			<input type="text" id="facilityMchname" name="facilityMchname" class="cloned" size="40"/>
			</td><td>
			<input type="text" id="facilityMchmobile" name="facilityMchmobile" class="cloned numbers" size="40"/>
			</td>
			<td>
			<input type="text" id="facilityMchemail" name="facilityMchemail" class="cloned mail" size="40"/>
			</td>
		</tr>
		<tr>
			<TD  colspan="2">Maternity </TD><td>
			<input type="text" id="facilityMaternityname" name="facilityMaternityname" class="cloned" size="40"/>
			</td>
			<td>
			<input type="text" id="facilityMaternitymobile" name="facilityMaternitymobile" class="cloned numbers" size="40"/>
			</td>
			<td>
			<input type="text" id="facilityMaternityemail" name="facilityMaternityemail" class="cloned mail" size="40"/>
			</td>
		</tr>

	</table>
	<table class="centre">
	<thead>
	<th colspan ="8"> DOES THIS FACILITY ROUTINELY CONDUCT DELIVERIES?</th> </thead>
	<tr><th colspan ="8"><select name="cDeliveries" id="cDeliveries" class="cloned">
				<option value="" selected="selected">Select One</option>
				<option value="Yes">Yes</option>
				<option value="No">No</option></th></tr>
	</table>
	<table class="centre" style="display:none" id="delivery_centre">
	
	<thead><th colspan ="8">WHAT ARE THE MAIN REASONS FOR NOT CONDUCTING DELIVERIES? </br>(multiple selections allowed)</th></thead>
	<tr><th colspan ="2">Inadequate skill or staff</th><th colspan ="2"> Inadequate infrastructure (equipment)</th>
	<th colspan ="2">  Inadequate commodities and supplies</th><th colspan ="2">  Other</th></tr>
	<td style ="text-align:center;" colspan ="2">
			<input name="rsnDeliveries[]" type="checkbox" value="Inadequate skill or staff" class="cloned"/>
			</td>
			<td style ="text-align:center;" colspan ="2">
			<input name="rsnDeliveries[]" type="checkbox" value="Inadequate infrastructure (equipment)" />
			</td>
			<td style ="text-align:center;" colspan ="2">
			<input name="rsnDeliveries[]" type="checkbox" value=" Inadequate commodities and supplies" />
			</td>
			<td style ="text-align:center;" colspan ="2">
			<input name="rsnDeliveries[]" type="checkbox" value="Other" />
			</td>
	
	
	</table>
	</div><!--\.the section-1 -->
	
	<div id="section-2" class="step">
	 <p style="display:true" class="message success">SECTION 2 of 7</p>
	<table class="centre">
		
	<thead>
	<th colspan="13" >INDICATE THE NUMBER OF DELIVERIES CONDUCTED IN THE FOLLOWING PERIODS </th></thead>

	<th> MONTH</th><th><div style="width: 50px"> JANUARY</div></th> <th>FEBRUARY</th><th>MARCH</th><th> APRIL</th><th> MAY</th><th>JUNE</th><th> JULY</th><th> AUGUST</th>
	<th> SEPTEMBER</th><th> OCTOBER</th><th> NOVEMBER</th><th> DECEMBER</th>
		 <tr>
			<td>'.(date('Y')-1).'</td>
			<td style ="text-align:center;">
			<input type="text" id="dnjanuary_12" name="dnjanuary_12"  size="8" class="cloned numbers"/>
			</td>
			<td style ="text-align:center;">
			<input type="text" id="dnfebruary_12" name="dnfebruary_12" size="8" class="cloned numbers"/>
			</td>
			<td style ="text-align:center;">
			<input type="text" id="dnmarch_12" size="8" name="dnmarch_12" class="cloned numbers"/>
			</td>
			<td style ="text-align:center;">
			<input type="text" id="dnapril_12" size="8" name="dnapril_12" class="cloned numbers"/>
			</td>
			<td style ="text-align:center;">
			<input type="text" id="dnmay_12" size="8" name="dnmay_12" class="cloned numbers"/>
			</td>
			<td style ="text-align:center;">
			<input type="text" id="dnjune_12" size="8" name="dnjune_12" class="cloned numbers"/>
			</td>
			<td style ="text-align:center;">
			<input type="text" id="dnjuly_12" size="8" name="dnjuly_12" class="cloned numbers"/>
			</td>
			<td style ="text-align:center;">
			<input type="text" id="dnaugust_12" size="8" name="dnaugust_12" class="cloned numbers"/>
			</td>
			<td  style ="text-align:center;">
			<input type="text" id="dnseptember_12" size="8" name="dnseptember_12" class="cloned numbers"/>
			</td>
			<td style ="text-align:center;">
			<input type="text" id="dnoctober_12" size="8" name="dnoctober_12" class="cloned numbers"/></td>
			<td style ="text-align:center;" width="15">
			<input type="text" id="dnnovember_12" size="8" name="dnnovember_12" class="cloned numbers"/></td>
			
			<td style ="text-align:center;">
			<input type="text" id="dndecember_12" size="8" name="dndecember_12" class="cloned numbers"/>
			</td>			
			

		</tr>

		<tr>
			<td>'.date("Y").'</td>			
			<td style ="text-align:center;"><input type="text" id="dnjanuary_13" size="8" name="dnjanuary_13" class="cloned numbers"/>
			</td>
			
			<td style ="text-align:center;">
			<input type="text" id="dnfebruary_13" name="dnfebruary_13" size="8"class="cloned numbers"/>
			</td>
			<td style ="text-align:center;">
			<input type="text" id="dnmarch_13" name="dnmarch_13" size="8"class="cloned numbers"/>
			</td>
			<td style ="text-align:center;">
			<input type="text" id="dnapril_13" name="dnapril_13" size="8"class="cloned numbers"/>
			</td>
			<td style ="text-align:center;">
			<input type="text" id="dnmay_13" name="dnmay_13" size="8"class="cloned numbers" />
			</td>
			<td style ="text-align:center;">
			<!--input type="text" id="dnjune_13" name="dnjune_13" size="8"class="cloned numbers" disabled/-->
			</td>
			<td style ="text-align:center;">
			<!--input type="text" id="dnjuly_13" size="8" name="dnjuly_13" class="cloned numbers" disabled/-->
			</td>
			<td style ="text-align:center;">
			<!--input type="text" id="dnaugust_13" size="8" name="dnaugust_13" class="cloned numbers" disabled/-->
			</td>
			<td  style ="text-align:center;">
			<!--input type="text" id="dnseptember_13" size="8" name="dnseptember_13" class="cloned numbers" disabled/-->
			</td>
			<td style ="text-align:center;">
			<!--input type="text" id="dnoctober_13" size="8" name="dnoctober_13" class="cloned numbers" disabled/--></td>
			<td style ="text-align:center;" width="15">
			<!--input type="text" id="dnnovember_13" size="8" name="dnnovember_13" class="cloned numbers" disabled/--></td>
			
			<td style ="text-align:center;">
			<!--input type="text" id="dndecember_13" size="8" name="dndecember_13" class="cloned numbers" disabled/-->
			</td>			
			

			
		</tr>

	
	</table>

	
	<table class="centre">
		<thead>
			<th colspan="14" >PROVISION OF BEmONC SIGNAL FUNCTIONS  IN THE LAST THREE MONTHS </th>
		</thead>
		
		
			<th  colspan="7">SIGNAL FUNCTION</th>
			<th   colspan="4"> WAS IT CONDUCTED? </th>			
			<th  colspan="5">INDICATE MAJOR CHALLENGE</th>

		</tr>'.$this->signalFunctionsSection.'
	</table>
	</div><!--\.section 2-->

	<div id="section-3" class="step">
	 <p style="display:true" class="message success">SECTION 3 of 7</p>
	<table  class="centre persist-area" >
	<thead>
	    <tr class="persist-header">
		
			<th colspan="12">INDICATE THE AVAILABILITY, LOCATION, SUPPLIER AND QUANTITIES ON HAND OF THE FOLLOWING COMMODITIES.INCLUDE REASON FOR UNAVAILABILITY. </th>
		</tr>
		</thead>
		<tr>
			<th scope="col" >Commodity Name</th>
			<th >Commodity Unit</th>
			<th colspan="3" style="text-align:center"> Availability  
			 <strong></BR>
			(One Selection Allowed) </strong></div></th>
			<th colspan="4" style="text-align:center"> Location of Availability  </BR><strong> (Multiple Selections Allowed)</strong></th>
			<th>Available Quantities</th>
			<th scope="col">
			
				Main Supplier
			</th>
			<th scope="col">
			<div style="width: 100px" >
				Main Reason For  Unavailability
			</div></th>

		</tr>
		<tr >
			<td>&nbsp;</td>
			<td >Unit</td>
			<td >Available</td>
			<td>Sometimes Available</td>
			<td>Never Available</td>
			<td>Delivery room</td>
			<td>Pharmacy</td>
			<td>Store</td>
			<td>Other</td>

			<td>No.of Units</td>
			<td>Supplier</td>
			<td> Unavailability</td>

		</tr>'.$this->commodityAvailabilitySection.'

	</table>
	</div><!--\.section-3-->

    <div id="section-4" class="step">
     <p style="display:true" class="message success">SECTION 4 of 7</p>
	<table class="centre">
	<thead>
		<th colspan="4"  >IN THE LAST 2 YEARS, HOW MANY STAFF MEMBERS HAVE BEEN TRAINED IN THE FOLLOWING?</th></thead>
		<th colspan ="2" style="text-align:left"> TRAININGS</th><th style="text-align:left">Number Trained</th>
		<th colspan ="2" style="text-align:left"><div style="width: 500px" >How Many Of The Staff Members 
		Trained in the Last 2 Years are still Working in the Marternity Unit?</DIV></th>
		
		'.$this->trainingGuidelineSection.'

	</table>
    </div><!--\.section-4-->

	<div id="section-5" class="step">
	 <p style="display:true" class="message success">SECTION 5 of 7</p>
	<table  class="centre" >
		<thead>
			<th colspan="11"> IN THE LAST 3 MONTHS INDICATE THE USAGE, NUMBER OF TIMES THE COMMODITY WAS NOT AVAILABLE.</BR>
			WHEN THE COMMODITY WAS NOT AVAILABLE WHAT HAPPENED? </th>
		</thead>

		</tr>
		<tr >
			<th scope="col"  colspan="2"><div style="width: 1
			00px" >Commodity Name</div></th>
			
			<th scope="col" colspan="2">
			<div style="width: 40px" >
				Usage
			</div></th>
			<th scope="col" colspan="2">
			<div style="width: 100px" >
				Number Of Times the commodity was unavailable
			</div></th>
			<th scope="col" colspan="5">
			<div style="width: 600px" >
				When the commodity was not available what happened
				</br>
				(Multiple Selections Allowed)
			</div></th>

		</tr>
		<tr >
			<td colspan="2">&nbsp;</td>
			<td colspan="2">Used Units</td>
			<td colspan="2">Times Unavailable </td>
			
			<td colspan="1">
			<div style="width: 100px" >
			Patient purchased the commodity privately</div></td>
			<td colspan="1"> <div style="width: 100px" >
			Facility purchased the commodity privately
			</div></td>
			<td colspan="1"><div style="width: 100px" >
			Facility received the commodity from another facility</div></td>
			<td colspan="1"><div style="width: 100px" >
			The procedure was not conducted </div></td>
			<td colspan="1"><div style="width: 100px" > The procedure was conducted without the commodity
			</div></td>

		</tr>
        '.$this->commodityUsageAndOutageSection.'
        </table>
	</div><!--\.section-5-->
	<div id="section-6" class="step">
	 <p style="display:true" class="message success">SECTION 6 of 7</p>
		
		<table  class="centre" >
		<thead>
			<th colspan="12">INDICATE THE AVAILABILITY, LOCATION  AND FUNCTIONALITY OF THE FOLLOWING EQUIPMENT.</th>
		</thead>

		</tr>
		<tr>
			<th scope="col" >Equipment Name</th>
			
			<th colspan="3" style="text-align:center">Availability  
			 <strong></BR>
			(One Selection Allowed) </strong></th>
			<th colspan="4" style="text-align:center"> Location of Availability  </BR><strong> (Multiple Selections Allowed)</strong></th>
			<th colspan="3">Available Quantities</th>
		</tr>
		<tr >
			<td>&nbsp;</td>
			
			<td >Available</td>
			<td>Sometimes Available</td>
			<td>Never Available</td>
			<td>Delivery room</td>
			<td>Pharmacy</td>
			<td>Store</td>
			<td>Other</td>
			<td>Fully-Functional</td>
            <td>Partially Functional</td>
			<td>Non-Functional</td>
			</tr>
			'.$this->equipmentsSection.'

			</table>
           </div><!--\.section-6-->
			<div id="section-7" class="step">
	 <p style="display:true" class="message success">SECTION 7 of 7</p>
			
		 <table  class="centre" >
		<thead>
			<th colspan="12">INDICATE THE AVAILABILITY, LOCATION  AND QUANTITIES ON HAND OF THE FOLLOWING SUPPLIES.</th>
		</thead>

		</tr>
		<tr>
			<th scope="col" >Supplies Name</th>
			
			<th colspan="3" style="text-align:center"> Availability  
			 <strong></BR>
			(One Selection Allowed) </strong></th>
			<th colspan="4" style="text-align:center"> Location of Availability  </BR><strong> (Multiple Selections Allowed)</strong></th>
			<th>Available Supplies</th>
			<th scope="col">
			
				Main Supplier
			</th>
			<th scope="col">
			<div style="width: 100px" >
				Main Reason For  Unavailability
			</div></th>

		</tr>
			

		</tr>
		<tr >
			<td>&nbsp;</td>
			
			<td >Available</td>
			<td>Sometimes Available</td>
			<td>Never Available</td>
			<td>Delivery room</td>
			<td>Pharmacy</td>
			<td>Store</td>
			<td>Other</td>

			<td style="text-align:center">No.of Supplies</td>
			<td></td>
			<td></td>
			
			

		</tr>'.$this->suppliesSection.'
		</table>
		<table  class="centre" >
		<thead>
			<th colspan="11"> IN THE LAST 3 MONTHS INDICATE THE USAGE, NUMBER OF TIMES THE SUPPLY WAS NOT AVAILABLE.</BR>
			WHEN THE SUPPLY WAS NOT AVAILABLE WHAT HAPPENED? </th>
		</thead>

		</tr>
		<tr >
			<th scope="col"  colspan="2"><div style="width: 1
			00px" >Supply Name</div></th>
			
			<th scope="col" colspan="2">
			<div style="width: 40px" >
				Usage
			</div></th>
			<th scope="col" colspan="2">
			<div style="width: 100px" >
				Number Of Times the supply was unavailable
			</div></th>
			<th scope="col" colspan="5">
			<div style="width: 600px" >
				When the supply was not available what happened
				</br>
				(Multiple Selections Allowed)
			</div></th>

		</tr>
		<tr >
			<td colspan="2">&nbsp;</td>
			<td colspan="2">Used Units</td>
			<td colspan="2">Times Unavailable </td>
			
			<td colspan="1">
			<div style="width: 100px" >
			Patient purchased the supply privately</div></td>
			<td colspan="1"> <div style="width: 100px" >
			Facility purchased the supply privately
			</div></td>
			<td colspan="1"><div style="width: 100px" >
			Facility received the supply from another facility</div></td>
			<td colspan="1"><div style="width: 100px" >
			The procedure was not conducted </div></td>
			<td colspan="1"><div style="width: 100px" > The procedure was conducted without the supply
			</div></td>

		</tr>
        '.$this->suppliesUsageAndOutageSection.'
        </table>
		
	 </div><!--\.section-7-->
	 <div id="sectionNavigation" class="buttonsPane">
		<input title="To View Previous Section" id="back" value="View Previous Section" class="awesome blue medium" type="reset"/>
		<input title="To Save This Section" id="submit" class="awesome blue medium"  type="submit" name="post_form" value="Save and Go to the Next Section"/>				
		</div>
	</form>';
		$data['form'] = $this -> combined_form;
		$data['form_id'] = 'form_dcah';
		$this->load->view('form',$data);
	}


	public function get_facility_list(){
		
		$this->facilityList.='<table class="centre">
		<thead>
			<th colspan="22" >'.strtoupper($this -> session -> userdata('dName')).' DISTRICT FACILITIES</th>
		</thead>
		
		    <th colspan="1"></th>
			<th  colspan="7">MFL CODE</th>
			<th   colspan="4"> FACILITY NAME </th>			
			<th  colspan="5">SURVEY STATUS</th>
			<th  colspan="5">ACTION</th>

		</tr>'.$this->districtFacilityListSection.'
		</table>';
		$data['form'] = $this -> facilityList;
		$data['form_id'] = '';
		$this->load->view('form',$data);
	}
	

	
	 
}
