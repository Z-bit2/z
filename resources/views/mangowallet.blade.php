@extends('layouts.main')

@section('title', 'Mango Farm  | MangoWallet')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    .dropbtn {
    background-color: transparent;
    color: black;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
    }

    .dropbtn:hover, .dropbtn:focus {
    }

    .dropdown {
    position: relative;
    display: inline-block;
    }

    .dropdown-content {
    display: none;
    position: absolute;
    background-color: #f1f1f1;
    min-width: 100px;
    overflow: auto;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    }

    .dropdown-content a {
        font-size: small;
        color: black;
        padding: 12px 10px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {background-color: #ddd;}

    .show {display: block;}
    #wallet_disp {
        min-height: 700px;
        min-width: 900px;
    }

    #mango_background {
        background-image: url("/images/mango_big.png");
        height: 300px;
        width: 500px;
        background-repeat: no-repeat;
        opacity: 0.3;
        position: absolute;
        left: 50%;
        top: 60%;
        transform: translate(-50%, -50%);
        z-index: -1;
    }

    #user_info_entry {
        display: none;
        margin-top: 25px;
        position: relative;
        z-index: 50;
    }

    #affirm_wrote:checked~div#user_info_entry {
        display: block;
    }

    #affirm_wrote:checked~div#mango_background {
        opacity: 0.1;
    }

    #pwd_msg,
    #pin_msg,
    #already_msg,
    #error_msg,
    #error12_msg {
        color: red;
        display: none;
    }

    .warn_in{
        border: 1px solid red;
    }

    @media (max-width:1000px) {
        #wallet_disp {
            min-width: 700px;
        }
    }

    @media (max-width:800px) {
        #wallet_disp {
            min-width: 500px;
        }
    }

    @media (max-width:600px) {
        #wallet_disp {
            min-width: 400px;
        }
    }

    @media(max-width:500px) {
        #wallet_disp {
            min-width: 350px;
        }

        input.user_info {
            width: 300px;
        }
    }
