@extends('layouts.main')

@section('title', 'FREXA | Upload Property')

@section('content')

<script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>
<style type="text/css">
	.tox-notifications-container{
		display: none;
	}
</style>
<div id="body_container">
	<div style="color:#fff;">
	</div>
	<link rel="stylesheet" href="{{ url('css/assetbuilder.min.css') }}">
	<link rel="stylesheet" href="{{ url('css/quill.snow.css') }}">
	<div class="content_container" style="max-width:1600px; margin:auto;">
	  <form id="asset_form" autocomplete=off data-cmd="issue">
	     <h3 id="form_header" class="form_heading " >Blockchain Data (required):</h3>
	     <section style="font-size:1.5em;position:relative;">
	        <div class="input input--haruki" id="nameDiv" style="margin-left: 10%;">
				<input class="input__field input__field--haruki" type="text" id="asset_name" name="asset" pattern="^[A-Z0-9][A-Z0-9._]{2,29}" title="Symbol must follow RVN naming convention: (1) use only CAPS, numbers or the special characters . _ (2) symbol must be a minimum of three and maximum of thirty characters (3) do not start or end with a special character (4) do not repeat special characters (5) use this form only for main assets - sub-assets and unique assets will come later." value="" required>
				<label class="input__label input__label--haruki2" for="asset_name">
					<span class="input__label-content input__label-content--haruki2">
						Asset Symbol
					</span>
				</label>
				<div id="name_indicator">Symbol Not Available</div>
				<div id="available_indicator">Symbol Available</div>
	       	</div>
	              <br style="font-size:1.75em;">

	       	<div class="input input--haruki" id="input_qty">
				<input class="input__field input__field--haruki"  value="1" type="number" min="1" max="21000000" name="qty" step="1" id="asset_qty"  required>
				<label class="input__label input__label--haruki2" for="asset_qty">
					<span class="input__label-content input__label-content--haruki2">Qty</span>
				</label>
	       	</div>
			<div class="input input--haruki" id="input_subunits" >
				<input class="input__field input__field--haruki" type="number" value="0" id="units" min="0" max="8" step="1" name="units" required>
				<label class="input__label input__label--haruki2" for="">
					<span class="input__label-content input__label-content--haruki2"><nobr>Sub-Units</nobr></span>
				</label>
			</div>
			<style type="text/css">
				#input_qty .input__label--haruki2 .input__label-content--haruki2 {
				    -webkit-transform: translate3d(0,-2.2em,0);
				    transform: translate3d(0,-2.2em,0);
				}

				#input_subunits .input__label--haruki2 .input__label-content--haruki2 {
				    -webkit-transform: translate3d(0,-2.2em,0);
				    transform: translate3d(0,-2.2em,0);
				}
	       	</style>
			<div class="cntr" id="input_reissuable">
				<label class="lbl" for="cbx">Reissuable</label>
				<input class="hidden-xs-up" name="reissuable" id="cbx" type="checkbox" checked /><label class="cbx" for="cbx"></label>
			</div>

	    </section>
		<h3 class="form_heading" id="metadata_heading">
			<span>Metadata (optional):  </span>
		</h3>
	      <input type="radio" name='disp_option' id="disp_spec" class="upload_check" checked><label for="disp_spec">Spec</label> | <input type="radio" name='disp_option' id="disp_nonspec" class="upload_check"><label for="disp_nonspec">Nonstandard</label>

	      <div id="std_spec">
	        <section style="font-size:1.35em;">
	          <div id="input_icon">
	            <div id="icon_uploader">
	            <label for="files-upload" id="upload_label">
	              <div id="drop-area" class="centered btn-6" style="cursor: pointer; font-size: 0.75em;padding-top:5px; padding-bottom:10px;">
	                <span class="filler" id="upload_filler"></span>
	                <span class="btn_label">
	                  <span class="drop-over">
	                    <div class="mobile_alt" id="icon_select"><span class="mobile_hide2">Select </span>Icon File</div>
	                    <span class="mobile_hide">Drop icon image here
	                      <div style="padding:5px; z-index:3;position:relative;">-OR-</div>
	                    </span>
	                    <div class="mobile_hide" >Select <span class="mobile_hide">File</span></div></span>
	                  </span>
	              </div>
	            </label>

	            <div id="img_tag" class="image_thumbnail" style="display: none;">
		            <img id="upload_img" src="" style=" width: 100%; height: 100%;" />
		            <div class="thumbnail_delete" title="Delete this image" style="opacity: 1;" onclick="delete_image();">X</div>
	          	</div>
	          </div>
	              <input id="files-upload" type="file" style='display:none;' name="image" onchange="readURL(this);" accept="image/x-png,image/gif,image/jpeg">
	              <input type="hidden" name="icon" id="icon_data">
	          </div>
	          <div id="input_namedesc">
	            <div class="input input--haruki" id="fullname_container">
	            <input class="input__field input__field--haruki" type="text" id="name" name="name">
	            <label class="input__label input__label--haruki2" for="name">
	              <span class="input__label-content input__label-content--haruki2">Full Asset Name</span>
	            </label>
	          </div>
	            <br style="font-size:1.65em;">
	            <div class="input input--haruki" id="description_container" style="margin-top: 1.8em;">
	              <input class="input__field input__field--haruki" type="text" id="description" name="description">
	              <label class="input__label input__label--haruki2" for="description">
	                <span class="input__label-content input__label-content--haruki2">Description</span>
	              </label>
	            </div>
	          </div>
	    </section>
	    <section id="metadata_2">
	      <div class="input input--haruki" style="margin-left: 10%; width:80%;">
	      <input class="input__field input__field--haruki" type="text" id="issuer" name="issuer">
	      <label class="input__label input__label--haruki2" for="issuer">
	        <span class="input__label-content input__label-content--haruki2">Issuer</span>
	      </label>
	    </div>
	    <br class="horiz-gutter">
	    <div>
			<div class="input input--haruki left_field">
				<input class="input__field input__field--haruki" type="text" id="website_url" name="website_url">
				<label class="input__label input__label--haruki2" for="website_url">
					<span class="input__label-content input__label-content--haruki2">Website URL</span>
				</label>
			</div>
			<div class="input input--haruki right_field">
				<input class="input__field input__field--haruki" type="text" id="image_url" name="image_url">
				<label class="input__label input__label--haruki2" for="image_url">
					<span class="input__label-content input__label-content--haruki2">Image URL</span>
				</label>
			</div>
	    </div>
	    <div class="input input--haruki" style="margin-left: 10%; width:80%; margin-top:10px">
		    <input class="input__field input__field--haruki" type="text" id="contact_name" name="contact_name">
		    <label class="input__label input__label--haruki2" for="contact_name">
		    	<span class="input__label-content input__label-content--haruki2">Contact Name</span>
		    </label>
	  	</div>
		<br style="font-size:1.2em">
	    <div class="input input--haruki" style="margin-left: 10%; width:80%; ">
			<input class="input__field input__field--haruki" type="text" id="contact_address" name="contact_address">
			<label class="input__label input__label--haruki2" for="contact_address">
				<span class="input__label-content input__label-content--haruki2">
					Contact Address
				</span>
			</label>
	    </div>
	    <br style="font-size:1.5em">
		<div class="input input--haruki left_field">
			<input class="input__field input__field--haruki" type="text" id="contact_email" name="contact_email">
			<label class="input__label input__label--haruki2" for="contact_email">
		  	<span class="input__label-content input__label-content--haruki2">
		  		Contact Email
		  	</span>
			</label>
		</div>
		<div class="input input--haruki right_field">
			<input class="input__field input__field--haruki" type="text" id="contact_phone" name="contact_phone">
			<label class="input__label input__label--haruki2" for="contact_phone">
		  		<span class="input__label-content input__label-content--haruki2">
		  			Contact Phone
		  		</span>
			</label>
		</div>
	    <div style="margin-top:-15px;">
	        <div class="input input--haruki left_field">
	          <input class="input__field input__field--haruki" type="text" id="type" name="type">
	          <label class="input__label input__label--haruki2" for="type">
	            <span class="input__label-content input__label-content--haruki2">Type</span>
	          </label>
	        </div>
	        <div class="input input--haruki right_field">
	          <input class="input__field input__field--haruki" type="text" id="restricted" name="restricted">
	          <label class="input__label input__label--haruki2" for="restricted">
	            <span class="input__label-content input__label-content--haruki2">Restricted</span>
	          </label>
	        </div>
	      </div>
	    </section>
	    <div id="for_sale_placeholder"></div>
	      <section style="margin-left:10%; margin-top:10px; position:relative;">
	        <div class="input input--haruki" id="contract_url_container">
	        <input class="input__field input__field--haruki" type="text" id="contract_url" name="contract_url" disabled>
	        <label class="input__label input__label--haruki2" for="contract_url">
	          <span class="input__label-content input__label-content--haruki2">Contract URL</span>
	        </label>
	      </div>
	      <br style="font-size:1.75em;">
	        <div class="contract_type_container">
	          <span id="contract_type_title">Legal <br class="mobile_ui3">Document<br class="mobile_ui2"><span>(choose one):</span></span>
	          <div class='btn_container'>
	            <label class='radio_option' for="enter_url_btn">
					<input type="radio" name="contract_type" value="enter_url" id="enter_url_btn" class="contract_type" onclick="enter_contact_url();">
					<label for="enter_url_btn" class="btn-6 contract_type_lbl">
						<span class="btn_label">Enter Contract URL</span><span class="filler"></span>
					</label>
	            </label>
	            <!-- <div class='radio_option'>
	              <input type="radio" name="contract_type" value="use_sample" id="use_sample_btn" class="contract_type">
	              <label for="use_sample_btn" class="btn-6 contract_type_lbl"><span class="btn_label">Use Sample Form</span><span class="filler"></span></label>
	            </div> -->

	            <div class='radio_option'>
					<input type="radio" name="contract_type" value="generate_contract" id="create_new_btn" class="contract_type" onclick="create_new_contract();">
					<label for="create_new_btn" class="btn-6 contract_type_lbl">
						<span class="btn_label">Create New Contract</span>
						<span class="filler"></span>
					</label>
	            </div>
	            <br class='mobile_ui'>
	            <div class='radio_option'>
					<input type="radio" name="contract_type" value="upload_pdf" id="upload_file_btn" class="contract_type" onclick="$('#upload_for_contract').click();">
					<label for="upload_file_btn" class="btn-6 contract_type_lbl">
						<span class="btn_label">Upload Document</span>
						<span class="filler"></span>
					</label>
					<input type="file" id="upload_for_contract" onclick="upload_for_contract1(this);" style="display: none;" />
	            </div>
	          </div>
	        </div>
	        <div id="for_sale_container">
	          <div class="cntr" id="forsale_cbx">
	            <input class="hidden-xs-up" id="cbx2" type="checkbox" name="forsale" /><label class="cbx" for="cbx2" style="border-color:#ccc;"></label>
	            <label id="for_sale_lbl" class="lbl" for="cbx2">For Sale</label>
	          </div>
	          <div id="sale_disp" class="input input--haruki">
	            <input class="input__field input__field--haruki" type="text" id="forsale_price" name="forsale_price" disabled>
	            <label class="input__label input__label--haruki2" for="forsale_price">
	              <span class="input__label-content input__label-content--haruki2">Sale Price</span>
	            </label>
	          </div>
	        </div>
	      </section>
	    </div>
	    <div id="nonstd_spec" style="position:relative;">
	        <h3 style="margin-bottom:35px;">Upload Metadata</h3>
	        <div class="input input--haruki" id="nonstd_hash_container" style="padding-bottom:75px;margin:0">
	          <input class="input__field input__field--haruki" type="text" id="nonstd_hash" name="nonstd_hash" style="font-size:2em; padding-bottom:0">
	          <label class="input__label input__label--haruki2" for="nonstd_hash" style="font-size:1em;">
	            <span class="input__label-content input__label-content--haruki2">IPFS Hash</span>
	          </label>
	        </div>
	        <input name="meta_file_upload" id="meta_file_upload" type="file" value="" style="visibility:hidden;position:absolute;left:5000%;" onchange="get_ipfs_change(this);">

	        <label for="meta_file_upload" id="meta_upload_save">Select File</label>
	      </div>
	    <section style="padding-top:55px; color:#DDD; font-size: 1.25em;">
	        <div id="input_submit" style="position:relative;">
	          <input type="submit" id="hidden_submit" style="position:absolute; visibility:hidden;">
	          <a id="submit_btn" class="btn-6" onclick="open_try();">
	          	<span class="btn_label">Preview Property</span>
	          	<span class="filler"></span>
	          </a>
	        </div>
	      </section>
	  </form>
	</div>
