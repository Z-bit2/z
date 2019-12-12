@extends('layouts.main')

@section('title', 'FREXA  | FrexaWallet')

@section('content')
<script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>
<div id="body_container">
  <style>
    #asset_selector{
      display:block;
      margin:auto;
      margin-top:100px;
      width:100%
    }
    #assetviewer_input{
      font-size:1.75em;
      margin:auto;width:50%;
    }
    #asset_selector .autocomplete-items{
      background-color:var(--text-color);
      color:var(--background-dark);
      padding-left:15px;
    }
    #assetviewer_nav{
      text-shadow:var(--neon);
    }
    /* #asset_selector{display:block;clip-path:inset(0 0 0 0)}  */
    @media(max-width:768px){
      #assetviewer_input{
        width:80%;
      }
    }
  </style>
  <div class="content_container centered">
    <form autocomplete="off" id="asset_selector">
      <div class="autocomplete">
        <div>
          <div class="input input--haruki" id="assetviewer_input" >
            <input class="input__field input__field--haruki" type="text" id="asset_name" name="AssetName" onkeyup="change_asset();">
            <label class="input__label input__label--haruki2" for="asset_name">
              <span class="input__label-content input__label-content--haruki2">Search for Property Name</span>
            </label>
            <div id="asset_name-autocomplete-items" class="autocomplete-items" style="display: none;">

            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="modal" id="asset_info">
  <label class="modal__bg" for="modal-1"></label>
  <div class="modal__inner" id="modal__inner">
    <label class="modal__close" for="modal-1" onclick="close_asset_info();"></label>
    <div id="modal_content">
      <style>
      .asset_icon{
        float:left;
      }
      .asset_symbol{
        font-size:1.25em;
      }
      #asset_container{
        padding:25px 25px 50px 25px;
        min-width:600px;
      }

      @media (max-width:768px){
        #asset_container{
          min-width:475px;
          padding:15px 15px 25px 15px;
        }
      }

      @media (max-width:600px){
        #asset_container{
          min-width:400px;
        }
      }

      @media (max-width:500px){
        #asset_container{
        /* min-width:300px; */
        min-width: auto;
        }
        .asset_share{
          float:right;
          margin-top:35px;
          margin-right:15px;
          /* margin-left:20px; */
        }
      }

      @media (max-width:450){
        #asset_container{
        /* min-width:100px; */
        }
        }
        @supports (-webkit-overflow-scrolling:touch){
        .modal__inner{
          padding:0 !important;
        }
      }
      </style>

      <div id="asset_container">
        <div id="asset_header" class="centered" style="border-bottom:1px solid #aaa; padding-bottom:10px; height:65px;position: relative; width:100%;">

          <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);">
            <img id="avater" class="modal_asset_icon" src="" height="64" width="64" style="margin: auto;">
            <a>
              <div id="asset_symbol" class="asset_symbol" style="margin-bottom:5px;">
                ASA
              </div>
              <div id="asset_detail" style="font-weight:300;">
              Qty: 1 | Units: 0 | Reissuable
            </div>
            </a>

          </div>
        </div>
        <div style="margin:25px;">
          IPFS Data:
          <span class="opacity" style="color:#2196F3;font-weight:300;" id="ipfs_data">
            http://ravencoinipfs.com/ipfs/QmS7dEFEKKy61ggFYMa3cusH7UT5EnoxG5nYAFnGKfZtgF
          </span>
        </div>
        <div id="meta_data">
        </div>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  var assets = "", modal_flag = 2;
  document.getElementById("asset_name").addEventListener("keypress", forceKeyPressUppercase, false);

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

  $(document).ready(function(){
    $.ajax({
      headers:{
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type : 'POST',
      url : '/get_all_assets',
      data : {
        _token : "<?php echo csrf_token() ?>"
      },
      success:function(res, status){
        assets = res;
      }
    });

    window.onclick = function(){
      if($("#asset_info").css("display") != "none"){
        for(var i = 0; i < (event.path).length; i ++){
          if((event.path)[i] == $("#asset_info #modal__inner")[0]){
            if(modal_flag == 1){
              modal_flag = 0;
            }
          }
        }
        if(modal_flag == 1){
          $("#asset_info").css("display", "none");
          $("#asset_info").css("opacity", "0");
        }
        modal_flag = 1;
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
  });

  var change_asset = function(){
    target_string = $("#asset_name").val();
    var temp_str = "";
    var flag = 0;
    if(target_string.length >= 2){
      for(var i = 0; i < assets.length; i ++){
        if (assets[i].includes(target_string)) {
          temp_str += '<div class="autocomplete-item" style="position: relative;">'
          temp_str += assets[i];
          temp_str += '</div>';
          flag = 1;
        }
      }
      $("#asset_name-autocomplete-items").html(temp_str);
      if(flag == 1){
        $("#asset_name-autocomplete-items").css("display", "block");
      }

      $(".autocomplete-item").click(function(){
        $.ajax({
          headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type : 'POST',
          url : '/get_asset_details',
          data : {
            _token : "<?php echo csrf_token() ?>",
            asset_name : $(this).html()
          },
          success:function(res, status){
            $("#asset_symbol").html(res[0]["name"]);
            temp = '';
            temp += "Qty: " + res[0]["amount"] + " | Units: " + res[0]["units"] + " | ";
            temp += res[0]["reissuable"]?"Reissuable":"Not Reissuable";
            $("#asset_detail").html(temp);
            if(res[0]["has_ipfs"]){
              $("#ipfs_data").html(res[0]["ipfs_hash"]);
            }
            else{
              $("#ipfs_data").html("This propoerty has no IPFS Data");
            }

            if(res[1] == "NO"){
              var temp = "";
              temp += '<div style="margin:15px; text-align:center;">No Meta Data</div>';
              $("#meta_data").html(temp);
              $("#avater").css("display", "none");
            }
            else{
              var temp = "";
              console.log(res[1]["full_asset_name"]);
              if(res[1]["avatar_url"] == "" && res[1]["avatar_url"] == null){
                $("#avater").css("display", "none");
              }
              else{
                $("#avater").css("display", "block");
                $("#avater").attr("src", "/upload_img/" + res[1]["avatar_url"]);
              }
              if(res[1]["full_asset_name"] != "" && res[1]["full_asset_name"] != null){
                temp += '<div style="margin:15px;">Full Asset Name:<span class="opacity" style="color:#2196F3;font-weight:300;">' + res[1]["full_asset_name"] + '</span></div>';
              }
              if(res[1]["description"] != "" && res[1]["description"] != null){
                temp += '<div style="margin:15px;">Description:<span class="opacity" style="color:#2196F3;font-weight:300;">' + res[1]["description"] + '</span></div>';
              }
              if(res[1]["issuer"] != "" && res[1]["issuer"] != null){
                temp += '<div style="margin:15px;">Issuer:<span class="opacity" style="color:#2196F3;font-weight:300;">' + res[1]["issuer"] + '</span></div>';
              }
              if(res[1]["website_url"] != "" && res[1]["website_url"] != null){
                temp += '<div style="margin:15px;">Website Url:<span class="opacity" style="color:#2196F3;font-weight:300;">' + res[1]["website_url"] + '</span></div>';
              }
              if(res[1]["image_url"] != "" && res[1]["image_url"] != null){
                temp += '<div style="margin:15px;">Image Url:<span class="opacity" style="color:#2196F3;font-weight:300;">' + res[1]["image_url"] + '</span></div>';
              }
              if(res[1]["contact_address"] != "" && res[1]["contact_address"] != null){
                temp += '<div style="margin:15px;">Contact Address:<span class="opacity" style="color:#2196F3;font-weight:300;">' + res[1]["contact_address"] + '</span></div>';
              }
              if(res[1]["contact_email"] != "" && res[1]["contact_email"] != null){
                temp += '<div style="margin:15px;">Contact Email:<span class="opacity" style="color:#2196F3;font-weight:300;">' + res[1]["contact_email"] + '</span></div>';
              }
              if(res[1]["contact_name"] != "" && res[1]["contact_name"] != null){
                temp += '<div style="margin:15px;">Contact Name:<span class="opacity" style="color:#2196F3;font-weight:300;">' + res[1]["contact_name"] + '</span></div>';
              }
              if(res[1]["contact_phone"] != "" && res[1]["contact_phone"] != null){
                temp += '<div style="margin:15px;">Contact Phone:<span class="opacity" style="color:#2196F3;font-weight:300;">' + res[1]["contact_phone"] + '</span></div>';
              }
              if(res[1]["contact_url"] != "" && res[1]["contact_url"] != null){
                temp += '<div style="margin:15px;">Contact Url:<span class="opacity" style="color:#2196F3;font-weight:300;">' + res[1]["contact_url"] + '</span></div>';
              }
              if(res[1]["restricted"] != "" && res[1]["restricted"] != null){
                temp += '<div style="margin:15px;">Restricted:<span class="opacity" style="color:#2196F3;font-weight:300;">' + res[1]["restricted"] + '</span></div>';
              }
              if(res[1]["sale_price"] != "" && res[1]["sale_price"] != null){
                temp += '<div style="margin:15px;">Sale Price:<span class="opacity" style="color:#2196F3;font-weight:300;">' + res[1]["sale_price"] + '</span></div>';
              }
              if(res[1]["type"] != "" && res[1]["type"] != null){
                temp += '<div style="margin:15px;">Type:<span class="opacity" style="color:#2196F3;font-weight:300;">' + res[1]["type"] + '</span></div>';
              }

              switch(res[1]["contract_type"]){
                case 0:
                break;
                case 1:
                  temp += '<div style="margin:15px;">Contract Form:<span class="opacity" style="color:#2196F3;font-weight:300;">Created One</span></div>';
                break;
                case 2:
                  temp += '<div style="margin:15px;">Contract Form:<span class="opacity" style="color:#2196F3;font-weight:300;">Uploaded File(IPFS)</span></div>';
                break;
              }
              $("#meta_data").html(temp);
            }

            $("#asset_info").css("display", "block");
            $("#asset_info").css("opacity", "1");
            modal_flag = 2;
          }
        });
      });
    }
    else{
      $("#asset_name-autocomplete-items").css("display", "none");
    }
  }

  var close_asset_info = function(){
    $("#asset_info").css("display", "none");
    $("#asset_info").css("opacity", "0");
  }
</script>
@endsection