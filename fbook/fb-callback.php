<?php
if(!session_id()) {
    session_start();
}
require_once '../vendor/facebook/graph-sdk/src/Facebook/autoload.php';


$fb = new Facebook\Facebook([
'app_id' => '1854946121441774',
'app_secret' => '35e2e36f842eaf6dcfcb82812e64ebc8',
'default_graph_version' => 'v2.8',
]);

$data;
$id;

$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();
    $response = $fb->get('/me?fields=email,name', $accessToken);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (! isset($accessToken)) {
    if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    exit;
}

// Logged in
// echo '<h3>Access Token</h3>';
// var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
// echo '<h3>Metadata</h3>';
// print_r($tokenMetadata);
// var_dump($tokenMetadata);
// echo $tokenMetadata->getField('user_id');
// print_r($tokenMetadata->getField('scopes'));
$data = $response->getDecodedBody();
$id = $data['id'];
// print_r($response->getField('name'));
// print_r($response->getField('email'));
// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId('1854946121441774');
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
        exit;
    }
    
    echo '<h3>Long-lived</h3>';
    var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = (string) $accessToken;

// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');
?>


  <!doctype html>

  <head>
    <title>Registro</title>
    <meta charset="UTF-8">
    <!--Import Google Icon Font-->

    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="-1">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="../css/custom.css" media="screen,projection" />
    <link type="text/css" rel="stylesheet" href="../admin/assets/plugins/sweetalert/sweetalert.css" media="screen,projection" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
      body {
        /*display: none;*/
      }
      
      .login {
        display: none;
      }
      
      .hidden {
        display: none;
      }
    </style>
    <script src="../admin/assets/plugins/jquery/jquery-2.2.0.min.js"></script>
    <script type="text/javascript" src="../admin/assets/plugins/sweetalert/sweetalert.min.js">
    </script>
    <script type="text/javascript" src="../js/materialize.min.js"></script>
    <script>
      function registrar() {
        var flag = 0;
        var data = <?php echo json_encode($data);?>;
        data.ciudad = $('#ciudad').val();
        data.telefono = $('#telefono').val();
        data.exec = 'loginfb';

        if (!data.telefono || data.telefono.length < 10) {
          $('#telefono').addClass('invalid');
          flag = 1;
        }
        if (data.ciudad == 0) {
          $('.select-wrapper input').addClass('invalid');
          flag = 1;
        }
        if (flag == 1) {
          swal({
            title: "Error!",
            text: "Por favor ingresa información válida.",
            type: "error",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#2C8BEB"
          });
          return;
        }

        $.ajax({
          type: 'POST',
          url: '../_ctrl/ctrl.service.php',
          data: data,
          success: function(r) {
            var data = JSON.parse(r);
            if (data.status == 202) {
              swal({
                title: "Registro",
                text: "Tu usuario ha sido registrado con éxito, te re-direccionaremos a tu cuenta.",
                type: "success",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#2C8BEB"
              }, function(isConfirm) {
                if (isConfirm) {
                  location.href = '../' + data.redirect;
                }
              });
              localStorage.setItem('uid', data.uid);
            } else if (data.status == 409) {
              console.log('ya existe el correo');
              swal({
                title: "Error!",
                text: "Ya existe un usuario registrado con la cuenta de correo asociada a tu facebook.",
                type: "error",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#2C8BEB"
              });
            } else if (data.status == 408) {
              swal({
                title: "Error!",
                text: "Ya existe un usuario registrado con el número de teléfono ingresado.",
                type: "error",
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#2C8BEB"
              });
              $('#telefono').addClass('invalid');
            }
          }
        })
      }
    </script>

  </head>

  <body>
    <?php if ($data): ?>
      <?php $data = array('data'=>$data, 'exec'=>'isRegisteredFb') ?>
        <script>
          console.log(<?php echo json_encode($data);?>);
          $.ajax({
            type: 'POST',
            url: '../_ctrl/ctrl.service.php',
            data: <?php echo json_encode($data);?>,
            success: function(r) {
              var data = JSON.parse(r);
              console.log(r);
              if (data.status == 202) {
                location.href = '../' + data.redirect;
                localStorage.setItem('uid', data.uid);
              } else if (data.status == 0) {
                var buffer = '';
                var ciudades = data.ciudades;
                ciudades.forEach(function(element) {
                  buffer += '<option value="' + element.id + '">' + element.ciudad + '</option>';
                });
                $('#ciudad').append(buffer);
                $('form').removeClass('hidden');
                $('select').material_select();
              }
            }
          })
        </script>
        <?php else: ?>
          <script>
            $(document).ready(function() {
              //   var url = $('.login').attr('href');
              location.href = 'index.html';
            });
          </script>
          <?php endif ?>
            <?php if ($data): ?>
              <div class="container">
                <form action="" id="frmRegistroFb" name="frmRegistroFb" class="hidden">
                  <div class="row">
                    <div class="col s12 center-align">
                      <img src="https://graph.facebook.com/<?php echo $id; ?>/picture?&type=large" class="responsive-img circle">
                    </div>
                    <div class="input-field col s12">
                      <select name="ciudad" id="ciudad">
                        <option value="0">Selecciona tu ciudad</option>
                      </select>
                      <label for="ciudad">Ciudad</label>
                    </div>
                    <div class="input-field col s12">
                      <input type="number" name="telefono" id="telefono">
                      <label for="telefono">Teléfono</label>
                    </div>
                    <div class="col s12">
                      <a class="btn full-btn blue" onClick="registrar()">Terminar registro</a>
                    </div>
                  </div>
                </form>
              </div>

              <?php else: ?>
                <a href="<?php echo $loginUrl; ?>" class="login">Login with Facebook</a>
                <?php endif ?>
  </body>

  </html>