</div>

<div class="modal" id="issue_dialog">
    <label class="modal__bg" for="modal-1"></label>
    <div class="modal__inner" id="modal__inner">
        <label class="modal__close" for="modal-1" onclick="close_modal();"></label>
        <div id="modal_content">
            <div id="issue_container">
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.tiny.cloud/1/dy484tcnsrw0w6wu8up5zqqqtldhgw2uz5d0xm5ctwikx0z4/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script type="text/javascript">
	tinymce.init({
		selector: 'textarea#basic-example',
		height: 500,
		menubar: false,
		branding : false,
		plugins: [
			'advlist autolink lists link image charmap print preview anchor',
			'searchreplace visualblocks code fullscreen',
			'insertdatetime media table paste code help wordcount'
		],
		toolbar: 'undo redo | formatselect | ' +
			' bold italic backcolor | alignleft aligncenter ' +
			' alignright alignjustify | bullist numlist outdent indent |' +
			' removeformat | help',
		content_css: [
			'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
			'//www.tiny.cloud/css/codepen.min.css'
		],
		init_instance_callback : function(editor) {
		}
	});
</script>
<style type="text/css">
	.btn-alt {
	    font-size: 1.15em;
	    display: inline-block;
	    border-color: #2196F3;
	    -webkit-appearance: none;
	}