</style>
<script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>
<div id="body_container">
 	<link rel="stylesheet" href="{{ url('/css/mangowallet.min.css') }}">
	<div class="content_container" style="padding-top:20px;">
		@if(!Session::has('seed'))
		<div id="toolbar" style="width:80%; margin:auto;">
			<h1 class="title_treit">FREXA</h1>
			<h3 class="title_tech">Fund Real Estate Exchange of America</h3>
			<input type="button" class="btn-6 toolbar_btn btn-alt" value="Login" onclick="show_login_modal()"><br>
			<input type="button" class="btn-6 toolbar_btn btn-alt" value="Create New Wallet" onclick="show_modal()"><br>
			<input type="button" class="btn-6 toolbar_btn btn-alt" value="Use Existing Seed" onclick="exiting_seed();"><br>
			<!-- <input type="butt
				on" class="btn-6 toolbar_btn btn-alt" value="Trezor Mode" onclick=""><br> -->
		</div>

		<div id="trez_login">
			<img src="{{ url('/images/trezor-logo.png')}}">
			<h1 class="centered">Signing In...</h1>
		</div>

		@else
		<div id="wallet_view" style="display: block;">
		    <div id="wallet_header" style="height:40px; font-size:1.5em; position:relative; padding:15px 15px 0px 15px;">
		        <div style="float:left;">
		            <label for="menu_disp" title="Menu" id="menu_btn" class="menu_lbl"></label>
		            <input type="checkbox" id="menu_disp" class="menu_toggle hamburger" onclick="">
		            <div id="user_menu" class="user_menu">
		            	<!-- Your wallet is {{ Session::get('seed') }} -->
		                <a id="getAddress" onclick="get_newAddress();">Get New Address</a>
		                <a id="sendRvn" onclick="send_raven();">Send Ravencoin</a>
		                <a id="buildAsset" class="asset_action" href="/assetbuilder">Create New Asset</a>
		                <a id="sendAsset" class="asset_action" onclick="show_send_asset_modal();">Send Asset</a>
		                <!-- <a id="burnAsset" class="asset_action" onclick="">Burn Asset</a> -->
		                <!-- <a id="pairGoogle" onclick="">Activate 2FA</a> -->
		                <a id="logout" onclick="logout()">Sign Out</a>
		            </div>
		            <a id="reload_btn" class="wallet_btn header_btn" title="Reload Wallet" onclick="window.location.reload(true);"></a>
		            <input type="checkbox" id="wallet_alpha">
		            <label for="wallet_alpha" id="alpha_btn" class="header_btn" onclick=""></label>
		            <label for="show_search">
		            	<a id="search_btn" class="wallet_btn header_btn" title="Search Wallet" onclick="">
		            	</a>
		            </label>
		        </div>
		        <div id="trezor_indicator"></div>
		        <div id="header_rvn_bal" style="position:absolute; right:15px; top:10px;vertical-align:top;">
		            <div id="rvn_logo"
		                style="position:absolute; left:-45px; text-align:right; width:40px; top:60%; transform:translateY(-50%);">
		                <img src="{{ url('/images/ravenlogo.png') }}"></div>
		            <div style="">
		            	RVN
		            	<span class="mobile_hide">
		            		Balance
		            	</span>:
		            	<span id="rvn_bal">
		            	</span>
		            </div>
		        </div>
		    </div>
		    <hr>
		    <div id="asset_list_container">
		        <input type="radio" name="list_selector" id="rvn_list_selector" class="list_selector">
		        <label for="rvn_list_selector" class="list_selector_lbl">Ravencoin</label>
		        <input type="radio" name="list_selector" id="asset_list_selector" class="list_selector" checked="">
		        <label for="asset_list_selector" class="list_selector_lbl asset_lbl" onclick="on_assets();">Assets</label>
		        <input type="radio" name="list_selector" id="admin_list_selector" class="list_selector">
		        <label for="admin_list_selector" class="list_selector_lbl asset_lbl">Admin Tokens</label>
		        <div id="rvn_list">
		            <div class="asset_disp">
		                <div class="asset_click" data-asset="RVN"></div>
		                <div class="asset_icon"><img src="{{ url('/images/ravenlogo.png') }}"></div><span
		                    class="asset_name">RAVENCOIN</span>
		                <div class="asset_qty">
		                	<span style="font-weight:300;">Qty: </span>
		                	<span id="rvn_tab_balance"></span>
		                </div>
		            </div>
		        </div>
		        <div id="asset_list">
		            <input type="checkbox" id="show_search">
		            <div id="asset_search_container">
		            	<input type="text" class="asset_search" id="asset_search" placeholder="Search...">
		            </div>

		            <div id="myasset_list">

		            </div>

		        </div>
		        <div id="admin_list">

                </div>
		    </div>
		</div>

		<script type="text/javascript">
			$(document).ready(function(){
				$.ajax({
					headers:{
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type : 'POST',
					url : '/get_raven_amount',
					data : {
						_token : "<?php echo csrf_token() ?>"
					},
					success:function(res, status){
						$("#rvn_tab_balance").html(res["result"]);
						$("#rvn_bal").html(res["result"]);
					}
				});
			});
		</script>
		@endif

	</div>
</div>


<div class="modal" id="create_main_modal">
    <label class="modal__bg" for="modal-1"></label>
    <div class="modal__inner" id="modal__inner">
        <label class="modal__close" for="modal-1" id="close_main"></label>
        <div id="modal_content">
            <div id="wallet_disp" style="text-align:center;">
                <p style="font-weight:300; margin-top:45px;">
                	This is your randomly generated seed phrase. Please write these words down before proceeding. If you lose this phrase your wallet cannot be recovered.</p>
                <div id="seed_phrase" style="margin:25px;">
                	host across duck another relief hand table marble garden clog
                    deer auto
                </div>
                <input type="checkbox" id="affirm_wrote"><label for="affirm_wrote">
                	I confirm I have written the seed phrase down.</label>
                <div id="mango_background">

                </div>
                <div id="user_info_entry">
                    <p>Please enter your user info.</p>
                    <form id="user_info_form">
                        <input type="text" class="user_info basic_input" id="user_email" placeholder="Email Address" required="">
                        <input type="password" id="pwd" class="user_info basic_input" placeholder="Password" required="">
                        <input type="password" id="pwd2" class="user_info basic_input" placeholder="Confirm Password" required="">
                        <div style="margin-left:-75px;">
                            <div
                                style="display:inline-block;vertical-align: top; font-size:1.5em; font-weight:300; width:150px; text-align: right; margin-right:10px;">
                                Enter PIN: </div>
                            <div style="display:inline-block">
                                <div id="pin_container" style="text-align: center;">
                                    <input type="text" id="pin1" class="masked pin_input pin1 basic_input" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#pin2').focus();">
                                    <input type="text" id="pin2" class="masked pin_input basic_input" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#pin3').focus();">
                                    <input type="text" id="pin3" class="masked pin_input basic_input" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#pin4').focus();">
                                    <input type="text" id="pin4" data-pinid="pin" class="masked pin_input basic_input" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#conf1').focus();">
                                </div>
                            </div>
                        </div>
                        <div style="margin-left:-75px; margin-top:5px;">
                            <div style="display:inline-block;vertical-align: top; font-size:1.5em; font-weight:300; width:150px; text-align: right; margin-right:10px;">
                                Confirm PIN:
                            </div>
                            <div style="display:inline-block">
                                <div id="pin_container" style="text-align: center;">
                                    <input type="text" id="conf1" class="masked pin_input pin1 basic_input" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#conf2').focus();">
                                    <input type="text" id="conf2" class="masked pin_input basic_input" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#conf3').focus();">
                                    <input type="text" id="conf3" class="masked pin_input basic_input" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#conf4').focus();">
                                    <input type="text" id="conf4" data-pinid="conf" class="masked pin_input basic_input" inputmode="numeric" pattern="[0-9]*" maxlength="1">
                                </div>
                            </div>
                        </div>
                        <div id="create_wallet">
                        	<input type="button" id="reg_btn" class="user_info btn-6" style="width:250px; margin-top:20px;" value="Create Wallet">
                        	<div id="transaction_loading" style="text-align: center; display: none;">
                    			<img src="{{ url('/images/loading1.gif') }}" height="50">
                    			<br>
                    			<span id="transaction_msg">Syncing Wallet...</span>
                    		</div>
                        </div>
                        <div id="pwd_msg">Passwords must match!</div>
                        <div id="pin_msg">PIN Codes must match!</div>
                        <div id="already_msg">Wallet already exits!</div>
                    </form>
                    <p style="font-weight:300; width:80%; margin:auto;">
                    	When you create your wallet, your seed is double
                        encrypted using the password and PIN you set here and stored in our database. We NEVER see your
                        unencrypted seed or your password/PIN, nor do we store your password or PIN in any form.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="login_modal">
    <label class="modal__bg" for="modal-1"></label>
    <div class="modal__inner" id="modal__inner">
        <label class="modal__close" for="modal-1" id="login_close"></label>
        <div id="modal_content">
            <style>
                @media(max-width:500px) {
                    input.user_info_alt {
                        width: 300px;
                    }
                }
            </style>
            <div id="login_disp" style="text-align:center; padding-bottom:50px;">
                <h3>Please enter your login credentials.</h3>
                <div id="login_form">
                    <input type="text" id="login_email" class="user_info user_info_alt" name="email"
                        placeholder="Email Address" required="">
                    <input type="password" id="login_pwd" name="pwd" class="user_info user_info_alt"
                        placeholder="Password" required="">
                    <div id="ui_container" style="height:100px;">
                    	<div id="error_msg">Passwords must match!</div>
                    	<input type="submit" id="wallet_login" class="user_info btn-6" style="width:250px; margin-top:20px;" value="Sign In">
                    	<div id="transaction_loading" style="text-align: center; display: none;">
                    		<img src="{{ url('/images/loading1.gif') }}" height="50">
                    		<br>
                    		<span id="transaction_msg">Syncing Wallet...</span>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="seed">
    <label class="modal__bg" for="modal-1"></label>
    <div class="modal__inner" id="modal__inner">
        <label class="modal__close" for="modal-1" onclick="close_seed();"></label>
        <div id="modal_content">
            <style>
                @media(max-width:500px) {
                    input.user_info_alt {
                        width: 300px;
                    }
                }
            </style>
            <div id="login_disp" style="text-align:center; padding-bottom:50px;">
                <h3>Please enter your 12 words seed.</h3>
                <div id="login_form">
                    <input type="text" id="input_seed" class="user_info user_info_alt" name="email"
                        placeholder="Seed" required="">
                    <div id="ui_container" style="height:100px;">
                    	<div id="error12_msg">You have to enter 12 words!</div>
                    	<input type="submit" id="create_seed" class="user_info btn-6" style="width:250px; margin-top:20px;" value="Confirm">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="wallet_menus">
	<label class="modal__bg" for="modal-1"></label>
	<div class="modal__inner" id="modal__inner">
		<label class="modal__close" for="modal-1" onclick="close_wallet_menu();"></label>
		<div id="modal_content">
			<style>
				#copy_address{
					margin-left:15px;
					margin-bottom:-5px;
					cursor:pointer;
				}
				#copy_address:hover{
					opacity:0.8;
				}
				#copied_indicator{
					color: var(--mango-blue);
					font-style: italic;
					opacity:0;
				}
			</style>

			<div style="text-align:center;padding-top:25px;">
				<div style="font-weight:300; font-size:2em;">
					New Address:
				</div>
				<h1 class="new_addr">
					<input id="myInput" value="{{ Session::get('wallet_address') }}" style="font-weight: bold; border: none; font-size: 0.8em; background: #e8ecee; width: 550px;">
					<img id="copy_address" src="{{ url('/images/copy.png') }}" onclick="copyToclip();" title="Copy to Clipboard">
				</h1>
				<div id="copied_indicator">
					Copied to Clipboard!
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="send_raven_modal">
	<label class="modal__bg" for="modal-1"></label>
	<div class="modal__inner" id="modal__inner">
		<label class="modal__close" for="modal-1" onclick="close_send_raven_modal();"></label>
		<div id="modal_content">

			<style>
			#send_container{
				min-width: 600px;
				padding:50px;
			}
			#issue_to{
				width:95%;
				margin:auto;
				display:block;
				font-size:1.25em;
				margin-bottom:25px;
				margin-top:35px;
				padding:5px;
				float:right;
			}

			#rvn_send_btn{
				font-size:1.5em;
				height:50px;
				font-family:inherit;
				position: relative;
				display: block;
				overflow: hidden;
				width: 100%;
				text-align: center;
				border: 1px solid currentColor;
				border-radius: 5px;
				letter-spacing: 1px;
				cursor: pointer;
				-webkit-transition: background-color 0.4s;
				transition: background-color 0.4s;
				margin-top:20px;
			}

			.rvn_send_active:hover{
				color:#fff;
				background-image: linear-gradient(180deg, var(--home-dark), var(--home-light));
			}

			#amt_container, #pin_container{
				width:100%;
				text-align:right;
				margin-bottom:25px;
				font-size:1.25em;

			}

			#rvn_amt, #pin{
				font-size:1.25em;
				width: 318px;
				text-align:right;
			}

			#invalid_address{
				position:absolute;left:0;top:205px; color:red; font-weight:300; display:none;
			}

			#send_container{
			width:60%; margin:auto; text-align:center; position:relative;
			}

			@media (max-width:600px){
				#send_container{
					width:80%;
					min-width: auto;
				}

				#rvn_amt, #pin{
					width: 275px;
				}
			}

			@supports (-webkit-overflow-scrolling:touch){
				#rvn_amt, #pin{
					width: 240px;
				}
			}


			</style>

			<div id="send_container">
				<h1>Send Ravencoin</h1>
				<div id="send_rvn_form" autocomplete="off">
					<input type="text" id="issue_to" placeholder="Enter receipient address..." value="" required>
					<div id="amt_container">
						<label for="rvn_amt">RVN Amount: </label>
						<input type="text" id="rvn_amt" required="">
					</div>

					<div style="text-align:right;" id="web_pin">
						<div style="display:inline-block; vertical-align: top; font-size:1.5em;">
							PIN:
						</div>
						<div style="display:inline-block;">
							<div id="pin_container" style="text-align: center;">
								<input type="text" id="send_pin1" class="masked pin_input pin1" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#send_pin2').focus();">
								<input type="text" id="send_pin2" class="masked pin_input" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#send_pin3').focus();">
								<input type="text" id="send_pin3" class="masked pin_input" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#send_pin4').focus();">
								<input type="text" id="send_pin4" data-pinid="pin" class="masked pin_input" inputmode="numeric" pattern="[0-9]*" maxlength="1">
							</div>
						</div>
					</div>

					<div id="review_btn_container">
						<input type="submit" id="rvn_send_btn" class="action" value="Send RVN" onclick="send_rvn();">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="send_asset_modal">
  <label class="modal__bg" for="modal-1"></label>
  <div class="modal__inner" id="modal__inner">
      <label class="modal__close" for="modal-1" onclick='$("#send_asset_modal").css("display", "none");'></label>
      <div id="modal_content">
          <div id="testnet_indicator">
            --TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--TESTNET--
          </div>

          <style>
          #send_container{
            min-width: 600px;
            padding:50px;
          }

          #issue_to_asset, #asset_name{
            width:98%;
            margin:auto;
            display:block;
            font-size:1.25em;
            margin-bottom:25px;
            padding:5px;
          }
          #issue_to_asset{
           margin-top:75px;
          }

          #rvn_send_btn{
            font-size:1.5em;
            height:50px;
            font-family:inherit;
            position: relative;
            display: block;
            overflow: hidden;
            width: 100%;
            text-align: center;
            border: 1px solid currentColor;
            border-radius: 5px;
            letter-spacing: 1px;
            cursor: pointer;
            background-color: rgba(255, 255, 255, 0.1);
            -webkit-transition: background-color 0.4s;
            transition: background-color 0.4s;
            margin-top:20px;
          }

          #rvn_send_btn:hover{

          }

          .rvn_send_active:hover{
            color:#fff;
            background-image: linear-gradient(180deg, var(--home-dark), var(--home-light));
          }

          #amt_container, #pin_container{
            width:100%;
            text-align:right;
            margin-bottom:25px;
            font-size:1.25em;
          }
          #asset_amt, #pin{
            font-size:1.25em;
            width: 318px;
            text-align:right;
          }
          #invalid_address{
            position:absolute;left:0;top:205px; color:red; font-weight:300; display:none;
          }

          #send_container{
            width:60%; margin:auto; text-align:center; position:relative;
          }

          #asset_container{
           position:relative;
          }

          #show_admin_container{
            height:45px;
          }

          .autocomplete-items{
            width:100%; background-color:'#EEE';color:'#333';font-size:'1.25em';z-index:50;position:'absolute';display:none;
            top:10px;
          }
          .autocomplete-active{background-color:#333;color:#fff}
          .autocomplete-item{font-weight:300;cursor:pointer}
          .autocomplete-item:hover{background-color:#333;color:#FFF}
          .admin-item{color:#F00;}
          @media(max-width:768px){
            #send_container{
              width:80%;
              min-width: auto;
              position:relative;
            }
          }
          @media (max-width:600px){
            #asset_amt, #pin{
              width: 275px;
            }
          }

          @supports (-webkit-overflow-scrolling:touch){
            #asset_amt, #pin{
             width: 240px;
            }
          }
          </style>

          <div id="send_container">
              <h1>Send Asset</h1>
              <div id="send_asset_form" autocomplete="off">
                  <div id="asset_container">
                    <input type="text" id="issue_to_asset" name="issue_to" placeholder="Enter receipient address..." class="input_send_asset">
                    <input type="text" name="asset_name" id="asset_name" placeholder="Asset Name..." class="input_send_asset">
                    <div id="asset_name-autocomplete-items" class="autocomplete-items" style="background-color:#eee;"></div>
                  </div>
                  <div id="amt_container">
                    <label for="asset_amt">Amount to Send: </label>
                    <input type="number" id="asset_amt" name="asset_amt" min="1" class="input_send_asset">
                  </div>
                  <div style="text-align:right;">
                      <div style="display:inline-block; vertical-align:top; font-size:1.5em;">PIN:</div>
                      <div style="display:inline-block;">
                          <div id="pin_container" style="text-align: center;">
                              <input type="text" id="asset_pin1" class="masked pin_input pin1 input_send_asset" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#asset_pin2').focus();">
                              <input type="text" id="asset_pin2" class="masked pin_input input_send_asset" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#asset_pin3').focus();">
                              <input type="text" id="asset_pin3" class="masked pin_input input_send_asset" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#asset_pin4').focus();">
                              <input type="text" id="asset_pin4" data-pinid="pin" class="masked pin_input input_send_asset" inputmode="numeric" pattern="[0-9]*" maxlength="1">
                          </div>
                      </div>
                  </div>
                  <style type="text/css">
                    #asset_send_btn{
                        font-size:1.5em;
                        height:50px;
                        font-family:inherit;
                        position: relative;
                        display: block;
                        overflow: hidden;
                        width: 100%;
                        text-align: center;
                        border: 1px solid currentColor;
                        border-radius: 5px;
                        letter-spacing: 1px;
                        cursor: pointer;
                        -webkit-transition: background-color 0.4s;
                        transition: background-color 0.4s;
                        margin-top:20px;
                    }
                  </style>
                  <div id="review_btn_container">
                    <input type="button" id="asset_send_btn" class="action" value="Send Asset" onclick="try_send_asset();">
                    <h3 id="send_asset_error" style="display: none;"></h3>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>

