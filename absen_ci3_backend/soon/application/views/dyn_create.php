<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Create dynamic link vv</title>
    <base href="https://getbootstrap.com/">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.1/examples/sign-in/">



    <!-- Bootstrap core CSS -->
    <link href="/docs/5.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    <!-- Favicons -->
    <link rel="apple-touch-icon" href="/docs/5.1/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.1/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.1/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.1/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
    <link rel="icon" href="/docs/5.1/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#7952b3">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .brd {
            border: solid 1px
        }

        .hide {
            display: none;
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin">
        <div class="container">
            <div class="row ">
                <div class="col-md-3"></div>
                <div class="col-md-6 pt-5 col-sm-12">
                    <form method="post" action="<?= base_url("daftar") ?>">
                        <img class="mb-4" src="/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
                        <h1 class="h3 mb-3 fw-normal">Create Dynamic URL</h1>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="url" placeholder="https://google.com" autocomplete="off" value="" required>
                            <label for="floatingInput">Alamat Website / Alamat Link</label>
                        </div>

                        <div class="form-floating mb-3 input-group">
                            <input type="text" class="form-control" id="DataLink" name="desk" placeholder="direct ke google.com" autocomplete="off" value="<?= date("F Y") ?>" aria-describedby="button-addon2">
							<button class="btn btn-outline-secondary" type="button" id="button-sync">Save Storage</button>
                            <label for="floatingInput">Deskripsi Link</label>
                        </div>

                        <div class="form-floating mb-3 hide">
                            <input type="text" class="form-control" id="floatingInput" name="cha" placeholder="https://google.com" autocomplete="off" value="<?= md5(date("Y-m-d H:i:s")) ?>">
                            <label for="floatingInput">chapca</label>
                        </div>
                        <!-- <div class="form-floating">
                    <input type="" class="form-control" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div> -->
                        <input class="w-100 btn btn-lg btn-primary" type="submit" value="Create DYN">
                        <p class=" my-3 text-muted">
                            <?php
                            if ($this->session->flashdata('result_login')) {
                                echo '<label class="mt-4 alert alert-warning w100" id="error-login">' . $this->session->flashdata('result_login') . '</label>';
                            }
                            if ($this->session->flashdata('result_success')) {
                                echo '<label class="mt-4 alert alert-success w100" id="error-login">' . $this->session->flashdata('result_success') . '</label>';
                            }
                            ?>
                        </p>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </main>

</body>


<script>
	$(document).ready(function(){		
		setTimeout(function () {
		 if (window.localStorage.getItem("DataLink")) {
		  $("#DataLink").val(window.localStorage.getItem("DataLink"));
		 } else {
		  window.localStorage.setItem("DataLink", "<?= date("F Y") ?>");
		  $("#DataLink").val("<?= date("F Y") ?>");
		 }
		},100)
	})
    $(document).on("click", "#copy-button", function() {
        $("#copy-data").select();
        document.execCommand("copy");
		window.localStorage.setItem("DataLink", $("#DataLink").val());
    })
    $(document).on("click", "#button-sync", function() {
		window.localStorage.setItem("DataLink", $("#DataLink").val());
    })
</script>

</html>