</style>
<div class="modal" id="contract_dialog">
    <label class="modal__bg" for="modal-1"></label>
    <div class="modal__inner" id="modal__inner">
        <label class="modal__close" for="modal-1" onclick='$("#contract_dialog").css("display", "none");
		$("#contract_dialog").css("opacity", 0);'></label>
        <div id="modal_content" style="margin-top: 40px;">
            <textarea id="basic-example">

			</textarea>
			<div class="editor_tools" style="text-align:center; margin-top: 10px;">
				<form id="contract_data">
					<input type="button" class="btn-6 btn-alt modal-btn" id="genContract_btn" value="Attach Document" onclick="saveDocument();">
					<input type="button" class="btn-6 btn-alt modal-btn" value="Clear Text" onclick="tinyMCE.get('basic-example').setContent('');">
				</form>
			</div>
        </div>
    </div>
</div>

<style>
	.custom-alert{
		border: solid 0.5px red;
	}
</style>
<script type="text/javascript">
	var assets = [];
	var issue_flag = 2;
	var ajax_data = {};
	ajax_data['contract_type'] = 0;
	var image_file;

	var open_try = function(){
		flag = 0;
		asset_symbol = $('#asset_name').val();
		asset_qty = $('#asset_qty').val();
		asset_sub_units = $('#units').val();

		if(asset_symbol == ''){
			$("#asset_name").addClass('custom-alert');
			flag = 1;
		}

		if(asset_qty == 0){
			$('#asset_qty').addClass('custom-alert');
			flag = 1;
		}

		if(asset_sub_units == 0){
			$('#units').addClass('custom-alert');
			flag = 1;
		}

		if(flag == 1){
			return;
		}

		img_url = $('#upload_img').attr('src');
		full_asset_name = $('#name').val();
		description = $('#description').val();
		issuer = $('#issuer').val();
		website_url = $('#website_url').val();
		image_url = $('#image_url').val();
		contact_name = $('#contact_name').val();
		contact_address = $('#contact_address').val();
		contact_email = $('#contact_email').val();
		contact_phone = $('#contact_phone').val();
		type = $('#type').val();
		restricted = $('#restricted').val();
		reissuable = $('#cbx').prop('checked')?1:0;
		ipfs = $('#nonstd_hash').val();
		sale_price = $("#cbx2").prop("checked")?$("#forsale_price").val():"";

		var temp = '';
		temp += '<div id="testnet_indicator">--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--</div>';
		temp += '<div id="dialog_container">';
		temp += '<div class="centered" id="issue_header">Review and Issue your Asset ' + asset_symbol + '</div>';
		temp += '<div class="centered" style="margin-bottom:10px;">(Will use 525 RVN)</div>';
		temp += '<div id="funding_msg" class="centered"></div>';
		temp += '<div id="issue_container" style="margin-bottom:25px;">';
		temp += '<div id="asset_header" class="centered">';
		temp += '<h2 class="asset_issue_symbol">';
		if(img_url != ''){
			temp += '<img src="' + img_url + '" style="margin-right:15px; width: 32px; height: 32px;">';
		}

		temp += full_asset_name;
		temp += '</h2>';
		temp += '<div>Qty: ' + asset_qty + ' | Units: ' + asset_sub_units  + ' | ';
		temp += $('#cbx').prop('checked')?'Reissuable':'Not Reissuable';
		temp += '</div>';
		if(ipfs != ''){
			temp += '<div>IPFS:' + ipfs + '</div>';
		}
		temp += '</div>';
		temp += '<hr>';
		temp += '<div id="asset_metadata" style="text-align:left; padding:25px; word-break:break-all;">';

		if(issuer != ""){
			temp += '<div class="field_div">';
			temp += '<div style="display:inline-block;"><strong>Issuer:</strong>&nbsp;</div>';
			temp += '<div style="display:inline-block;font-weight:300;">' + issuer + '</div>';
			temp += '</div>';
		}

		if(description != ""){
			temp += '<div class="field_div">';
			temp += '<div style="display:inline-block;"><strong>Description:</strong>&nbsp;</div>';
			temp += '<div style="display:inline-block;font-weight:300;">' + description + '</div>';
			temp += '</div>';
		}

		if(website_url != ""){
			temp += '<div class="field_div">';
			temp += '<div style="display:inline-block;"><strong>Website URL:</strong>&nbsp;</div>';
			temp += '<div style="display:inline-block;font-weight:300;">' + website_url + '</div>';
			temp += '</div>';
		}

		if(image_url != ""){
			temp += '<div class="field_div">';
			temp += '<div style="display:inline-block;"><strong>Image URL:</strong>&nbsp;</div>';
			temp += '<div style="display:inline-block;font-weight:300;">' + image_url + '</div>';
			temp += '</div>';
		}

		if(contact_name != ""){
			temp += '<div class="field_div">';
			temp += '<div style="display:inline-block;"><strong>Contact Name:</strong>&nbsp;</div>';
			temp += '<div style="display:inline-block;font-weight:300;">' + contact_name + '</div>';
			temp += '</div>';
		}

		if(contact_address != ""){
			temp += '<div class="field_div">';
			temp += '<div style="display:inline-block;"><strong>Contact Address:</strong>&nbsp;</div>';
			temp += '<div style="display:inline-block;font-weight:300;">' + contact_address + '</div>';
			temp += '</div>';
		}

		if(contact_email != ""){
			temp += '<div class="field_div">';
			temp += '<div style="display:inline-block;"><strong>Contact Email:</strong>&nbsp;</div>';
			temp += '<div style="display:inline-block;font-weight:300;">' + contact_email + '</div>';
			temp += '</div>';
		}

		if(contact_phone != ""){
			temp += '<div class="field_div">';
			temp += '<div style="display:inline-block;"><strong>Contact Phone:</strong>&nbsp;</div>';
			temp += '<div style="display:inline-block;font-weight:300;">' + contact_phone + '</div>';
			temp += '</div>';
		}

		if(type != ""){
			temp += '<div class="field_div">';
			temp += '<div style="display:inline-block;"><strong>Type:</strong>&nbsp;</div>';
			temp += '<div style="display:inline-block;font-weight:300;">' + type + '</div>';
			temp += '</div>';
		}

		if(restricted != ""){
			temp += '<div class="field_div">';
			temp += '<div style="display:inline-block;"><strong>Restricted:</strong>&nbsp;</div>';
			temp += '<div style="display:inline-block;font-weight:300;">' + restricted + '</div>';
			temp += '</div>';
		}

		if(sale_price != ""){
			temp += '<div class="field_div">';
			temp += '<div style="display:inline-block;"><strong>Sale Price:</strong>&nbsp;</div>';
			temp += '<div style="display:inline-block;font-weight:300;">' + sale_price + '</div>';
			temp += '</div>';
		}

		temp += '</div>';
		temp += '</div>';
		temp += '<div id="review_btn_container">';
		temp += '<input type="button" value="Try Create" class="btn-6 issue_btn" onclick="try_create();">';
		temp += '</div>';
		temp += '</div>';

		$('#issue_container').html(temp);

		ajax_data['asset_symbol'] = asset_symbol;
		ajax_data['asset_qty'] = asset_qty;
		ajax_data['asset_sub_units'] = asset_sub_units;
		ajax_data['full_asset_name'] = full_asset_name;
		ajax_data['description'] = description;
		ajax_data['issuer'] = issuer;
		ajax_data['website_url'] = website_url;
		ajax_data['image_url'] = image_url;
		ajax_data['contact_name'] = contact_name;
		ajax_data['contact_address'] = contact_address;
		ajax_data['contact_email'] = contact_email;
		ajax_data['contact_phone'] = contact_phone;
		ajax_data['type'] = type;
		ajax_data['restricted'] = restricted;
		ajax_data['reissuable'] = reissuable;
		ajax_data['sale_price'] = sale_price;
		ajax_data['ipfs'] = ipfs;

		$('#issue_dialog').css('display', 'block');
		$('#issue_dialog').css('opacity', '1');
		issue_flag = 2;
	}

	$(document).ready(function(){

		$("#cbx2").on("change", function(e){
			if($(this).prop("checked")){
				$("#forsale_price").prop("disabled", false);
				$("#sale_disp").css("opacity", 1);
				return;
			}
			$("#forsale_price").prop("disabled", true);
			$("#sale_disp").css("opacity", 0.5);
			return;
		});

		window.onclick = function(event) {
			if($("#issue_dialog").css("display") != "none"){
				for(var i = 0; i < (event.path).length; i ++){
					if((event.path)[i] == $("#issue_dialog #modal__inner")[0]){
						if(issue_flag == 1){
							issue_flag = 0;
						}
					}
				}
				if(issue_flag == 1){
					$("#issue_dialog").css("display", "none");
					$("#issue_dialog").css("opacity", "0");
				}
				issue_flag = 1;
			}
		}

		$(".input__field").on("keyup", function(){
			id = $(this).parent().attr("id");
			if($(this).val() != ""){
				$(this).parent().children(".input__label--haruki2").children('.input__label-content--haruki2').css("-webkit-transform", "translate3d(0,-2.2em,0)");
				$(this).parent().children(".input__label--haruki2").children('.input__label-content--haruki2').css("transform", "translate3d(0,-2.2em,0)");
			}
			else{
				$(this).parent().children(".input__label--haruki2").children('.input__label-content--haruki2').css("-webkit-transform", "");
				$(this).parent().children(".input__label--haruki2").children('.input__label-content--haruki2').css("transform", "");
				$(this).parent().children(".input__label--haruki2").children('.input__label-content--haruki2').css("-webkit-transition", "-webkit-transform .3s");
				$(this).parent().children(".input__label--haruki2").children('.input__label-content--haruki2').css("transition", "-webkit-transform .3s");
			}
		});

		$(".input__field").on("focus", function(){
			$(this).removeClass('custom-alert');
		});

		$("#contract_url").on("keyup", function(){
			ajax_data['contract_type'] = 1;
		});
	});

	var readURL = function(input){
		if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	var images = $.grep(input.files, function(file) {
			        return file.type.indexOf("image/") === 0;
			    });
			    if(images.length == 0){
			    	return;
			    }

	            $('#upload_img').attr('src', e.target.result);
		        $("#upload_label").css("display", "none");
		        $("#img_tag").css("display", "block");
	        };
	        reader.readAsDataURL(input.files[0]);
	        image_file = input.files[0];
	    }
	}

	var get_ipfs_change = function(input){
		if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	            $.ajax({
			      headers:{
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			      },
			      type : 'POST',
			      url : '/get_ipfs',
			      data : {
			        _token : "<?php echo csrf_token() ?>",
			        file : e.target.result
			      },
			      success:function(res, status){
			      	if(status == "success"){
			      		$("#nonstd_hash").val(res);
			      	}
			      }
			    });
	        };
	        reader.readAsDataURL(input.files[0]);
	    }
	}

	var delete_image = function(){
		$('#upload_img').attr('src', '');
		$("#upload_label").css("display", "block");
	    $("#img_tag").css("display", "none");
	}

	var close_modal = function(){
		$("#issue_dialog").css("display", "none");
		$("#issue_dialog").css("opacity", "0");
	}

	var try_create = function(){
		var formData = new FormData();
		formData.append('image', image_file);
		if (ajax_data['contract_type'] == 0 ) {
			ajax_data['contract_content'] = '';
		}
		if (ajax_data['contract_type'] == 1 && $("#contract_url").val() == '') {
			ajax_data['contract_type'] = 0;
			ajax_data['contract_content'] = '';
		}
		if (ajax_data['contract_type'] == 1 && $("#contract_url").val() != '') {
			ajax_data['contract_type'] = 1;
			ajax_data['contract_content'] = $("#contract_url").val();
		}
		$.ajax({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type : 'POST',
			url : "{{ route('image_upload.action') }}",
			data : formData,
			contentType: false,
			cache: false,
			processData: false,
			success:function(res, status){
				if(res != "failed"){
					ajax_data['avatar_url'] = res;
					$.ajax({
						headers:{
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						type : 'POST',
						url : '/sub_asset_creation',
						data : {
							_token : "<?php  ?>",
							data : ajax_data
						},
						success:function(res, status){
							if(res == "success"){
								window.location.href = '/frexawallet';
							}
							else{
								alert("Oops! Something went Wrong!");
							}
						}
					});
				}
				else{
					alert("Image Upload Failed");
				}
			}
	    });
	}

	document.getElementById("asset_name").addEventListener("keypress", forceKeyPressUppercase, false);
	document.getElementById("asset_name").addEventListener("keyup", detect, false);
	function detect(e){
	}
	function forceKeyPressUppercase(e)
	{
		var charInput = e.keyCode;
		if((charInput >= 97) && (charInput <= 122)) { // lowercase
			if(!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
				var newChar = charInput - 32;
				var start = e.target.selectionStart;
				var end = e.target.selectionEnd;
				e.target.value = e.target.value.substring(0, start) + String.fromCharCode(newChar) + e.target.value.substring(end);
				e.target.setSelectionRange(start+1, start+1);
				e.preventDefault();
			}
		}
	}

	var enter_contact_url = function(){
		$("#contract_url").attr("disabled", false);
		$("#contract_url_container").css("opacity", 1);

		ajax_data['contract_content'] = "";
		ajax_data['contract_type'] = 1;
	}

	var create_new_contract = function(){
		tinyMCE.get('basic-example').setContent('');

		$("#contract_dialog").css("display", "block");
		$("#contract_dialog").css("opacity", 1);
	}

	function upload_for_contract1(input){
		if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	            $.ajax({
			      headers:{
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			      },
			      type : 'POST',
			      url : '/get_ipfs',
			      data : {
			        _token : "<?php echo csrf_token() ?>",
			        file : e.target.result
			      },
			      success:function(res, status){
			      	if(status == "success"){
			      		$("#contract_url").val(res);
			      		$("#contract_url").parent().children(".input__label--haruki2").children('.input__label-content--haruki2').css("-webkit-transform", "translate3d(0,-2.2em,0)");
						$("#contract_url").parent().children(".input__label--haruki2").children('.input__label-content--haruki2').css("transform", "translate3d(0,-2.2em,0)");
						$("#contract_url").attr("disabled", false);
						$("#contract_url_container").css("opacity", 1);

						ajax_data['contract_content'] = res;
						ajax_data['contract_type'] = 3;
			      	}
			      }
			    });
	        };
	        reader.readAsDataURL(input.files[0]);
	    }
	}

	var saveDocument = function(){
		content = tinyMCE.get('basic-example').getContent();
		if(content == ""){
			alert("Empty!!!");
		}

		else{
			ajax_data['contract_content'] = content;
			ajax_data['contract_type'] = 2;
			$("#contract_dialog").css("display", "none");
			$("#contract_dialog").css("opacity", 0);
		}
	}
</script>
@endsection