<div class="modal" id="transfer_admin_modal">
    <label class="modal__bg" for="modal-1"></label>
    <div class="modal__inner" id="modal__inner">
        <label class="modal__close" for="modal-1" onclick='$("#transfer_admin_modal").css("display", "none"); $("#transfer_admin_modal").css("opacity", "0");'></label>
        <div id="modal_content">
            <style type="text/css">
                #transfer_to{
                    width:95%;
                    margin:auto;
                    display:block;
                    font-size:1.25em;
                    margin-bottom:25px;
                    margin-top:35px;
                    padding:5px;
                    float:right;
                }
            </style>
            <div id="send_container">
                <h1>Transfer</h1>
                <div id="send_rvn_form" autocomplete="off">
                    <input type="text" id="transfer_to" class="transfer" placeholder="Enter receipient address..." value="" required>
                    <div style="text-align:right;" id="web_pin">
                        <div style="display:inline-block; vertical-align: top; font-size:1.5em;">
                            PIN:
                        </div>
                        <div style="display:inline-block;">
                            <div id="pin_container" style="text-align: center;">
                                <input type="text" id="admin_pin1" class="masked pin_input pin1 transfer" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#admin_pin2').focus();">
                                <input type="text" id="admin_pin2" class="masked pin_input transfer" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#admin_pin3').focus();">
                                <input type="text" id="admin_pin3" class="masked pin_input transfer" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#admin_pin4').focus();">
                                <input type="text" id="admin_pin4" data-pinid="pin" class="masked pin_input transfer" inputmode="numeric" pattern="[0-9]*" maxlength="1">
                            </div>
                        </div>
                    </div>
                    <style type="text/css">
                        #confirm_transfer_admin{
                            font-size:1.5em;
                            height:50px;
                            font-family:inherit;
                            position: relative;
                            display: block;
                            overflow: hidden;
                            width: 100%;
                            text-align: center;
                            border: 1px solid currentColor;
                            border-radius: 5px;
                            letter-spacing: 1px;
                            cursor: pointer;
                            -webkit-transition: background-color 0.4s;
                            transition: background-color 0.4s;
                            margin-top:20px;
                        }
                    </style>

                    <div id="review_btn_container">
                        <input type="button" id="confirm_transfer_admin" class="action" value="Transfer" onclick="transfer_admin();">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="reissue_modal">
    <label class="modal__bg" for="modal-1"></label>
    <div class="modal__inner" id="modal__inner">
        <label class="modal__close" for="modal-1" onclick='$("#reissue_modal").css("display", "none"); $("#reissue_modal").css("opacity", "0");'></label>
        <div id="modal_content">
            <style type="text/css">
                .reissue_input{
                    width:95%;
                    margin:auto;
                    display:block;
                    font-size:1.25em;
                    margin-bottom:25px;
                    margin-top:35px;
                    padding:5px;
                    float:right;
                }

                #select_file_btn{
                    font-size:1em;
                    height:50px;
                    font-family:inherit;
                    position: relative;
                    display: block;
                    overflow: hidden;
                    width: 95%;
                    margin: auto;
                    text-align: center;
                    border: 1px solid currentColor;
                    border-radius: 5px;
                    letter-spacing: 1px;
                    cursor: pointer;
                    -webkit-transition: background-color 0.4s;
                    transition: background-color 0.4s;
                    margin-bottom: 25px;
                }
            </style>
            <div id="send_container">
                <h1>Reissue Asset</h1>
                <div id="send_rvn_form" autocomplete="off">
                    <input type="text" id="new_unit" class="reissue_input reissue_input1" placeholder="Enter Unit..." value="" min="1" required>
                    <input type="text" min="1" id="new_amount" class="reissue_input reissue_input1" placeholder="Enter Qty..." value="" required>
                    <input type="text" id="new_ipfs_hash" class="reissue_input" placeholder="IPFS..." value="">
                    <input type="button" id="select_file_btn" value="SELECT FILE" onclick="$('#ipfs_file').click();" />
                    <input type="file" id="ipfs_file" onchange="reissue_ipfs_change(this);" style="display: none;" />
                    <div id="show_admin_container">
                        <input class="hidden-xs-up" name="reissuable" id="show_tokens" type="checkbox">
                        <label class="cbx" for="show_tokens"></label>
                        <label class="lbl" for="show_tokens" style="padding-left:5px;">Reissuable</label>
                    </div>
                    <div style="text-align:right;" id="web_pin">
                        <div style="display:inline-block; vertical-align: top; font-size:1.5em;">
                            PIN:
                        </div>
                        <div style="display:inline-block;">
                            <div id="pin_container" style="text-align: center;">
                                <input type="text" id="reissue_pin1" class="masked pin_input pin1 reissue_input1" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#reissue_pin2').focus();">
                                <input type="text" id="reissue_pin2" class="masked pin_input reissue_input1" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#reissue_pin3').focus();">
                                <input type="text" id="reissue_pin3" class="masked pin_input reissue_input1" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#reissue_pin4').focus();">
                                <input type="text" id="reissue_pin4" data-pinid="pin" class="masked pin_input reissue_input1" inputmode="numeric" pattern="[0-9]*" maxlength="1">
                            </div>
                        </div>
                    </div>
                    <style type="text/css">
                        #confirm_reissue{
                            font-size:1.5em;
                            height:50px;
                            font-family:inherit;
                            position: relative;
                            display: block;
                            overflow: hidden;
                            width: 100%;
                            text-align: center;
                            border: 1px solid currentColor;
                            border-radius: 5px;
                            letter-spacing: 1px;
                            cursor: pointer;
                            -webkit-transition: background-color 0.4s;
                            transition: background-color 0.4s;
                            margin-top:20px;
                        }
                    </style>

                    <div id="review_btn_container">
                        <input type="button" id="confirm_reissue" class="action" value="Reissue" onclick="reissue_asset();">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal" id="transfer_admin_modal">
    <label class="modal__bg" for="modal-1"></label>
    <div class="modal__inner" id="modal__inner">
        <label class="modal__close" for="modal-1" onclick='$("#transfer_admin_modal").css("display", "none"); $("#transfer_admin_modal").css("opacity", "0");'></label>
        <div id="modal_content">
            <style type="text/css">
                .reissue_input{
                    width:95%;
                    margin:auto;
                    display:block;
                    font-size:1.25em;
                    margin-bottom:25px;
                    margin-top:35px;
                    padding:5px;
                    float:right;
                }
            </style>
            <div id="send_container">
                <h1>Transfer</h1>
                <div id="send_rvn_form" autocomplete="off">
                    <input type="text" id="amount" class="re_pin reissue_input" placeholder="Enter receipient address..." value="" required>
                    <input type="text" id="amount" class="re_pin reissue_input" placeholder="Enter receipient address..." value="" required>
                    <div style="text-align:right;" id="web_pin">
                        <div style="display:inline-block; vertical-align: top; font-size:1.5em;">
                            PIN:
                        </div>
                        <div style="display:inline-block;">
                            <div id="pin_container" style="text-align: center;">
                                <input type="text" id="re_pin1" class="masked pin_input pin1 re_pin" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#re_pin2').focus();">
                                <input type="text" id="re_pin1" class="masked pin_input re_pin" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#re_pin3').focus();">
                                <input type="text" id="re_pin1" class="masked pin_input re_pin" inputmode="numeric" pattern="[0-9]*" maxlength="1" oninput="$('#re_pin4').focus();">
                                <input type="text" id="re_pin1" data-pinid="pin" class="masked pin_input re_pin" inputmode="numeric" pattern="[0-9]*" maxlength="1">
                            </div>
                        </div>
                    </div>
                    <style type="text/css">
                        #confirm_reissue{
                            font-size:1.5em;
                            height:50px;
                            font-family:inherit;
                            position: relative;
                            display: block;
                            overflow: hidden;
                            width: 100%;
                            text-align: center;
                            border: 1px solid currentColor;
                            border-radius: 5px;
                            letter-spacing: 1px;
                            cursor: pointer;
                            -webkit-transition: background-color 0.4s;
                            transition: background-color 0.4s;
                            margin-top:20px;
                        }
                    </style>

                    <div id="review_btn_container">
                        <input type="button" id="confirm_reissue" class="action" value="Confirm" onclick="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
