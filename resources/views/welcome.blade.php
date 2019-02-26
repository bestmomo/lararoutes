<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Laravel Routes</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
    nav ul a,
    nav .brand-logo {
        color: #444;
    }

    p {
        line-height: 2rem;
    }

    .sidenav-trigger {
        color: #26a69a;
    }

    .parallax-container {
        min-height: 420px;
        line-height: 0;
        height: auto;
        color: rgba(255,255,255,.9);
    }
    .parallax-container .section {
        width: 100%;
    }
    footer a {
        color: white;
    }

    @media only screen and (max-width : 992px) {
        .parallax-container .section {
            position: absolute;
            top: 40%;
        }
        #index-banner .section {
            top: 10%;
        }
    }

    @media only screen and (max-width : 600px) {
        #index-banner .section {
            top: 0;
        }
    }

    .icon-block {
        padding: 0 15px;
    }
    .icon-block .material-icons {
        font-size: inherit;
    }

    footer.page-footer {
        margin: 50px 0 0 0;
        padding-top:0;
    }
    .legal {
        font-size: 12px;
    }
  </style>
</head>
<body>

  <div id="contact" class="modal">
    <div class="modal-content">
        <h4>Contact me !</h4>

        <form id="form-contact"  method="POST" action="{{ route('contact') }}">
            @csrf
            <div class="row">
                <div class="input-field col s12">
                    <input id="email" type="email" name="email" required autofocus>
                    <label for="email">Email</label>
                    <span class="red-text"></span>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="message" name="message" class="materialize-textarea" required></textarea>
                    <label for="message">Message</label>
                    <span class="red-text"></span>
                </div>
            </div>
            <button type="submit" class="waves-effect waves-green btn-flat">Submit</button>
        </form>

    </div>
  </div>

  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>
        <h1 class="header center">Laravel Routes</h1>
        <div class="row center">
          <h5 class="header col s12 light">A tool to construct your routes file</h5>
        </div>
        <div class="row center">
            @auth
                <a href="{{ route('routes.index') }}" id="download-button" class="btn waves-effect waves-light teal lighten-1">Get Started</a>
            @endauth
            @guest
                <a href="{{ route('routes.create') }}" id="download-button" class="btn waves-effect waves-light teal lighten-1">Get Started</a>
            @endguest
            &nbsp;
            <a href="{{ url('docs') }}" id="download-button" class="btn waves-effect waves-light teal lighten-1" target="_blank">Documentation</a>
        </div>
        <div class="row center">
            <h6 class="header col s12 light">Version alpha 0.2</h6>
        </div>
        <br><br>

      </div>
    </div>
    <div class="parallax"><img src="img/background1.jpg" alt="Unsplashed background img 1"></div>
  </div>


  <div class="container">
    <div class="section row center grey lighten-5">

        <div class="col m12 l6">
            <h5 class="header">Contruct your routes with the tool</h5>
            <div class="card">
                <div class="card-image">
                    <img src="img/routes.png" alt="routes">
                </div>
            </div>
        </div>


        <div class="col m12 l6">
            <h5 class="header">Then generate the code !</h5>
            <div class="card">
                <div class="card-image">
                    <img src="img/generate.png" alt="generated">
                </div>
            </div>
            <h5 class="header">Or list the routes</h5>
            <div class="card">
                <div class="card-image">
                    <img src="img/list.png" alt="list">
                </div>
            </div>
        </div>
    </div>
  </div>


  <div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h5 class="header col s12 light">Do not get lost on the sideways</h5>
          <h5 class="header col s12 light">You must register to save and manage your creations</h5>
        </div>
      </div>
    </div>
    <div class="parallax"><img src="img/background2.jpg" alt="Unsplashed background img 2"></div>
  </div>

  <div class="container">
    <div class="section grey lighten-5">

      <div class="row">
        <div class="col s12 center">
          <h3><i class="mdi-content-send brown-text"></i></h3>
          <h4>Keep in touch !</h4>
          <p class="light">You can contact me for any question or suggestion for this site</p>
          <button class="waves-effect waves-light btn modal-trigger" data-target="contact"><i class="material-icons left">contact_mail</i>Contact !</button>
        </div>
      </div>

    </div>
  </div>

  <footer class="page-footer teal">
    <div class="container">
        <div class="row center">
            <div class="col s12">
                <p><i class="material-icons">favorite</i> Made with Materialize, Laravel and Vue.js <i class="material-icons">favorite</i></p>
            </div>
        </div>
        <div class="legal center">
            <p><a href="{{ route('privacy') }}">Privacy</a>&nbsp;-&nbsp;<a href="{{ route('legal') }}">Legal mentions</a></p>
        </div>
    </div>
  </footer>


  <!--  Scripts-->
  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    $(function(){
        $('.sidenav').sidenav();
        $('.parallax').parallax();
        $('#contact').modal();

        $(document).on('submit', '#form-contact', function(e) {
            e.preventDefault();

            $('.red-text').text('');
            $('input').removeClass('invalid');
            $('textarea').removeClass('invalid');

            $.ajax({
                method: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json"
            })
            .done(function() {
                $('#contact').modal('close');
            })
            .fail(function(data) {
                $.each(data.responseJSON.errors, function (key, value) {
                    $('#' + key).addClass('invalid');
                    $('#' + key + ' ~ span').text(value[0]);
                });
            });
        });
    });
  </script>

  </body>
</html>
