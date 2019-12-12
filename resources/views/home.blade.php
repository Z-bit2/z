@extends('layouts.main')

@section('title', 'FREXA | FUND REAL ESTATE EXCHANGE of AMERICA')

@section('content')

<div id="body_container">
    <link rel="stylesheet" href="{{ url('css/welcome.css')}}">
    <div style="position:relative;">
        <!-- <div class="_img"></div> -->
        <div class="subheader">Blockchain Assets ... Made Easy</div>
        <picture>
            <img class="banner_img" src="{{ url('/images/bg7a.jpg') }}" alt="" style="opacity: 0.7;">
            <img class="med_banner" src="{{ url('/images/bg7b.jpg') }}" alt="" style="opacity: 0.7;">
            <img class="sm_banner" src="{{ url('/images/bg7c.jpg') }}" alt="" style="opacity: 0.7;">
            <div style="position:absolute; top:18px; right:1.5%; font-size:1.75em;">
                <a class="neon nav_link" id="mangowallet_nav" href="/frexawallet" style="margin-right:20px;"><span class="welcome_mobile_hide">Frexa </span>Wallet</a>
                <a class="neon" id="assetbuilder_nav" href="/propertybuilder" style="margin-right:25px;"><span class="welcome_mobile_hide">Upload </span>Property</a>
                <a class="neon" id="assetviewer_nav" href="/propertyviewer"><span class="welcome_mobile_hide">View </span>Property</a>
            </div>
            <svg width="100%" height="1280">
                <defs>
                    <linearGradient id="gradient" gradientTransform="rotate(75)">
                        <stop offset="15%" stop-color="#1a237e" />
                        <stop offset="80%" stop-color="#00e5ff" />
                    </linearGradient>
                    <mask id="mask">
                        <rect width="100%" height="100%" fill="#fff" />
                        <text class="hero" x="20%" y="50%">
                            <tspan letter-spacing="8">F r e x a</tspan>
                        </text>
                    </mask>
                </defs>
                <text class="hero" x="20%" y="50%">
                    <tspan opacity="0.3" letter-spacing="8" fill="#000">F R E X A</tspan>
                </text>
                <rect width="100%" height="100%" fill="url(#gradient)" fill-opacity="0.8" mask="url(#mask)" />
            </svg>
        </picture>
    </div>
    <article>
        <div class="tab centered" style="min-height:900px;">
            <h2 style="text-align:left;margin-left:75px; font-size:2.5em; font-family:'Oswald'; letter-spacing:1px;">Frexa is...</h2>
            <div class="tab-painel">
                <input class="tab-open" id="tab-1" name="tab-wrap-1" type="radio" checked>
                <label class="tab-nav" for="tab-1">Simple</label>
                <div class="tab-inner">
                    <p>All the tools needed to create, store and maintain assets on the blockchain are available here in one simple interface.</p>
                    <a href="/propertybuilder">
                        <div class="tab-btn">
                            <div id="build_icon"></div>
                            <div class="tab-btn-text">
                                Use our Property Builder to create your property, as well as create and sign your own custom contract.
                            </div>
                        </div>
                    </a>
                    <a href="/propertyviewer">
                        <div class="tab-btn">
                            <div id="view_icon"></div>
                            <div class="tab-btn-text">
                                Use our Property Viewer to reference any asset which has been issued on the blockchain.
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="tab-painel">
                <input class="tab-open" id="tab-2" name="tab-wrap-1" type="radio">
                <label class="tab-nav" for="tab-2">Secure</label>
                <div class="tab-inner">
                    <p>Frexa is powered by the Ravencoin Network, the leading network for secure blockchain asset tokenization.</p>
                    <div style="margin-left:-75px; margin-top:15px;"><a href="https://ravencoin.org/" target="_blank">
                            <img src="{{ url('/images/blockchain.png') }}">
                        </a></div>
                </div>
            </div>
            <div class="tab-painel">
                <input class="tab-open" id="tab-3" name="tab-wrap-1" type="radio">
                <label class="tab-nav" for="tab-3">Compliant</label>
                <div class="tab-inner">
                    <p>Link your blockchain asset with a custom legal document using Frexa's free online tools.</p>
                    <div style="margin:auto; width:60%; margin-top:55px;">
                        <div style="width:250px; display: inline-block;">
                            <img src="{{ url('/images/document.png') }}"><br>
                            Either create your own custom contract or use our automatically generated template.
                        </div>
                        <div style="display:inline-block; margin:0 40px 0 40px;">
                            <img src="{{ url('/images/arrow.png') }}">
                        </div>
                        <div style="width:250px; display: inline-block;">
                            <img src="{{ url('/images/sign.png') }}"><br>
                            Sign using the one-time use keypair generated during the creation of your asset.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
<input class="modal-state" id="modal-1" type="checkbox" />
<div class="modal">
    <label class="modal__bg" for="modal-1"></label>
    <div class="modal__inner" id="modal__inner">
        <label class="modal__close" for="modal-1"></label>
        <div id="modal_content">
        </div>
    </div>
</div>
@endsection