@if(Session::has('seed'))
<script type="text/javascript">
    var old_amount = 0, asset_name = "";
	$(document).ready(function(){
		$.ajax({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type : 'POST',
			url : '/get_my_assets',
			data : {
				_token : "<?php echo csrf_token() ?>"
			},
			success:function(res, status){
				if(res == 1){
					console.log("No Assets!");
				}
				else{
					result = JSON.parse(res);
					if(result.length != 0){
						var temp = '';
						for(var i = 0; i < result.length; i ++){
                            if(result[i].amount != 0){
                                temp += '<div class="asset_disp">';
                                temp += '<div class="asset_icon">';
                                // <img src="{{ url('/images/ravenlogo.png') }}">
                                temp += '</div>';
                                temp += '<span class="asset_name">' + result[i].asset_name + '</span>';
                                temp += '<div class="asset_qty">';
                                temp += '<span style="font-weight:300;">Qty: </span>';
                                temp += '<span class="rvn_tab_balance">' + result[i].amount + '</span>';
                                temp += '</div>';
                                temp += '</div  >';
                            }
						}
						$('#myasset_list').html(temp);
					}
				}
			}
		});

        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'POST',
            url : '/get_my_admin_assets',
            data : {
                _token : "<?php echo csrf_token() ?>"
            },
            success:function(res, status){
                if(res == 1){
                    console.log("No Assets!");
                }
                else{
                    result = JSON.parse(res);
                    if(result.length != 0){
                        var temp = '';
                        for(var i = 0; i < result.length; i ++){
                            temp += '<div class="asset_disp">';
                            temp += '<div class="asset_icon">';
                            temp += '</div>';
                            temp += '<span class="asset_name">' + result[i].asset_name + '</span>';

                            temp += '<div class="asset_qty">';
                            temp += '<span class="dropbtn" onclick="myFunction('+i+')"><i class="fa fa-cog" style="font-size:40px;"></i></span>';
                            temp += '<div id="myDropdown'+i+'" class="dropdown-content"><a href="#" class="transfer_admin">Transfer Admin</a>';
                            if(result[i].reissuable == 1){
                                temp += '<a href="#" class="reissue_asset">Reissue</a>';
                            }
                            temp += '</div></div>';
                            temp += '</div>';
                        }
                        $('#admin_list').html(temp);

                        $(".transfer_admin").on('click', function(e){
                            var asset_name = $(this).parent().parent().parent().children('.asset_name').html();
                            $("#transfer_admin_modal h1").html("Transfer Admin of " + asset_name);
                            $("#confirm_transfer_admin").prop("disabled", false);
                            $(".transfer").removeClass('warn_in');
                            $("#transfer_admin_modal").css("display", "block");
                            $("#transfer_admin_modal").css("opacity", "1");
                            document.getElementById($(this).parent().attr("id")).classList.toggle("show");
                        });

                        $(".reissue_asset").on('click', function(e){
                            asset_name = $(this).parent().parent().parent().children('.asset_name').html();
                            $("#reissue_modal h1").html("Reissue " + asset_name);
                            $("#confirm_reissue").prop("disabled", false);
                            $(".reissue_input1").removeClass('warn_in');
                            document.getElementById($(this).parent().attr("id")).classList.toggle("show");

                            $.ajax({
                                headers:{
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                type : 'POST',
                                url : '/get_details_of_specific',
                                data : {
                                    _token : "<?php echo csrf_token() ?>",
                                    asset_name : asset_name
                                },
                                success:function(res, status){
                                    if(res == "error"){
                                        alert("something goes wrong!");
                                    }
                                    else{
                                        $("#new_unit").attr("placeholder", "Current Unit is " + res["unit"]);
                                        $("#new_amount").attr("placeholder", "Current Amount is " + res["amount"]);
                                        old_amount = res["amount"];
                                        $("#new_ipfs_hash").val(res["ipfs"]);
                                        if(res["reissuable"]){
                                            $("#show_tokens").prop("checked", true);
                                        }
                                        else{
                                            $("#show_tokens").prop("checked", false);
                                        }
                                        $("#reissue_modal").css("display", "block");
                                        $("#reissue_modal").css("opacity", "1");
                                    }
                                }
                            });
                        });
                    }
                }
            }
        });

        $(".input_send_asset").focus(function(){
            $(this).removeClass('warn_in');
        });
	});
