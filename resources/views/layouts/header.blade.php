<header>
  <div id="nav_container">
    <div class="header_content">
      <a href="/">
      <div id="header_title" class='absolute v_center'>
        <!-- <div id="logo_link" class="absolute v_center"></div> -->
        <span id="logo_title">
          <span class="title title_primary">FREXA</span>
          <!-- <span class="title title_secondary">Farm</span> -->
        </span>
      </div>
    </a>
    <div id="net_selector_container" class="absolute total_center">
      <div class="net_toggle_container" id="net_selector_checkbox">
        <input type="checkbox" id="net_selector" class="net_toggle" value="0" name="net_toggle">
        <label id="pseudo-switch" for="net_selector"></label>
        <label id="mainnet_lbl" for="net_selector" class="net_toggle_off absolute net_lbl">MainNet</label>
        <label id="testnet_lbl" for="net_selector" class="net_toggle_on absolute net_lbl">TestNet</label>
        <label id="mobile_main_lbl" for="net_selector" class="net_toggle_off neon3 mobile_ui net_lbl_mobile">MainNet</label>
        <label id="mobile_test_lbl" for="net_selector" class="net_toggle_on neon3 mobile_ui net_lbl_mobile">TestNet</label>
      </div>
    </div>
      <div id="nav_links" class="absolute v_center right">
        <a class="neon nav_link" id="mangowallet_nav" href="/frexawallet"><span class="link_mobile_hide">FREXA </span>Wallet</a>
        @if(Session::has('seed'))
        <a class="neon nav_link" id="assetbuilder_nav" href="/propertybuilder"><span class="link_mobile_hide">Upload </span>Property</a>
        @else
        @endif
        <a class="neon nav_link" id="assetviewer_nav" href="/propertyviewer"><span class="link_mobile_hide">View </span>Property</a>
      </div>
    </div>
  </div>
</header>