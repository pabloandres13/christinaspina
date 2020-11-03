<head <?php language_attributes(); ?>>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="//gmpg.org/xfn/11">
  <meta name="theme-color" content="#000">

  <title>Coming Soon – <?php bloginfo('name') ?></title>

  <?php wp_head(); ?>
  <link rel="stylesheet" href="<?php echo YPRM_PLUGINS_HTTP ?>/assets/css/pt-addons.css?ver=5.4.1" media="all">
</head>

<body <?php body_class() ?>>
  <div id="page">
    <header class="site-header <?php echo esc_attr(yprm_header_class()) ?>">
      <div class="container-fluid">
        <div class="row align-items-center justify-content-between">
          <div class="left col-auto">
          </div>
          <div class="center">
            <div class="logo"><?php echo yprm_site_logo(); ?></div>
          </div>
          <div class="right col-auto">
          </div>
        </div>
      </div>
    </header>

    <?php 

    $maintenance_mode = true;
    require_once get_parent_theme_file_path(). '/page-coming-soon.php';

    ?>
  </div>
  <script src="<?php echo YPRM_PLUGINS_HTTP ?>/assets/js/isotope.pkgd.min.js?ver=3.0.6"></script>
  <script src="<?php echo YPRM_PLUGINS_HTTP ?>/assets/js/jquery.countdown.js?ver=1.0"></script>
  <script src="<?php echo get_parent_theme_file_uri() ?>/js/scripts.js"></script>
  <?php global $novo_theme;

  if(isset($novo_theme['coming_soon_date']) && !empty($novo_theme['coming_soon_date'])) {
    $date_array = explode('/', $novo_theme['coming_soon_date']);
    $month = $date_array[0]-1;
    $day = $date_array[1];
    $year = $date_array[2];
  ?>
    <script>
      jQuery(document).ready(function() {

        var ts = new Date(<?php echo $year.', '.$month.', '.$day ?>);

        if(jQuery('#countdown').length > 0){
          jQuery('#countdown').countdown({
            timestamp: ts,
            callback: function(days, hours, minutes, seconds){
            }
          });
        }
      });
    </script>
  <?php } ?>
</body>