</script>
@else
@endif

<script type="text/javascript">
	var flag = 2, login_flag = 2, wallet_flag = 2, seed_flag = 2, seed_asset_flag = 2;
	var raven_flag = 2;
	$(document).ready(function(){

        $(".reissue_input1").on('focus', function(e){
            $(this).removeClass('warn_in');
        });

		$(".pin_input").on('keypress', function(e){
			var charInput = e.keyCode;
		    if((charInput < 48) || (charInput > 57)) {
		    	e.preventDefault();
		    }
		});

		$("#input_seed").focus(function(){
			$("#error12_msg").css("display", "none");
		});

		$("#close_main").click(function(){
			$("#create_main_modal").css("display", "none");
			$("#create_main_modal").css("opacity", "0");
			set_deafult();
		});

		$("#login_close").click(function(){
			$("#login_modal").css("display", "none");
			$("#login_modal").css("opacity", "0");
			set_deafult();
		});

		$(".basic_input").focus(function(){
			$("#pwd_msg").css("display", "none");
			$("#pin_msg").css("display", "none");
			$("#already_msg").css("display", "none");
		});

		$(".user_info_alt").focus(function(){
			$("#error_msg").css("display", "none");
		});

		$("#create_seed").click(function(){
			temp = $("#input_seed").val().split(" ");
			if(temp.length != 12){
				$("#error12_msg").css("display", "block");
				return;
			}
			for(i = 0;i < temp.length; i ++){
				if(temp[i] == "" || temp[i] == " "){
					$("#error12_msg").css("display", "block");
					return;
				}
			}
			close_seed();
			temp = temp.join(" ");
			$("#seed_phrase").html(temp);
			$("#create_main_modal").css("display", "block");
			$("#create_main_modal").css("opacity", "1");
			flag = 2;
		});

		window.onclick = function(event) {
			if($("#create_main_modal").css("display") != "none"){
				for(var i = 0; i < (event.path).length; i ++){
					if((event.path)[i] == $("#create_main_modal #modal__inner")[0]){
						if(flag == 1){
							flag = 0;
						}
					}
				}
				if(flag == 1){
					$("#create_main_modal").css("display", "none");
					$("#create_main_modal").css("opacity", "0");
					set_deafult();
				}
				flag = 1;
			}

			if($("#login_modal").css("display") != "none"){
				for(var i = 0; i < (event.path).length; i ++){
					if((event.path)[i] == $("#login_modal #modal__inner")[0]){
						if(login_flag == 1){
							login_flag = 0;
						}
					}
				}
				if(login_flag == 1){
					$("#login_modal").css("display", "none");
					$("#login_modal").css("opacity", "0");
					set_deafult();
				}
				login_flag = 1;
			}

			if($("#wallet_menus").css("display") != "none"){
				for(var i = 0; i < (event.path).length; i ++){
					if((event.path)[i] == $("#wallet_menus #modal__inner")[0]){
						if(wallet_flag == 1){
							wallet_flag = 0;
						}
					}
				}
				if(wallet_flag == 1){
					$("#wallet_menus").css("display", "none");
					$("#wallet_menus").css("opacity", "0");
					set_deafult();
				}
				wallet_flag = 1;
			}

			if($("#send_raven_modal").css("display") != "none"){
				for(var i = 0; i < (event.path).length; i ++){
					if((event.path)[i] == $("#send_raven_modal #modal__inner")[0]){
						if(raven_flag == 1){
							raven_flag = 0;
						}
					}
				}
				if(raven_flag == 1){
					$("#send_raven_modal").css("display", "none");
					$("#send_raven_modal").css("opacity", "0");
					set_deafult();
				}
				raven_flag = 1;
			}

			if($("#seed").css("display") != "none"){
				for(var i = 0; i < (event.path).length; i ++){
					if((event.path)[i] == $("#seed #modal__inner")[0]){
						if(seed_flag == 1){
							seed_flag = 0;
						}
					}
				}
				if(seed_flag == 1){
					$("#seed").css("display", "none");
					$("#seed").css("opacity", "0");
				}
				seed_flag = 1;
			}

            // if (!event.target.matches('.dropbtn')) {
            //     var dropdowns = document.getElementsByClassName("dropdown-content");
            //     var i;
            //     console.log(dropdowns.length);
            //     for (i = 0; i < dropdowns.length; i++) {
            //         var openDropdown = dropdowns[i];
            //         if (openDropdown.classList.contains('show')) {
            //             openDropdown.classList.remove('show');
            //         }
            //     }
            // }
		}

		//Creating User Wallet
		$("#reg_btn").click(function(){
			var email = $("#user_email").val();
			var password = $("#pwd").val();
			var confirm = $("#pwd2").val();
			var pin = "" + $("#pin1").val() + $("#pin2").val() + $("#pin3").val() + $("#pin4").val();
			var con_pin = "" + $("#conf1").val() + $("#conf2").val() + $("#conf3").val() + $("#conf4").val();
			if(validateEmail(email)){
				if(password != confirm){
					$("#pwd_msg").css("display", "block");
				}

				if(pin != con_pin){
					$("#pin_msg").css("display", "block");
					return;
				}

				seed = $("#seed_phrase").html();
				$.ajax({
					headers:{
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type : 'POST',
					url : '/register_user',
					data : {
						_token : "<?php echo csrf_token() ?>",
						email : email,
						password : password,
						pin_code : pin,
						seed : seed
					},
					success:function(res, status){
						window.location.reload(true);
					}
				});
			}
		});

		$("#wallet_login").click(function(){
			$(this).css("display", "none");
			$("#transaction_loading").css("display", "block");
			var email = $("#login_email").val();
			var password = $("#login_pwd").val();
			$.ajax({
				headers:{
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type : 'POST',
				url : '/login',
				data : {
					_token : "<?php echo csrf_token() ?>",
					email : email,
					password : password,
				},
				success:function(res, status){
					if(res == 1){
						window.location.reload(true);
					}
					else if(res == 0){
						$("#error_msg").css("display", "block");
					}
				}
			});
		});


		$("#rvn_send_btn").click(function(){
			if($("#issue_to").val() != "" && $("#rvn_amt").val() != "" && $("#send_pin1").val() != "" && $("#send_pin2").val() != "" && $("#send_pin3").val() != "" && $("#send_pin4").val() != ""){
				$("this").prop('disabled', true);
				$.ajax({
					headers:{
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					},
					type : 'POST',
					url : '/send_raven',
					data : {
						_token : "<?php echo csrf_token() ?>",
						send_to : $("#issue_to").val(),
						send_amount : parseFloat($("#rvn_amt").val()),
						pin_code : "" + $("#send_pin1").val() + $("#send_pin2").val() + $("#send_pin3").val() + $("#send_pin4").val()
					},
					success:function(res, status){
						console.log(res);
						if(res != ""){
							alert(res);
						}
						else{
							window.location.reload(true);
						}
					}
				});
			}
		});

        $(".transfer").on('focus', function(e){
            $(this).removeClass('warn_in');
        });
	});

	var get_newAddress = function(){
        $("#menu_disp").prop("checked", false);

		$("#wallet_menus").css("display", "block");
		$("#wallet_menus").css("opacity", "1");
		wallet_flag = 2;
	}

	var exiting_seed = function(){
		$("#input_seed").val("");
		$("#error12_msg").css("display", "none");

		$("#seed").css("display", "block");
		$("#seed").css("opacity", "1");

		seed_flag = 2;
	}

	var close_seed = function(){
		$("#seed").css("display", "none");
		$("#seed").css("opacity", "0");
	}

	var show_modal = function(){
		$("#create_main_modal").css("display", "block");
		$("#create_main_modal").css("opacity", "1");
		temp = '';
		for(var i = 0; i < 12; i ++){
			temp += get_random_word() + ' ';
		}
		temp.substring(0, temp.length - 1);

		$("#seed_phrase").html(temp);
		flag = 2;
	}

	var send_raven = function(){
		$("#menu_disp").prop("checked", false);
		$("#send_raven_modal").css("display", "block");
		$("#send_raven_modal").css("opacity", "1");
		raven_flag = 2;
	}

	var set_deafult = function(){
		$("#affirm_wrote").prop("checked", false);
		$("#user_email").val("");
		$("#pwd").val("");
		$("#pwd2").val("");
		$("#pin1").val("");
		$("#pin2").val("");
		$("#pin3").val("");
		$("#pin4").val("");
		$("#conf1").val("");
		$("#conf2").val("");
		$("#conf3").val("");
		$("#conf4").val("");
		$("#pwd_msg").css("display", "none");
		$("#pin_msg").css("display", "none");
		$("#already_msg").css("display", "none");
		$("#error_msg").css("display", "none");
		$("#reg_btn").prop("disabled", false);

		$("#login_email").val("");
		$("#login_pwd").val("");

		$("#wallet_login").css("display", "block");
		$("#transaction_loading").css("display", "none");
	}

	var validateEmail = function(email) {
	    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	    return re.test(String(email).toLowerCase());
	}

	var show_login_modal = function(){
		$("#login_modal").css("display", "block");
		$("#login_modal").css("opacity", "1");
		login_flag = 2;
	}

	var logout = function(){
		$.ajax({
			headers:{
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type : 'POST',
			url : '/logout',
			data : {
				_token : "<?php echo csrf_token() ?>"
			},
			success:function(res, status){
				window.location.reload(true);
			}
		});
	}

	var copyToclip = function() {
		var copyText = document.getElementById("myInput");
		copyText.select();
		copyText.setSelectionRange(0, 99999);
		document.execCommand("copy");
		alert("Copied the text: " + copyText.value);
	}

	var close_send_raven_modal = function(){
		$("#send_raven_modal").css("display", "none");
		$("#send_raven_modal").css("opacity", "0");

		$("#issue_to").val("");
		$("#rvn_amt").val("");
		$("#send_pin1").val("");
		$("#send_pin2").val("");
		$("#send_pin3").val("");
		$("#send_pin4").val("");
	}

	var close_wallet_menu = function(){
		$("#wallet_menus").css("display", "none");
		$("#wallet_menus").css("opacity", "0");
	}

	var get_random_word = function(){
		var vowels = ['a', 'e', 'i', 'o', 'u'];
		var consts =  ['b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'qu', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z', 'tt', 'ch', 'sh'];

		var len = Math.floor(Math.random() * 3) + 3;
		var word = '';

		var is_vowel = false;

		var arr;

		for (var i = 0; i < len; i++) {

		  if (is_vowel) arr = vowels
		  else arr = consts
		  is_vowel = !is_vowel;

		  word += arr[Math.round(Math.random()*(arr.length-1))];
		}

		return word;
	}

	var on_assets = function(){
	}

    var show_send_asset_modal = function(){
        $("#menu_disp").prop("checked", false);
        $("#rvn_send_btn").prop("disabled", false);

        $.each($(".input_send_asset"), function(){
            $(this).val("");
            $(this).removeClass('warn_in');
        });
        $("#send_asset_error").css("display", "none");
        $("#send_asset_modal").css("display", "block");
        $("#send_asset_modal").css("opacity", "1");

        seed_asset_flag = 2;
    }

    var try_send_asset = function(){
        var ff = 0;
        $.each($(".input_send_asset"), function(){
            if($(this).val() == ""){
                $(this).addClass('warn_in');
                ff = 1;
            }
        });
        if(ff == 1){return;}

        pin = "" + $("#asset_pin1").val() + $("#asset_pin2").val() + $("#asset_pin3").val() + $("#asset_pin4").val();
        console.log(pin+":"+$("#issue_to_asset").val()+":"+$("#asset_name").val()+":"+$("#asset_amt").val());

        $("#rvn_send_btn").prop("disabled", true);
        $.ajax({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type : 'POST',
            url : '/try_send_asset',
            data : {
                _token : "<?php echo csrf_token() ?>",
                pin : pin,
                send_address : $("#issue_to_asset").val(),
                asset_name : $("#asset_name").val(),
                amount : $("#asset_amt").val(),

            },
            success:function(res, status){
                if(res != "success"){
                    $("#send_asset_error").html(res);
                    $("#send_asset_error").css("display", "block");
                }
                else{
                    window.location.reload(true);
                }
            }
        });
    }
    function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
// window.onclick = function(event) {
//   if (!event.target.matches('.dropbtn')) {
//     var dropdowns = document.getElementsByClassName("dropdown-content");
//     var i;
//     for (i = 0; i < dropdowns.length; i++) {
//       var openDropdown = dropdowns[i];
//       if (openDropdown.classList.contains('show')) {
//         openDropdown.classList.remove('show');
//       }
//     }
//   }
// }
function myFunction(idx) {
    $.each($(".dropdown-content"), function(index, value){
        if(document.getElementById($(this).attr('id')).classList[1] && idx != index) {
            document.getElementById($(this).attr('id')).classList.toggle("show");
        }
    });

    document.getElementById("myDropdown"+idx).classList.toggle("show");
}

var transfer_admin = function(){
    var temp = 0;
    $.each($(".transfer"), function(){
        if($(this).val() == ""){
            $(this).addClass("warn_in");
            temp = 1;
        }
    });
    if(temp == 1){
        return;
    }
    transfer_to = $("#transfer_to").val();
    pin = "" + $("#admin_pin1").val() + $("#admin_pin2").val() + $("#admin_pin3").val() + $("#admin_pin4").val();

    $("#confirm_transfer_admin").prop("disabled", true);

    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type : 'POST',
        url : '/transfer_admin',
        data : {
            _token : "<?php echo csrf_token() ?>",
            pin : pin,
            transfer_to : transfer_to
        },
        success:function(res, status){
            if(res == "success"){
                window.location.reload(true);
            }
            else{
                alert(res);
                $("#confirm_transfer_admin").prop("disabled", false);
            }
        }
    });
}

var reissue_ipfs_change = function(input){
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
                    $("#new_ipfs_hash").val(res);
                }
              }
            });
        };
        reader.readAsDataURL(input.files[0]);
    }
}

