<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title><?php echo $data["title"] ? "{$data["title"]} | DoAnPHP" : "DoAnPHP" ?></title>
  <!--begin::Accessibility Meta Tags-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
  <!--end::Accessibility Meta Tags-->
  <!--begin::Primary Meta Tags-->
  <meta name="title" content="<?php echo $title ?>" />
  <!--end::Primary Meta Tags-->
  <link rel="preload" href="./public/css/app.css" as="style" />
  <link rel="stylesheet" href="./public/css/app.css" />

  <script type="module" src="./public/js/app.js"></script>
  <script>
    const AppConfig = {
      baseUrl: '<?php echo _HOST_URL; ?>'
    };
  </script>
</head>