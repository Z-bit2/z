@extends('layouts.main')

@section('title', 'Mango Farm  | MangoWallet')

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
            <a>
              <div id="asset_symbol" class="asset_symbol" style="margin-bottom:5px;">
                ASA
              </div>
            </a>
            <div id="asset_detail" style="font-weight:300;">
              Qty: 1 | Units: 0 | Reissuable
            </div>
          </div>
        </div>
        <div style="margin:25px;">
          IPFS Data:
          <span class="opacity" style="color:#2196F3;font-weight:300;" id="ipfs_data">
            http://ravencoinipfs.com/ipfs/QmS7dEFEKKy61ggFYMa3cusH7UT5EnoxG5nYAFnGKfZtgF
          </span>
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
            console.log(res);
            $("#asset_symbol").html(res["name"]);
            temp = '';
            temp += "Qty: " + res["amount"] + " | Units: " + res["units"] + " | ";
            temp += res["reissuable"]?"Reissuable":"Not Reissuable";
            $("#asset_detail").html(temp);
            if(res["has_ipfs"]){
              $("#ipfs_data").html(res["ipfs_hash"]);
            }
            else{
              $("#ipfs_data").html("No IPFS Data");
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