var reissue_asset = function(){
    var temp = 0;
    $.each($(".reissue_input1"), function(){
        if($(this).val() == ""){
            $(this).addClass("warn_in");
            temp = 1;
        }
    });

    if($("#new_unit").val() < 1){
        temp = 1;
        $("#new_unit").addClass('warn_in');
    }

    if($("#new_amount").val() < 1){
        temp = 1;
        $("#new_amount").addClass('warn_in');
    }

    if(temp == 1){
        return;
    }

    pin = "" + $("#reissue_pin1").val() + $("#reissue_pin2").val() + $("#reissue_pin3").val() + $("#reissue_pin4").val();


    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type : 'POST',
        url : '/try_reissue',
        data : {
            _token : "<?php echo csrf_token() ?>",

        },
        success:function(res, status){
            if(status == "success"){
                $("#new_ipfs_hash").val(res);
            }
        }
    });
    $("#confirm_reissue").prop("disabled", true);
}

var reissue_asset = function(){
    var temp = 0;
    $.each($(".reissue_input1"), function(){
        if($(this).val() == ""){
            $(this).addClass("warn_in");
            temp = 1;
        }
    });

    if($("#new_unit").val() < -1 || $("#new_unit").val() > 8){
        temp = 1;
        $("#new_unit").addClass('warn_in');
    }

    if($("#new_amount").val() < 1){
        temp = 1;
        $("#new_amount").addClass('warn_in');
    }

    if(temp == 1){
        return;
    }

    pin = "" + $("#reissue_pin1").val() + $("#reissue_pin2").val() + $("#reissue_pin3").val() + $("#reissue_pin4").val();


    $.ajax({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type : 'POST',
        url : '/try_reissue',
        data : {
            _token : "<?php echo csrf_token() ?>",
            asset_name : asset_name,
            new_unit : $("#new_unit").val(),
            new_amount : $("#new_amount").val(),
            ipfs : $("#new_ipfs_hash").val(),
            reissuable : $("#show_tokens").prop("checked")?1:0,
            pin : pin

        },
        success:function(res, status){
            if(res != "success"){
                alert("Something went wrong! Try again!");
                $("#confirm_reissue").prop("disabled", false);
            }
            else{
                window.location.reload(true);
            }
        }
    });
    $("#confirm_reissue").prop("disabled", true);
}
</script>

@endsection