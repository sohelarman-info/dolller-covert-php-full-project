<?php
$b = protect($_GET['b']);

if($b == "add") {
	?>
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Administrator</a></li>
		<li><a href="./?a=gateways">Gateways</a></li>
		<li class="active">Add gateway</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Add gateway
		</div>
		<div class="panel-body">
			<script type="text/javascript">
			function load_account_fiels(value) {
				var data_url = "requests/load_account_fields.php?gateway="+value;
				$.ajax({
					type: "GET",
					url: data_url,
					dataType: "html",
					success: function (data) {
						$("#account_fields").html(data);
					}
				});
			}
			</script>
			<?php
			if(isset($_POST['btn_add'])) {
				$name = protect($_POST['name']);
				$currency = protect($_POST['currency']);
				$min_amount = protect($_POST['min_amount']);
				$max_amount = protect($_POST['max_amount']);
				$reserve = protect($_POST['reserve']);
				$a_field_1 = protect($_POST['a_field_1']);
				$a_field_2 = protect($_POST['a_field_2']);
				$a_field_3 = protect($_POST['a_field_3']);
				$a_field_4 = protect($_POST['a_field_4']);
				$a_field_5 = protect($_POST['a_field_5']);
				$exchange_type = exchangetype($name);
				$fee = protect($_POST['fee']);
				$extra_fee = protect($_POST['extra_fee']);
				if(isset($_POST['include_fee'])) { $include_fee = '1'; } else { $include_fee = '0'; }
				if(isset($_POST['allow_send'])) { $allow_send = '1'; } else { $allow_send = '0'; }
				if(isset($_POST['allow_receive'])) { $allow_receive = '1'; } else { $allow_receive = '0'; }
				if(isset($_POST['default_send'])) {	$default_send = '1'; 	} else {	$default_send = '0';  }
				if(isset($_POST['default_receive'])) { $default_receive = '1'; } else { $default_receive = '0'; }
				$check = $db->query("SELECT * FROM bit_gateways WHERE name='$name' and currency='$currency'");
				if(empty($name) or empty($currency) or empty($min_amount) or empty($max_amount) or empty($reserve) or empty($fee) or empty($a_field_1)) { echo error("All fields are required."); }
				elseif($check->num_rows>0) { echo error("Gateway <b>$name $currency</b> was exists."); }
				elseif(!is_numeric($min_amount)) { echo error("Please enter minimal amount with numbers."); } 
				elseif(!is_numeric($max_amount)) { echo error("Please enter maximum amount with numbers."); }
				elseif(!is_numeric($reserve)) { echo error("Please enter reserve with numbers."); }
				elseif(!is_numeric($fee)) { echo error("Please enter fee with numbers."); }
				else {
					if($default_send == "1") { $update = $db->query("UPDATE bit_gateways SET default_send='0'"); }
					If($default_receive == "1") { $update = $db->query("UPDATE bit_gateways SET default_receive='0'"); }
					$insert = $db->query("INSERT bit_gateways (name,currency,include_fee,extra_fee,exchange_type,fee,min_amount,max_amount,reserve,allow_send,allow_receive,default_send,default_receive,a_field_1,a_field_2,a_field_3,a_field_4,a_field_5,status) VALUES ('$name','$currency','$include_fee','$extra_fee','$exchange_type','$fee','$min_amount','$max_amount','$reserve','$allow_send','$allow_receive','$default_send','$default_receive','$a_field_1','$a_field_2','$a_field_3','$a_field_4','$a_field_5','1')");
					echo success("Gateway <b>$name $currency</b> was added successfully.");
				}
			}
			?>
			
			<form action="" method="POST">
				<div class="form-group">
					<label>Gateway</label>
					<select class="form-control" name="name" onchange="load_account_fiels(this.value);">
						<option value="PayPal">PayPal</option>
						<option value="Skrill">Skrill</option>
						<option value="WebMoney">WebMoney</option>
						<option value="Payeer">Payeer</option>
						<option value="Perfect Money">Perfect Money</option>
						<option value="AdvCash">AdvCash</option>
						<option value="OKPay">OKPay</option>
						<option value="Entromoney">Entromoney</option>
						<option value="SolidTrust Pay">SolidTrust Pay</option>
						<option value="Neteller">Neteller</option>
						<option value="UQUID">UQUID</option>
						<option value="BTC-e">BTC-e</option>
						<option value="Yandex Money">Yandex Money</option>
						<option value="QIWI">QIWI</option>
						<option value="Payza">Payza</option>
						<option value="Bitcoin">Bitcoin</option>
						<option value="Litecoin">Litecoin</option>
						<option value="Dogecoin">Dogecoin</option>
						<option value="Dash">Dash</option>
						<option value="Peercoin">Peercoin</option>
						<option value="Ethereum">Ethereum</option>
						<option value="TheBillioncoin">TheBillioncoin</option>
						<option value="Bank Transfer">Bank Transfer</option>
						<option value="Western Union">Western Union</option>
						<option value="Moneygram">Moneygram</option>
					</select>
				</div>
				<div class="form-group">
					<label>Currency</label>
								<select class="form-control" name="currency">
											<option value="">----- Coins -----</option>
											<option value="BTC">BTC - Bitcoin</option>
											<option value="LTC">LTC - Litecoin</option>
											<option value="DOGE">DOGE - Dogecoin</option>
											<option value="DASH">DASH - Dash</option>
											<option value="PPC">PPC - Peercoin</option>
											<option value="ETH">ETH - Ethereum</option>
											<option value="TBC">TBC - TheBillioncoin</option>
											<option value="">----- Valuta -----</option>
											<option value="AED">AED - United Arab Emirates Dirham</option>
											<option value="AFN">AFN - Afghanistan Afghani</option>
											<option value="ALL">ALL - Albania Lek</option>
											<option value="AMD">AMD - Armenia Dram</option>
											<option value="ANG">ANG - Netherlands Antilles Guilder</option>
											<option value="AOA">AOA - Angola Kwanza</option>
											<option value="ARS">ARS - Argentina Peso</option>
											<option value="AUD">AUD - Australia Dollar</option>
											<option value="AWG">AWG - Aruba Guilder</option>
											<option value="AZN">AZN - Azerbaijan New Manat</option>
											<option value="BAM">BAM - Bosnia and Herzegovina Convertible Marka</option>
											<option value="BBD">BBD - Barbados Dollar</option>
											<option value="BDT">BDT - Bangladesh Taka</option>
											<option value="BGN">BGN - Bulgaria Lev</option>
											<option value="BHD">BHD - Bahrain Dinar</option>
											<option value="BIF">BIF - Burundi Franc</option>
											<option value="BMD">BMD - Bermuda Dollar</option>
											<option value="BND">BND - Brunei Darussalam Dollar</option>
											<option value="BOB">BOB - Bolivia Boliviano</option>
											<option value="BRL">BRL - Brazil Real</option>
											<option value="BSD">BSD - Bahamas Dollar</option>
											<option value="BTN">BTN - Bhutan Ngultrum</option>
											<option value="BWP">BWP - Botswana Pula</option>
											<option value="BYR">BYR - Belarus Ruble</option>
											<option value="BZD">BZD - Belize Dollar</option>
											<option value="CAD">CAD - Canada Dollar</option>
											<option value="CDF">CDF - Congo/Kinshasa Franc</option>
											<option value="CHF">CHF - Switzerland Franc</option>
											<option value="CLP">CLP - Chile Peso</option>
											<option value="CNY">CNY - China Yuan Renminbi</option>
											<option value="COP">COP - Colombia Peso</option>
											<option value="CRC">CRC - Costa Rica Colon</option>
											<option value="CUC">CUC - Cuba Convertible Peso</option>
											<option value="CUP">CUP - Cuba Peso</option>
											<option value="CVE">CVE - Cape Verde Escudo</option>
											<option value="CZK">CZK - Czech Republic Koruna</option>
											<option value="DJF">DJF - Djibouti Franc</option>
											<option value="DKK">DKK - Denmark Krone</option>
											<option value="DOP">DOP - Dominican Republic Peso</option>
											<option value="DZD">DZD - Algeria Dinar</option>
											<option value="EGP">EGP - Egypt Pound</option>
											<option value="ERN">ERN - Eritrea Nakfa</option>
											<option value="ETB">ETB - Ethiopia Birr</option>
											<option value="EUR">EUR - Euro Member Countries</option>
											<option value="FJD">FJD - Fiji Dollar</option>
											<option value="FKP">FKP - Falkland Islands (Malvinas) Pound</option>
											<option value="GBP">GBP - United Kingdom Pound</option>
											<option value="GEL">GEL - Georgia Lari</option>
											<option value="GGP">GGP - Guernsey Pound</option>
											<option value="GHS">GHS - Ghana Cedi</option>
											<option value="GIP">GIP - Gibraltar Pound</option>
											<option value="GMD">GMD - Gambia Dalasi</option>
											<option value="GNF">GNF - Guinea Franc</option>
											<option value="GTQ">GTQ - Guatemala Quetzal</option>
											<option value="GYD">GYD - Guyana Dollar</option>
											<option value="HKD">HKD - Hong Kong Dollar</option>
											<option value="HNL">HNL - Honduras Lempira</option>
											<option value="HPK">HRK - Croatia Kuna</option>
											<option value="HTG">HTG - Haiti Gourde</option>
											<option value="HUF">HUF - Hungary Forint</option>
											<option value="IDR">IDR - Indonesia Rupiah</option>
											<option value="ILS">ILS - Israel Shekel</option>
											<option value="IMP">IMP - Isle of Man Pound</option>
											<option value="INR">INR - India Rupee</option>
											<option value="IQD">IQD - Iraq Dinar</option>
											<option value="IRR">IRR - Iran Rial</option>
											<option value="ISK">ISK - Iceland Krona</option>
											<option value="JEP">JEP - Jersey Pound</option>
											<option value="JMD">JMD - Jamaica Dollar</option>
											<option value="JOD">JOD - Jordan Dinar</option>
											<option value="JPY">JPY - Japan Yen</option>
											<option value="KES">KES - Kenya Shilling</option>
											<option value="KGS">KGS - Kyrgyzstan Som</option>
											<option value="KHR">KHR - Cambodia Riel</option>
											<option value="KMF">KMF - Comoros Franc</option>
											<option value="KPW">KPW - Korea (North) Won</option>
											<option value="KRW">KRW - Korea (South) Won</option>
											<option value="KWD">KWD - Kuwait Dinar</option>
											<option value="KYD">KYD - Cayman Islands Dollar</option>
											<option value="KZT">KZT - Kazakhstan Tenge</option>
											<option value="LAK">LAK - Laos Kip</option>
											<option value="LBP">LBP - Lebanon Pound</option>
											<option value="LKR">LKR - Sri Lanka Rupee</option>
											<option value="LRD">LRD - Liberia Dollar</option>
											<option value="LSL">LSL - Lesotho Loti</option>
											<option value="LYD">LYD - Libya Dinar</option>
											<option value="MAD">MAD - Morocco Dirham</option>
											<option value="MDL">MDL - Moldova Leu</option>
											<option value="MGA">MGA - Madagascar Ariary</option>
											<option value="MKD">MKD - Macedonia Denar</option>
											<option value="MMK">MMK - Myanmar (Burma) Kyat</option>
											<option value="MNT">MNT - Mongolia Tughrik</option>
											<option value="MOP">MOP - Macau Pataca</option>
											<option value="MRO">MRO - Mauritania Ouguiya</option>
											<option value="MUR">MUR - Mauritius Rupee</option>
											<option value="MVR">MVR - Maldives (Maldive Islands) Rufiyaa</option>
											<option value="MWK">MWK - Malawi Kwacha</option>
											<option value="MXN">MXN - Mexico Peso</option>
											<option value="MYR">MYR - Malaysia Ringgit</option>
											<option value="MZN">MZN - Mozambique Metical</option>
											<option value="NAD">NAD - Namibia Dollar</option>
											<option value="NGN">NGN - Nigeria Naira</option>
											<option value="NTO">NIO - Nicaragua Cordoba</option>
											<option value="NOK">NOK - Norway Krone</option>
											<option value="NPR">NPR - Nepal Rupee</option>
											<option value="NZD">NZD - New Zealand Dollar</option>
											<option value="OMR">OMR - Oman Rial</option>
											<option value="PAB">PAB - Panama Balboa</option>
											<option value="PEN">PEN - Peru Nuevo Sol</option>
											<option value="PGK">PGK - Papua New Guinea Kina</option>
											<option value="PHP">PHP - Philippines Peso</option>
											<option value="PKR">PKR - Pakistan Rupee</option>
											<option value="PLN">PLN - Poland Zloty</option>
											<option value="PYG">PYG - Paraguay Guarani</option>
											<option value="QAR">QAR - Qatar Riyal</option>
											<option value="RON">RON - Romania New Leu</option>
											<option value="RSD">RSD - Serbia Dinar</option>
											<option value="RUB">RUB - Russia Ruble</option>
											<option value="RWF">RWF - Rwanda Franc</option>
											<option value="SAR">SAR - Saudi Arabia Riyal</option>
											<option value="SBD">SBD - Solomon Islands Dollar</option>
											<option value="SCR">SCR - Seychelles Rupee</option>
											<option value="SDG">SDG - Sudan Pound</option>
											<option value="SEK">SEK - Sweden Krona</option>
											<option value="SGD">SGD - Singapore Dollar</option>
											<option value="SHP">SHP - Saint Helena Pound</option>
											<option value="SLL">SLL - Sierra Leone Leone</option>
											<option value="SOS">SOS - Somalia Shilling</option>
											<option value="SRL">SPL* - Seborga Luigino</option>
											<option value="SRD">SRD - Suriname Dollar</option>
											<option value="STD">STD - Sao Tome and Principe Dobra</option>
											<option value="SVC">SVC - El Salvador Colon</option>
											<option value="SYP">SYP - Syria Pound</option>
											<option value="SZL">SZL - Swaziland Lilangeni</option>
											<option value="THB">THB - Thailand Baht</option>
											<option value="TJS">TJS - Tajikistan Somoni</option>
											<option value="TMT">TMT - Turkmenistan Manat</option>
											<option value="TND">TND - Tunisia Dinar</option>
											<option value="TOP">TOP - Tonga Pa'anga</option>
											<option value="TRY">TRY - Turkey Lira</option>
											<option value="TTD">TTD - Trinidad and Tobago Dollar</option>
											<option value="TVD">TVD - Tuvalu Dollar</option>
											<option value="TWD">TWD - Taiwan New Dollar</option>
											<option value="TZS">TZS - Tanzania Shilling</option>
											<option value="UAH">UAH - Ukraine Hryvnia</option>
											<option value="UGX">UGX - Uganda Shilling</option>
											<option value="USD">USD - United States Dollar</option>
											<option value="UYU">UYU - Uruguay Peso</option>
											<option value="UZS">UZS - Uzbekistan Som</option>
											<option value="VEF">VEF - Venezuela Bolivar</option>
											<option value="VND">VND - Viet Nam Dong</option>
											<option value="VUV">VUV - Vanuatu Vatu</option>
											<option value="WST">WST - Samoa Tala</option>
											<option value="XAF">XAF - Communaute Financiere Africaine (BEAC) CFA Franc BEAC</option>
											<option value="XCD">XCD - East Caribbean Dollar</option>
											<option value="XDR">XDR - International Monetary Fund (IMF) Special Drawing Rights</option>
											<option value="XOF">XOF - Communaute Financiere Africaine (BCEAO) Franc</option>
											<option value="XPF">XPF - Comptoirs Francais du Pacifique (CFP) Franc</option>
											<option value="YER">YER - Yemen Rial</option>
											<option value="ZAR">ZAR - South Africa Rand</option>
											<option value="ZMW">ZMW - Zambia Kwacha</option>
											<option value="ZWD">ZWD - Zimbabwe Dollar</option>
											<option value="USDT">USDT - Sonamiya</option>
									</select>
				</div>
				<div class="form-group">
					<label>Minimal amount for exchange</label>
					<input type="text" class="form-control" name="min_amount">
				</div>
				<div class="form-group">
					<label>Maximum amount for exchange</label>
					<input type="text" class="form-control" name="max_amount">
				</div>
				<div class="form-group">
					<label>Reserve</label>
					<input type="text" class="form-control" name="reserve">
				</div>
				<div class="form-group">
					<label>Fee</label>
					<input type="text" class="form-control" name="fee">
					<small>The exchange rate is automatically converted by Google Currency Convertor API, but API convert just exchange rate. So you have a profit you need to fill this field with a number she will act as a percentage. For example: If you enter the number 2 would mean 2%, and if users exchanged 100 dollars to euro exchange rate is 1 USD = 0.97 EUR, will receive the 96EUR with the real exchange rate and if you set 2% your profit of 96 EUR will It was 1.92 EUR and the customer will receive 94.08 EUR. Enter number without %.</small>
				</div>
				<div id="account_fields">
					<div class="form-group">
						<label>Your PayPal account</label>
						<input type="text" class="form-control" name="a_field_1">
					</div>
				</div>
				<div class="checkbox">
					<label><input type="checkbox" name="include_fee" value="yes"> Include extra fee in total amount for payment</label>
				</div>
				<div class="form-group">
					<label>Extra fee</label>
					<input type="text" class="form-control" name="extra_fee">
					<small>You can setup fixed or percentage fee. This fee will be used to calculate total amount for payment for client. For example: If user sell 100 and if fee is 10% must pay 110 or if user sell 50 and fee is fixed 5.99 must pay 55.99 and etc. If do not want to setup fee leave blank.</small>
				</div>
				<div class="checkbox">
					<label>
					  <input type="checkbox" name="allow_send" value="yes"> Allow customers to send money through this gateway
					</label>
				  </div>
				 <div class="checkbox">
					<label>
					  <input type="checkbox" name="allow_receive" value="yes"> Allow customers to receive money to this gateway
					</label>
				  </div>
				  <div class="checkbox">
					<label>
					  <input type="checkbox" name="default_send" value="yes"> To be the default for sending homepage
					</label>
				  </div>
				   <div class="checkbox">
					<label>
					  <input type="checkbox" name="default_receive" value="yes"> To be the default for receiving homepage
					</label>
				  </div>
				  <button type="submit" class="btn btn-primary" name="btn_add"><i class="fa fa-plus"></i> Add</button>
			</form>		
		</div>
	</div>
	<?php
} elseif($b == "add_external") {
	?>
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Administrator</a></li>
		<li><a href="./?a=gateways">Gateways</a></li>
		<li class="active">Add external gateway</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Add external gateway
		</div>
		<div class="panel-body">
			<?php
			if(isset($_POST['btn_add'])) {
				$name = protect($_POST['name']);
				$currency = protect($_POST['currency']);
				$min_amount = protect($_POST['min_amount']);
				$max_amount = protect($_POST['max_amount']);
				$reserve = protect($_POST['reserve']);
				$a_field_1 = protect($_POST['a_field_1']);
				$a_field_2 = protect($_POST['a_field_2']);
				$a_field_3 = protect($_POST['a_field_3']);
				$a_field_4 = protect($_POST['a_field_4']);
				$a_field_5 = protect($_POST['a_field_5']);
				$a_field_6 = protect($_POST['a_field_6']);
				$a_field_7 = protect($_POST['a_field_7']);
				$a_field_8 = protect($_POST['a_field_8']);
				$a_field_9 = protect($_POST['a_field_9']);
				$a_field_10 = protect($_POST['a_field_10']);
				$field_1 = protect($_POST['field_1']);
				$field_2 = protect($_POST['field_2']);
				$field_3 = protect($_POST['field_3']);
				$field_4 = protect($_POST['field_4']);
				$field_5 = protect($_POST['field_5']);
				$field_6 = protect($_POST['field_6']);
				$field_7 = protect($_POST['field_7']);
				$field_8 = protect($_POST['field_8']);
				$field_9 = protect($_POST['field_9']);
				$field_10 = protect($_POST['field_10']);
				$exchange_type = '3';
				$fee = protect($_POST['fee']);
				$extra_fee = protect($_POST['extra_fee']);
				$extensions = array('jpg','jpeg','png'); 
				$fileextension = end(explode('.',$_FILES['uploadFile']['name'])); 
				$fileextension = strtolower($fileextension); 
				if(isset($_POST['include_fee'])) { $include_fee = '1'; } else { $include_fee = '0'; }
				if(isset($_POST['allow_send'])) { $allow_send = '1'; } else { $allow_send = '0'; }
				if(isset($_POST['allow_receive'])) { $allow_receive = '1'; } else { $allow_receive = '0'; }
				if(isset($_POST['default_send'])) {	$default_send = '1'; 	} else {	$default_send = '0';  }
				if(isset($_POST['default_receive'])) { $default_receive = '1'; } else { $default_receive = '0'; }
				$check = $db->query("SELECT * FROM bit_gateways WHERE name='$name' and currency='$currency'");
				if(empty($name) or empty($currency) or empty($min_amount) or empty($max_amount) or empty($reserve) or empty($fee) or empty($a_field_1)) { echo error("All fields are required."); }
				elseif($check->num_rows>0) { echo error("Gateway <b>$name $currency</b> was exists."); }
				elseif(!is_numeric($min_amount)) { echo error("Please enter minimal amount with numbers."); } 
				elseif(!is_numeric($max_amount)) { echo error("Please enter maximum amount with numbers."); }
				elseif(!is_numeric($reserve)) { echo error("Please enter reserve with numbers."); }
				elseif(!is_numeric($fee)) { echo error("Please enter fee with numbers."); }
				elseif(!in_array($fileextension,$extensions)) { echo error("Allowed icon format jpg and png."); }
				else {
					if(!is_dir("../uploads")) {
						mkdir("../uploads",0777);
					}
					$upload_dir = '../';
					$iconpath = 'uploads/'.time().'_icon.'.$fileextension;
					$uploading = $upload_dir.$iconpath;
					@move_uploaded_file($_FILES['uploadFile']['tmp_name'],$uploading);
					if($default_send == "1") { $update = $db->query("UPDATE bit_gateways SET default_send='0'"); }
					If($default_receive == "1") { $update = $db->query("UPDATE bit_gateways SET default_receive='0'"); }
					$insert = $db->query("INSERT bit_gateways (name,currency,external_gateway,external_icon,include_fee,extra_fee,exchange_type,fee,min_amount,max_amount,reserve,allow_send,allow_receive,default_send,default_receive,a_field_1,a_field_2,a_field_3,a_field_4,a_field_5,a_field_6,a_field_7,a_field_8,a_field_9,a_field_10,status) VALUES ('$name','$currency','1','$iconpath','$include_fee','$extra_fee','$exchange_type','$fee','$min_amount','$max_amount','$reserve','$allow_send','$allow_receive','$default_send','$default_receive','$a_field_1','$a_field_2','$a_field_3','$a_field_4','$a_field_5','$a_field_6','$a_field_7','$a_field_8','$a_field_9','$a_field_10','1')");
					$query = $db->query("SELECT * FROM bit_gateways WHERE name='$name' ORDER BY id DESC LIMIT 1");
					$row = $query->fetch_assoc();
					if(!empty($field_1)) { $insert = $db->query("INSERT bit_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_1','1')"); }
					if(!empty($field_2)) { $insert = $db->query("INSERT bit_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_2','2')"); }
					if(!empty($field_3)) { $insert = $db->query("INSERT bit_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_3','3')"); }
					if(!empty($field_4)) { $insert = $db->query("INSERT bit_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_4','4')"); }
					if(!empty($field_5)) { $insert = $db->query("INSERT bit_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_5','5')"); }
					if(!empty($field_6)) { $insert = $db->query("INSERT bit_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_6','6')"); }
					if(!empty($field_7)) { $insert = $db->query("INSERT bit_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_7','7')"); }
					if(!empty($field_8)) { $insert = $db->query("INSERT bit_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_8','8')"); }
					if(!empty($field_9)) { $insert = $db->query("INSERT bit_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_9','9')"); }
					if(!empty($field_10)) { $insert = $db->query("INSERT bit_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$field_10','10')"); }
					echo success("Gateway <b>$name $currency</b> was added successfully.");
				}
			}
			?>
			<form action="" method="POST"  enctype="multipart/form-data">
				<div class="form-group">
					<label>Gateway name</label>
					<input type="text" class="form-control" name="name">
				</div>
				<div class="form-group">
					<label>Currency</label>
								<select class="form-control" name="currency">
											<option value="">----- Coins -----</option>
											<option value="BTC">BTC - Bitcoin</option>
											<option value="LTC">LTC - Litecoin</option>
											<option value="DOGE">DOGE - Dogecoin</option>
											<option value="DASH">DASH - Dash</option>
											<option value="PPC">PPC - Peercoin</option>
											<option value="ETH">ETH - Ethereum</option>
											<option value="TBC">TBC - TheBillioncoin</option>
											<option value="">----- Valuta -----</option>
											<option value="AED">AED - United Arab Emirates Dirham</option>
											<option value="AFN">AFN - Afghanistan Afghani</option>
											<option value="ALL">ALL - Albania Lek</option>
											<option value="AMD">AMD - Armenia Dram</option>
											<option value="ANG">ANG - Netherlands Antilles Guilder</option>
											<option value="AOA">AOA - Angola Kwanza</option>
											<option value="ARS">ARS - Argentina Peso</option>
											<option value="AUD">AUD - Australia Dollar</option>
											<option value="AWG">AWG - Aruba Guilder</option>
											<option value="AZN">AZN - Azerbaijan New Manat</option>
											<option value="BAM">BAM - Bosnia and Herzegovina Convertible Marka</option>
											<option value="BBD">BBD - Barbados Dollar</option>
											<option value="BDT">BDT - Bangladesh Taka</option>
											<option value="BGN">BGN - Bulgaria Lev</option>
											<option value="BHD">BHD - Bahrain Dinar</option>
											<option value="BIF">BIF - Burundi Franc</option>
											<option value="BMD">BMD - Bermuda Dollar</option>
											<option value="BND">BND - Brunei Darussalam Dollar</option>
											<option value="BOB">BOB - Bolivia Boliviano</option>
											<option value="BRL">BRL - Brazil Real</option>
											<option value="BSD">BSD - Bahamas Dollar</option>
											<option value="BTN">BTN - Bhutan Ngultrum</option>
											<option value="BWP">BWP - Botswana Pula</option>
											<option value="BYR">BYR - Belarus Ruble</option>
											<option value="BZD">BZD - Belize Dollar</option>
											<option value="CAD">CAD - Canada Dollar</option>
											<option value="CDF">CDF - Congo/Kinshasa Franc</option>
											<option value="CHF">CHF - Switzerland Franc</option>
											<option value="CLP">CLP - Chile Peso</option>
											<option value="CNY">CNY - China Yuan Renminbi</option>
											<option value="COP">COP - Colombia Peso</option>
											<option value="CRC">CRC - Costa Rica Colon</option>
											<option value="CUC">CUC - Cuba Convertible Peso</option>
											<option value="CUP">CUP - Cuba Peso</option>
											<option value="CVE">CVE - Cape Verde Escudo</option>
											<option value="CZK">CZK - Czech Republic Koruna</option>
											<option value="DJF">DJF - Djibouti Franc</option>
											<option value="DKK">DKK - Denmark Krone</option>
											<option value="DOP">DOP - Dominican Republic Peso</option>
											<option value="DZD">DZD - Algeria Dinar</option>
											<option value="EGP">EGP - Egypt Pound</option>
											<option value="ERN">ERN - Eritrea Nakfa</option>
											<option value="ETB">ETB - Ethiopia Birr</option>
											<option value="EUR">EUR - Euro Member Countries</option>
											<option value="FJD">FJD - Fiji Dollar</option>
											<option value="FKP">FKP - Falkland Islands (Malvinas) Pound</option>
											<option value="GBP">GBP - United Kingdom Pound</option>
											<option value="GEL">GEL - Georgia Lari</option>
											<option value="GGP">GGP - Guernsey Pound</option>
											<option value="GHS">GHS - Ghana Cedi</option>
											<option value="GIP">GIP - Gibraltar Pound</option>
											<option value="GMD">GMD - Gambia Dalasi</option>
											<option value="GNF">GNF - Guinea Franc</option>
											<option value="GTQ">GTQ - Guatemala Quetzal</option>
											<option value="GYD">GYD - Guyana Dollar</option>
											<option value="HKD">HKD - Hong Kong Dollar</option>
											<option value="HNL">HNL - Honduras Lempira</option>
											<option value="HPK">HRK - Croatia Kuna</option>
											<option value="HTG">HTG - Haiti Gourde</option>
											<option value="HUF">HUF - Hungary Forint</option>
											<option value="IDR">IDR - Indonesia Rupiah</option>
											<option value="ILS">ILS - Israel Shekel</option>
											<option value="IMP">IMP - Isle of Man Pound</option>
											<option value="INR">INR - India Rupee</option>
											<option value="IQD">IQD - Iraq Dinar</option>
											<option value="IRR">IRR - Iran Rial</option>
											<option value="ISK">ISK - Iceland Krona</option>
											<option value="JEP">JEP - Jersey Pound</option>
											<option value="JMD">JMD - Jamaica Dollar</option>
											<option value="JOD">JOD - Jordan Dinar</option>
											<option value="JPY">JPY - Japan Yen</option>
											<option value="KES">KES - Kenya Shilling</option>
											<option value="KGS">KGS - Kyrgyzstan Som</option>
											<option value="KHR">KHR - Cambodia Riel</option>
											<option value="KMF">KMF - Comoros Franc</option>
											<option value="KPW">KPW - Korea (North) Won</option>
											<option value="KRW">KRW - Korea (South) Won</option>
											<option value="KWD">KWD - Kuwait Dinar</option>
											<option value="KYD">KYD - Cayman Islands Dollar</option>
											<option value="KZT">KZT - Kazakhstan Tenge</option>
											<option value="LAK">LAK - Laos Kip</option>
											<option value="LBP">LBP - Lebanon Pound</option>
											<option value="LKR">LKR - Sri Lanka Rupee</option>
											<option value="LRD">LRD - Liberia Dollar</option>
											<option value="LSL">LSL - Lesotho Loti</option>
											<option value="LYD">LYD - Libya Dinar</option>
											<option value="MAD">MAD - Morocco Dirham</option>
											<option value="MDL">MDL - Moldova Leu</option>
											<option value="MGA">MGA - Madagascar Ariary</option>
											<option value="MKD">MKD - Macedonia Denar</option>
											<option value="MMK">MMK - Myanmar (Burma) Kyat</option>
											<option value="MNT">MNT - Mongolia Tughrik</option>
											<option value="MOP">MOP - Macau Pataca</option>
											<option value="MRO">MRO - Mauritania Ouguiya</option>
											<option value="MUR">MUR - Mauritius Rupee</option>
											<option value="MVR">MVR - Maldives (Maldive Islands) Rufiyaa</option>
											<option value="MWK">MWK - Malawi Kwacha</option>
											<option value="MXN">MXN - Mexico Peso</option>
											<option value="MYR">MYR - Malaysia Ringgit</option>
											<option value="MZN">MZN - Mozambique Metical</option>
											<option value="NAD">NAD - Namibia Dollar</option>
											<option value="NGN">NGN - Nigeria Naira</option>
											<option value="NTO">NIO - Nicaragua Cordoba</option>
											<option value="NOK">NOK - Norway Krone</option>
											<option value="NPR">NPR - Nepal Rupee</option>
											<option value="NZD">NZD - New Zealand Dollar</option>
											<option value="OMR">OMR - Oman Rial</option>
											<option value="PAB">PAB - Panama Balboa</option>
											<option value="PEN">PEN - Peru Nuevo Sol</option>
											<option value="PGK">PGK - Papua New Guinea Kina</option>
											<option value="PHP">PHP - Philippines Peso</option>
											<option value="PKR">PKR - Pakistan Rupee</option>
											<option value="PLN">PLN - Poland Zloty</option>
											<option value="PYG">PYG - Paraguay Guarani</option>
											<option value="QAR">QAR - Qatar Riyal</option>
											<option value="RON">RON - Romania New Leu</option>
											<option value="RSD">RSD - Serbia Dinar</option>
											<option value="RUB">RUB - Russia Ruble</option>
											<option value="RWF">RWF - Rwanda Franc</option>
											<option value="SAR">SAR - Saudi Arabia Riyal</option>
											<option value="SBD">SBD - Solomon Islands Dollar</option>
											<option value="SCR">SCR - Seychelles Rupee</option>
											<option value="SDG">SDG - Sudan Pound</option>
											<option value="SEK">SEK - Sweden Krona</option>
											<option value="SGD">SGD - Singapore Dollar</option>
											<option value="SHP">SHP - Saint Helena Pound</option>
											<option value="SLL">SLL - Sierra Leone Leone</option>
											<option value="SOS">SOS - Somalia Shilling</option>
											<option value="SRL">SPL* - Seborga Luigino</option>
											<option value="SRD">SRD - Suriname Dollar</option>
											<option value="STD">STD - Sao Tome and Principe Dobra</option>
											<option value="SVC">SVC - El Salvador Colon</option>
											<option value="SYP">SYP - Syria Pound</option>
											<option value="SZL">SZL - Swaziland Lilangeni</option>
											<option value="THB">THB - Thailand Baht</option>
											<option value="TJS">TJS - Tajikistan Somoni</option>
											<option value="TMT">TMT - Turkmenistan Manat</option>
											<option value="TND">TND - Tunisia Dinar</option>
											<option value="TOP">TOP - Tonga Pa'anga</option>
											<option value="TRY">TRY - Turkey Lira</option>
											<option value="TTD">TTD - Trinidad and Tobago Dollar</option>
											<option value="TVD">TVD - Tuvalu Dollar</option>
											<option value="TWD">TWD - Taiwan New Dollar</option>
											<option value="TZS">TZS - Tanzania Shilling</option>
											<option value="UAH">UAH - Ukraine Hryvnia</option>
											<option value="UGX">UGX - Uganda Shilling</option>
											<option value="USD">USD - United States Dollar</option>
											<option value="UYU">UYU - Uruguay Peso</option>
											<option value="UZS">UZS - Uzbekistan Som</option>
											<option value="VEF">VEF - Venezuela Bolivar</option>
											<option value="VND">VND - Viet Nam Dong</option>
											<option value="VUV">VUV - Vanuatu Vatu</option>
											<option value="WST">WST - Samoa Tala</option>
											<option value="XAF">XAF - Communaute Financiere Africaine (BEAC) CFA Franc BEAC</option>
											<option value="XCD">XCD - East Caribbean Dollar</option>
											<option value="XDR">XDR - International Monetary Fund (IMF) Special Drawing Rights</option>
											<option value="XOF">XOF - Communaute Financiere Africaine (BCEAO) Franc</option>
											<option value="XPF">XPF - Comptoirs Francais du Pacifique (CFP) Franc</option>
											<option value="YER">YER - Yemen Rial</option>
											<option value="ZAR">ZAR - South Africa Rand</option>
											<option value="ZMW">ZMW - Zambia Kwacha</option>
											<option value="ZWD">ZWD - Zimbabwe Dollar</option>
											<option value="USDT">USDT - Sonamiya</option>
									</select>
				</div>
				<div class="form-group">
					<label>Minimal amount for exchange</label>
					<input type="text" class="form-control" name="min_amount">
				</div>
				<div class="form-group">
					<label>Maximum amount for exchange</label>
					<input type="text" class="form-control" name="max_amount">
				</div>
				<div class="form-group">
					<label>Reserve</label>
					<input type="text" class="form-control" name="reserve">
				</div>
				<div class="form-group">
					<label>Fee</label>
					<input type="text" class="form-control" name="fee">
					<small>The exchange rate is automatically converted by Google Currency Convertor API, but API convert just exchange rate. So you have a profit you need to fill this field with a number she will act as a percentage. For example: If you enter the number 2 would mean 2%, and if users exchanged 100 dollars to euro exchange rate is 1 USD = 0.97 EUR, will receive the 96EUR with the real exchange rate and if you set 2% your profit of 96 EUR will It was 1.92 EUR and the customer will receive 94.08 EUR. Enter number without %.</small>
				</div>
				<div id="account_fields">
					<div class="row">
						<div class="col-md-12"><?php echo info("<b>Name of the field</b> will be required by user when make exchange by this gateway. For example if you adding Bank Gateway enter for field name <b>SGBank Name</b> and etc.. For <b>Value of the field</b> need to enter your data for field, when user sell to this gateway will show data for payment in fields you are entered. You can add up to 10 fields."); ?></div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 1</label>
								<input type="text" class="form-control" name="field_1">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 1</label>
								<input type="text" class="form-control" name="a_field_1">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 2</label>
								<input type="text" class="form-control" name="field_2">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 2</label>
								<input type="text" class="form-control" name="a_field_2">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 3</label>
								<input type="text" class="form-control" name="field_3">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 3</label>
								<input type="text" class="form-control" name="a_field_3">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 4</label>
								<input type="text" class="form-control" name="field_4">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 4</label>
								<input type="text" class="form-control" name="a_field_4">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 5</label>
								<input type="text" class="form-control" name="field_5">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 5</label>
								<input type="text" class="form-control" name="a_field_5">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 6</label>
								<input type="text" class="form-control" name="field_6">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 6</label>
								<input type="text" class="form-control" name="a_field_6">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 7</label>
								<input type="text" class="form-control" name="field_7">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 7</label>
								<input type="text" class="form-control" name="a_field_7">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 8</label>
								<input type="text" class="form-control" name="field_8">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 8</label>
								<input type="text" class="form-control" name="a_field_8">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 9</label>
								<input type="text" class="form-control" name="field_9">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 9</label>
								<input type="text" class="form-control" name="a_field_9">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 10</label>
								<input type="text" class="form-control" name="field_10">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 10</label>
								<input type="text" class="form-control" name="a_field_10">
							</div>
						</div>
					</div>
				</div>
				<div class="checkbox">
					<label><input type="checkbox" name="include_fee" value="yes"> Include extra fee in total amount for payment</label>
				</div>
				<div class="form-group">
					<label>Extra fee</label>
					<input type="text" class="form-control" name="extra_fee">
					<small>You can setup fixed or percentage fee. This fee will be used to calculate total amount for payment for client. For example: If user sell 100 and if fee is 10% must pay 110 or if user sell 50 and fee is fixed 5.99 must pay 55.99 and etc. If do not want to setup fee leave blank.</small>
				</div>
				<div class="checkbox">
					<label>
					  <input type="checkbox" name="allow_send" value="yes"> Allow customers to send money through this gateway
					</label>
				  </div>
				 <div class="checkbox">
					<label>
					  <input type="checkbox" name="allow_receive" value="yes"> Allow customers to receive money to this gateway
					</label>
				  </div>
				  <div class="checkbox">
					<label>
					  <input type="checkbox" name="default_send" value="yes"> To be the default for sending homepage
					</label>
				  </div>
				   <div class="checkbox">
					<label>
					  <input type="checkbox" name="default_receive" value="yes"> To be the default for receiving homepage
					</label>
				  </div>
				  <div class="form-group">
						<label>Select icon to upload (format: jpg, png, recommended size: 48x48,56x66 and etc..)</label>
						<input type="file" name="uploadFile" class="form-control">
					</div>
				  <button type="submit" class="btn btn-primary" name="btn_add"><i class="fa fa-plus"></i> Add</button>
			</form>		
		</div>
	</div>
	<?php
} elseif($b == "edit") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM bit_gateways WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=gateways"); }
	$row = $query->fetch_assoc();
	?>
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Administrator</a></li>
		<li><a href="./?a=gateways">Gateways</a></li>
		<li class="active">Edit gateway</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Edit gateway
		</div>
		<div class="panel-body">
			<?php
			if(isset($_POST['btn_save'])) {
				$min_amount = protect($_POST['min_amount']);
				$max_amount = protect($_POST['max_amount']);
				$reserve = protect($_POST['reserve']);
				$a_field_1 = protect($_POST['a_field_1']);
				$a_field_2 = protect($_POST['a_field_2']);
				$a_field_3 = protect($_POST['a_field_3']);
				$a_field_4 = protect($_POST['a_field_4']);
				$a_field_5 = protect($_POST['a_field_5']);
				$fee = protect($_POST['fee']);
				$extra_fee = protect($_POST['extra_fee']);
				if(isset($_POST['include_fee'])) { $include_fee = '1'; } else { $include_fee = '0'; }
				if(isset($_POST['allow_send'])) { $allow_send = '1'; } else { $allow_send = '0'; }
				if(isset($_POST['allow_receive'])) { $allow_receive = '1'; } else { $allow_receive = '0'; }
				if(isset($_POST['default_send'])) {	$default_send = '1'; 	} else {	$default_send = '0';  }
				if(isset($_POST['default_receive'])) { $default_receive = '1'; } else { $default_receive = '0'; }
				if(empty($min_amount) or empty($max_amount) or empty($reserve) or empty($fee) or empty($a_field_1)) { echo error("All fields are required."); }
				elseif(!is_numeric($min_amount)) { echo error("Please enter minimal amount with numbers."); } 
				elseif(!is_numeric($max_amount)) { echo error("Please enter maximum amount with numbers."); }
				elseif(!is_numeric($reserve)) { echo error("Please enter reserve with numbers."); }
				elseif(!is_numeric($fee)) { echo error("Please enter fee with numbers."); }
				else {
					if($default_send == "1") { $update = $db->query("UPDATE bit_gateways SET default_send='0'"); }
					If($default_receive == "1") { $update = $db->query("UPDATE bit_gateways SET default_receive='0'"); }
					$update = $db->query("UPDATE bit_gateways SET min_amount='$min_amount',include_fee='$include_fee',extra_fee='$extra_fee',fee='$fee',max_amount='$max_amount',reserve='$reserve',allow_send='$allow_send',allow_receive='$allow_receive',default_send='$default_send',default_receive='$default_receive',a_field_1='$a_field_1',a_field_2='$a_field_2',a_field_3='$a_field_3',a_field_4='$a_field_4',a_field_5='$a_field_5' WHERE id='$row[id]'");
					$query = $db->query("SELECT * FROM bit_gateways WHERE id='$row[id]'");
					$row = $query->fetch_assoc();
					echo success("Your changes was saved successfully.");
				}
			}
			?>
			
			<form action="" method="POST">
				<div class="form-group">
					<label>Gateway</label>
					<input type="text" class="form-control" disabled value="<?php echo $row['name']." ".$row['currency']; ?>">
				</div>
				<div class="form-group">
					<label>Minimal amount for exchange</label>
					<input type="text" class="form-control" name="min_amount" value="<?php echo $row['min_amount']; ?>">
				</div>
				<div class="form-group">
					<label>Maximum amount for exchange</label>
					<input type="text" class="form-control" name="max_amount" value="<?php echo $row['max_amount']; ?>">
				</div>
				<div class="form-group">
					<label>Reserve</label>
					<input type="text" class="form-control" name="reserve" value="<?php echo $row['reserve']; ?>">
				</div>
				<div class="form-group">
					<label>Fee</label>
					<input type="text" class="form-control" name="fee" value="<?php echo $row['fee']; ?>">
					<small>The exchange rate is automatically converted by Google Currency Convertor API, but API convert just exchange rate. So you have a profit you need to fill this field with a number she will act as a percentage. For example: If you enter the number 2 would mean 2%, and if users exchanged 100 dollars to euro exchange rate is 1 USD = 0.97 EUR, will receive the 96EUR with the real exchange rate and if you set 2% your profit of 96 EUR will It was 1.92 EUR and the customer will receive 94.08 EUR. Enter number without %.</small>
				</div>
				<div id="account_fields">
					<?php
					$gateway = $row['name'];
					if($gateway == "PayPal") {
						?>
						<div class="form-group">
							<label>Your PayPal account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Skrill") {
						?>
						<div class="form-group">
							<label>Your Skrill account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Your Skrill secret key</label>
							<input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
						</div>
						<?php
					} elseif($gateway == "WebMoney") {
						?>
						<div class="form-group">
							<label>Your WebMoney account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Payeer") {
						?>
						<div class="form-group">
							<label>Your Payeer account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Your Payeer secret key</label>
							<input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
						</div>
						<?php
					} elseif($gateway == "Perfect Money") {
						?>
						<div class="form-group">
							<label>Your Perfect Money account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Account ID or API NAME</label>
							<input type="text" class="form-control" name="a_field_3" value="<?php echo $row['a_field_3']; ?>">
						</div>
						<div class="form-group">
							<label>Passpharse</label>
							<input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
							<small>Alternate Passphrase you entered in your Perfect Money account.</small>
						</div>
						<?php
					} elseif($gateway == "AdvCash") {
						?>
						<div class="form-group">
							<label>Your AdvCash account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "OKPay") {
						?>
						<div class="form-group">
							<label>Your OKPay account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Entromoney") { 
						?>
						<div class="form-group">
							<label>Your Entromoney Account ID</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Your Entromoney Receiver (Example: U11111111 or E1111111)</label>
							<input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
						</div>
						<div class="form-group">
							<label>SCI ID</label>
							<input type="text" class="form-control" name="a_field_3" value="<?php echo $row['a_field_3']; ?>">
						</div>
						<div class="form-group">
							<label>SCI PASS</label>
							<input type="text" class="form-control" name="a_field_4" value="<?php echo $row['a_field_4']; ?>">
						</div>
						<?php
					} elseif($gateway == "SolidTrust Pay") {
						?>
						<div class="form-group">
							<label>Your SolidTrust Pay account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>SCI Name</label>
							<input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
						</div>
						<div class="form-group">
							<label>SCI Password</label>
							<input type="text" class="form-control" name="a_field_3" value="<?php echo $row['a_field_3']; ?>">
						</div>
						<?php
					} elseif($gateway == "Neteller") {
						?>
						<div class="form-group">
							<label>Your Neteller account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "UQUID") {
						?>
						<div class="form-group">
							<label>Your UQUID account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "BTC-e") {
						?>
						<div class="form-group">
							<label>Your BTC-e account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Yandex Money") {
						?>
						<div class="form-group">
							<label>Your Yandex Money account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "QIWI") {
						?>
						<div class="form-group">
							<label>Your QIWI account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Payza") {
						?>
						<div class="form-group">
							<label>Your Payza account</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>IPN SECURITY CODE</label>
							<input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
						</div>
						<?php
					} elseif($gateway == "Bitcoin") {
						?>
						<div class="form-group">
							<label>Your Bitcoin address</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Litecoin") {
						?>
						<div class="form-group">
							<label>Your Litecoin address</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Dogecoin") {
						?>
						<div class="form-group">
							<label>Your Dogecoin address</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Dash") {
						?>
						<div class="form-group">
							<label>Your Dash address</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Peercoin") {
						?>
						<div class="form-group">
							<label>Your Peercoin address</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Ethereum") {
						?>
						<div class="form-group">
							<label>Your Ethereum address</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<?php
					} elseif($gateway == "Bank Transfer") {
						?>
						<div class="form-group">
							<label>Bank Account Holder's Name</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Bank Account Number/IBAN</label>
							<input type="text" class="form-control" name="a_field_4" value="<?php echo $row['a_field_4']; ?>">
						</div>
						<div class="form-group">
							<label>SWIFT Code</label>
							<input type="text" class="form-control" name="a_field_5" value="<?php echo $row['a_field_5']; ?>">
						</div>
						<div class="form-group">
							<label>Bank Name in Full</label>
							<input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
						</div>
						<div class="form-group">
							<label>Bank Branch Country, City, Address</label>
							<input type="text" class="form-control" name="a_field_3" value="<?php echo $row['a_field_3']; ?>">
						</div>
						<?php
					} elseif($gateway == "Western Union") {
						?>
						<div class="form-group">
							<label>Your name (For money receiving)</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Your location (For money receiving)</label>
							<input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
						</div>
						<?php
					} elseif($gateway == "Moneygram") {
						?>
						<div class="form-group">
							<label>Your name (For money receiving)</label>
							<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
						</div>
						<div class="form-group">
							<label>Your location (For money receiving)</label>
							<input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
						</div>
						<?php
					} else {}
					?>
				</div>
				<div class="checkbox">
					<label><input type="checkbox" name="include_fee" value="yes" <?php if($row['include_fee'] == "1") { echo 'checked'; } ?>> Include extra fee in total amount for payment</label>
				</div>
				<div class="form-group">
					<label>Extra fee</label>
					<input type="text" class="form-control" name="extra_fee" value="<?php echo $row['extra_fee']; ?>">
					<small>You can setup fixed or percentage fee. This fee will be used to calculate total amount for payment for client. For example: If user sell 100 and if fee is 10% must pay 110 or if user sell 50 and fee is fixed 5.99 must pay 55.99 and etc. If do not want to setup fee leave blank.</small>
				</div>
				<div class="checkbox">
					<label>
					  <input type="checkbox" name="allow_send" value="yes" <?php if($row['allow_send'] == "1") { echo 'checked'; } ?>> Allow customers to send money through this gateway
					</label>
				  </div>
				 <div class="checkbox">
					<label>
					  <input type="checkbox" name="allow_receive" value="yes" <?php if($row['allow_receive'] == "1") { echo 'checked'; } ?>> Allow customers to receive money to this gateway
					</label>
				  </div>
				  <div class="checkbox">
					<label>
					  <input type="checkbox" name="default_send" value="yes" <?php if($row['default_send'] == "1") { echo 'checked'; } ?>> To be the default for sending homepage
					</label>
				  </div>
				   <div class="checkbox">
					<label>
					  <input type="checkbox" name="default_receive" value="yes" <?php if($row['default_receive'] == "1") { echo 'checked'; } ?>> To be the default for receiving homepage
					</label>
				  </div>
				  <button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
			</form>
		</div>
	</div>
	<?php
} elseif($b == "edit_external") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM bit_gateways WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=gateways"); }
	$row = $query->fetch_assoc();
	?>
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Administrator</a></li>
		<li><a href="./?a=gateways">Gateways</a></li>
		<li class="active">Edit gateway</li>
	</ol>

	<div class="panel panel-default">
		<div class="panel-heading">
			Edit gateway
		</div>
		<div class="panel-body">
			<?php
			if(isset($_POST['btn_save'])) {
				$min_amount = protect($_POST['min_amount']);
				$max_amount = protect($_POST['max_amount']);
				$reserve = protect($_POST['reserve']);
				$a_field_1 = protect($_POST['a_field_1']);
				$a_field_2 = protect($_POST['a_field_2']);
				$a_field_3 = protect($_POST['a_field_3']);
				$a_field_4 = protect($_POST['a_field_4']);
				$a_field_5 = protect($_POST['a_field_5']);
				$a_field_6 = protect($_POST['a_field_6']);
				$a_field_7 = protect($_POST['a_field_7']);
				$a_field_8 = protect($_POST['a_field_8']);
				$a_field_9 = protect($_POST['a_field_9']);
				$a_field_10 = protect($_POST['a_field_10']);
				$field_1 = protect($_POST['field_1']);
				$field_2 = protect($_POST['field_2']);
				$field_3 = protect($_POST['field_3']);
				$field_4 = protect($_POST['field_4']);
				$field_5 = protect($_POST['field_5']);
				$field_6 = protect($_POST['field_6']);
				$field_7 = protect($_POST['field_7']);
				$field_8 = protect($_POST['field_8']);
				$field_9 = protect($_POST['field_9']);
				$field_10 = protect($_POST['field_10']);
				$fee = protect($_POST['fee']);
				$extra_fee = protect($_POST['extra_fee']);
				if(isset($_POST['include_fee'])) { $include_fee = '1'; } else { $include_fee = '0'; }
				if(isset($_POST['allow_send'])) { $allow_send = '1'; } else { $allow_send = '0'; }
				if(isset($_POST['allow_receive'])) { $allow_receive = '1'; } else { $allow_receive = '0'; }
				if(isset($_POST['default_send'])) {	$default_send = '1'; 	} else {	$default_send = '0';  }
				if(isset($_POST['default_receive'])) { $default_receive = '1'; } else { $default_receive = '0'; }
				if(empty($min_amount) or empty($max_amount) or empty($reserve) or empty($fee) or empty($a_field_1)) { echo error("All fields are required."); }
				elseif(!is_numeric($min_amount)) { echo error("Please enter minimal amount with numbers."); } 
				elseif(!is_numeric($max_amount)) { echo error("Please enter maximum amount with numbers."); }
				elseif(!is_numeric($reserve)) { echo error("Please enter reserve with numbers."); }
				elseif(!is_numeric($fee)) { echo error("Please enter fee with numbers."); }
				else {
					foreach($_POST['field'] as $k => $v) {
						if(!empty($v)) {
							$check = $db->query("SELECT * FROM bit_gateways_fields WHERE gateway_id='$row[id]' and field_number='$k'");
							if($check->num_rows>0) {
								$update = $db->query("UPDATE bit_gateways_fields SET field_name='$v' WHERE gateway_id='$row[id]' and field_number='$k'");
							} else {
								$insert = $db->query("INSERT bit_gateways_fields (gateway_id,field_name,field_number) VALUES ('$row[id]','$v','$k')");
							}
						}
					}
					if($default_send == "1") { $update = $db->query("UPDATE bit_gateways SET default_send='0'"); }
					If($default_receive == "1") { $update = $db->query("UPDATE bit_gateways SET default_receive='0'"); }
					$update = $db->query("UPDATE bit_gateways SET min_amount='$min_amount',include_fee='$include_fee',extra_fee='$extra_fee',fee='$fee',max_amount='$max_amount',reserve='$reserve',allow_send='$allow_send',allow_receive='$allow_receive',default_send='$default_send',default_receive='$default_receive',a_field_1='$a_field_1',a_field_2='$a_field_2',a_field_3='$a_field_3',a_field_4='$a_field_4',a_field_5='$a_field_5',a_field_6='$a_field_6',a_field_7='$a_field_7',a_field_8='$a_field_8',a_field_9='$a_field_9',a_field_10='$a_field_10' WHERE id='$row[id]'");
					$query = $db->query("SELECT * FROM bit_gateways WHERE id='$row[id]'");
					$row = $query->fetch_assoc();
					echo success("Your changes was saved successfully.");
				}
			}
			?>
			
			<form action="" method="POST">
				<div class="form-group">
					<label>Gateway</label>
					<input type="text" class="form-control" disabled value="<?php echo $row['name']." ".$row['currency']; ?>">
				</div>
				<div class="form-group">
					<label>Minimal amount for exchange</label>
					<input type="text" class="form-control" name="min_amount" value="<?php echo $row['min_amount']; ?>">
				</div>
				<div class="form-group">
					<label>Maximum amount for exchange</label>
					<input type="text" class="form-control" name="max_amount" value="<?php echo $row['max_amount']; ?>">
				</div>
				<div class="form-group">
					<label>Reserve</label>
					<input type="text" class="form-control" name="reserve" value="<?php echo $row['reserve']; ?>">
				</div>
				<div class="form-group">
					<label>Fee</label>
					<input type="text" class="form-control" name="fee" value="<?php echo $row['fee']; ?>">
					<small>The exchange rate is automatically converted by Google Currency Convertor API, but API convert just exchange rate. So you have a profit you need to fill this field with a number she will act as a percentage. For example: If you enter the number 2 would mean 2%, and if users exchanged 100 dollars to euro exchange rate is 1 USD = 0.97 EUR, will receive the 96EUR with the real exchange rate and if you set 2% your profit of 96 EUR will It was 1.92 EUR and the customer will receive 94.08 EUR. Enter number without %.</small>
				</div>
				<div id="account_fields">
					<?php
					$fieldsquery = $db->query("SELECT * FROM bit_gateways_fields WHERE gateway_id='$row[id]' ORDER BY id");
					if($fieldsquery->num_rows>0) {
						while($field = $fieldsquery->fetch_assoc()) {
							$f[$field[field_number]] = $field[field_name];
						}
					}
					?>
					<div class="row">
						<div class="col-md-12"><?php echo info("<b>Name of the field</b> will be required by user when make exchange by this gateway. For example if you adding Bank Gateway enter for field name <b>SGBank Name</b> and etc.. For <b>Value of the field</b> need to enter your data for field, when user sell to this gateway will show data for payment in fields you are entered. You can add up to 10 fields."); ?></div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 1</label>
								<input type="text" class="form-control" name="field[1]" value="<?php echo $f[1]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 1</label>
								<input type="text" class="form-control" name="a_field_1" value="<?php echo $row['a_field_1']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 2</label>
								<input type="text" class="form-control" name="field[2]" value="<?php echo $f[2]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 2</label>
								<input type="text" class="form-control" name="a_field_2" value="<?php echo $row['a_field_2']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 3</label>
								<input type="text" class="form-control" name="field[3]" value="<?php echo $f[3]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 3</label>
								<input type="text" class="form-control" name="a_field_3" value="<?php echo $row['a_field_3']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 4</label>
								<input type="text" class="form-control" name="field[4]" value="<?php echo $f[4]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 4</label>
								<input type="text" class="form-control" name="a_field_4" value="<?php echo $row['a_field_4']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 5</label>
								<input type="text" class="form-control" name="field[5]" value="<?php echo $f[5]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 5</label>
								<input type="text" class="form-control" name="a_field_5" value="<?php echo $row['a_field_5']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 6</label>
								<input type="text" class="form-control" name="field[6]" value="<?php echo $f[6]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 6</label>
								<input type="text" class="form-control" name="a_field_6" value="<?php echo $row['a_field_6']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 7</label>
								<input type="text" class="form-control" name="field[7]" value="<?php echo $f[7]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 7</label>
								<input type="text" class="form-control" name="a_field_7" value="<?php echo $row['a_field_7']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 8</label>
								<input type="text" class="form-control" name="field[8]" value="<?php echo $f[8]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 8</label>
								<input type="text" class="form-control" name="a_field_8" value="<?php echo $row['a_field_8']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 9</label>
								<input type="text" class="form-control" name="field[9]" value="<?php echo $f[9]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 9</label>
								<input type="text" class="form-control" name="a_field_9" value="<?php echo $row['a_field_9']; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Name of the Field 10</label>
								<input type="text" class="form-control" name="field[10]" value="<?php echo $f[10]; ?>">
							</div>
						</div>
						<div class="col-md-6 col-lg-6">
							<div class="form-group">
								<label>Value of the Field 10</label>
								<input type="text" class="form-control" name="a_field_10" value="<?php echo $row['a_field_10']; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="checkbox">
					<label><input type="checkbox" name="include_fee" value="yes" <?php if($row['include_fee'] == "1") { echo 'checked'; } ?>> Include extra fee in total amount for payment</label>
				</div>
				<div class="form-group">
					<label>Extra fee</label>
					<input type="text" class="form-control" name="extra_fee" value="<?php echo $row['extra_fee']; ?>">
					<small>You can setup fixed or percentage fee. This fee will be used to calculate total amount for payment for client. For example: If user sell 100 and if fee is 10% must pay 110 or if user sell 50 and fee is fixed 5.99 must pay 55.99 and etc. If do not want to setup fee leave blank.</small>
				</div>
				<div class="checkbox">
					<label>
					  <input type="checkbox" name="allow_send" value="yes" <?php if($row['allow_send'] == "1") { echo 'checked'; } ?>> Allow customers to send money through this gateway
					</label>
				  </div>
				 <div class="checkbox">
					<label>
					  <input type="checkbox" name="allow_receive" value="yes" <?php if($row['allow_receive'] == "1") { echo 'checked'; } ?>> Allow customers to receive money to this gateway
					</label>
				  </div>
				  <div class="checkbox">
					<label>
					  <input type="checkbox" name="default_send" value="yes" <?php if($row['default_send'] == "1") { echo 'checked'; } ?>> To be the default for sending homepage
					</label>
				  </div>
				   <div class="checkbox">
					<label>
					  <input type="checkbox" name="default_receive" value="yes" <?php if($row['default_receive'] == "1") { echo 'checked'; } ?>> To be the default for receiving homepage
					</label>
				  </div>
				  <button type="submit" class="btn btn-primary" name="btn_save"><i class="fa fa-check"></i> Save changes</button>
			</form>
		</div>
	</div>
	<?php
} elseif($b == "delete") {
	$id = protect($_GET['id']);
	$query = $db->query("SELECT * FROM bit_gateways WHERE id='$id'");
	if($query->num_rows==0) { header("Location: ./?a=gateways"); }
	$row = $query->fetch_assoc();
	?>
	<ol class="breadcrumb">
		<li><a href="./">BitExchanger Administrator</a></li>
		<li><a href="./?a=gateways">Gateways</a></li>
		<li class="active">Delete gateway</li>
	</ol>

	<div class="panel panel-danger">
		<div class="panel-heading">
			Delete gateway
		</div>
		<div class="panel-body">
			<?php
			if(isset($_GET['confirm'])) {
				$delete = $db->query("DELETE FROM bit_gateways WHERE id='$row[id]'");
				$delete = $db->query("DELETE FROM bit_exchanges WHERE gateway_send='$row[id]'");
				$delete = $db->query("DELETE FROM bit_exchanges WHERE gateway_receive='$row[id]'");
				echo success("Gateway <b>$row[name] $row[currency]</b> was deleted.");
			} else {
				echo info("Are you sure you want to delete gateway <b>$row[name] $row[currency]</b>?");
				echo '<a href="./?a=gateways&b=delete&id='.$row[id].'&confirm=1" class="btn btn-success"><i class="fa fa-check"></i> Yes</a>&nbsp;&nbsp;
					<a href="./?a=gateways" class="btn btn-danger"><i class="fa fa-times"></i> No</a>';
			}
			?>
		</div>
	</div>
	<?php
} else {
?>
<ol class="breadcrumb">
	<li><a href="./">BitExchanger Administrator</a></li>
	<li class="active">Gateways</li>
</ol>

<div class="panel panel-default">
	<div class="panel-heading">
		Gateways
		<span class="pull-right">
			<a href="./?a=gateways&b=add"><i class="fa fa-plus"></i> Add gateway</a>, <a href="./?a=gateways&b=add_external"><i class="fa fa-plus"></i> Add external gateway</a>
		</span>
	</div>
	<div class="panel-body">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Gateway name</th>
					<th>Min. amount</th>
					<th>Max. amount</th>
					<th>Reserve</th>
					<th>Fee</th>
					<th>Allow send</th>
					<th>Allow receive</th>
					<th>Default send</th>
					<th>Default receive</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$query = $db->query("SELECT * FROM bit_gateways ORDER BY id");
				if($query->num_rows>0) {
					while($row = $query->fetch_assoc()) {
						?>
						<tr>
							<td><?php echo $row['name']." ".$row['currency']; ?></td>
							<td><?php echo $row['min_amount']." ".$row['currency']; ?></td>
							<td><?php echo $row['max_amount']." ".$row['currency']; ?></td>
							<td><?php echo $row['reserve']." ".$row['currency']; ?></td>
							<td><?php echo $row['fee']; ?>%</td>
							<td><?php if($row['allow_send'] == "1") { echo '<span class="text text-success"><i class="fa fa-check"></i></span>'; } else { echo '<span class="text text-danger"><i class="fa fa-times"></i></span>'; } ?></td>
							<td><?php if($row['allow_receive'] == "1") { echo '<span class="text text-success"><i class="fa fa-check"></i></span>'; } else { echo '<span class="text text-danger"><i class="fa fa-times"></i></span>'; } ?></td>
							<td><?php if($row['default_send'] == "1") { echo '<span class="text text-success"><i class="fa fa-check"></i></span>'; } else { echo '<span class="text text-danger"><i class="fa fa-times"></i></span>'; } ?></td>
							<td><?php if($row['default_receive'] == "1") { echo '<span class="text text-success"><i class="fa fa-check"></i></span>'; } else { echo '<span class="text text-danger"><i class="fa fa-times"></i></span>'; } ?></td>
							<td>
								<?php if($row['external_gateway'] == "1") { ?>
								<a href="./?a=gateways&b=edit_external&id=<?php echo $row['id']; ?>" title="Edit"><i class="fa fa-pencil"></i></a> 
								<?php } else { ?>
								<a href="./?a=gateways&b=edit&id=<?php echo $row['id']; ?>" title="Edit"><i class="fa fa-pencil"></i></a> 
								<?php } ?>
								<a href="./?a=gateways&b=delete&id=<?php echo $row['id']; ?>" title="Delete"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						<?php
					}
				} else {
					echo '<tr><td colspan="9">Still no have gateways. <a href="./?a=gateways&b=add">Click here</a> to add.</td></tr>';
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<?php
}
?>