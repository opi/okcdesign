<?php
/**
 * @file page.tpl.php
 * @see modules/system/page.tpl.php for drupal documentation of a page.tpl.php
 *
 * This is only a very basic example of how to use foundation classes.
 *
 * class "row" is a special class dedicated to foundation framework.
 * Please @see http://foundation.zurb.com/docs/components/grid.html on how to use.
 * It's up to you to override this template and use grid classes as you like.
 *
 * row-wrapper is a optionnal wrapper provided by this template and is not a part
 * of foundation itself.
 *
 * Alternatively, you may wish to keep your html semantic with foundation grid mixins
 * to define rows and columns in your scss rather than in html.
 */
?>

<?php // Display the grid if needed. You need to enable Grid viewer in theme settings. ?>
<?php if (isset($foundation_grid_viewer)) : ?>
  <?php print $foundation_grid_viewer ?>
<?php endif ?>

<?php //display toolbar, if foundation_topbar plugin is enabled in theme settings. ?>
<?php if(isset($foundation_topbar)) :?>
  <?php print $foundation_topbar ?>
<?php endif ?>

  <header class="row-wrapper">

    <!-- site name , logo & slogan -->
    <?php if ($site_name || $logo || $site_slogan) : ?>
      <div class="row">
        <div class="small-12 columns" id="site-informations">
          <h1>

            <?php if ($logo): ?>
              <a href="<?php print $front_page ?>" title="<?php print t('Home') ?>" rel="home" id="logo">
                <img src="<?php print $logo; ?>" alt="<?php print t('Home') ?>" />
              </a>
            <?php endif ?>

            <?php if($site_name): ?>
              <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
                <?php print $site_name ?>
              </a>
            <?php endif ?>

            <?php if ($site_slogan): ?> <small><?php print $site_slogan ?></small> <?php endif ?>

          </h1>
        </div> <!-- /#site-informations -->
      </div>
    <?php endif ?>

    <!-- header region -->
    <?php if($page['header']) : ?>
      <div class="row">
        <div class="small-12 columns">
          <?php print render($page['header']) ?>
        </div>
      </div> <!-- /.row -->
    <?php endif ?>

    <!-- primary and secondary menus -->
    <?php if($main_menu || $secondary_menu):?>
      <div class="row">
        <div class="small-12 columns">
          <nav>
            <?php if ($main_menu) : ?>
              <?php print theme('links__system_main_menu', array('links' => $main_menu, 'attributes' => array('id' => 'main-menu'))) ?>
            <?php endif ?>
            <?php if ($secondary_menu) : ?>
              <?php print theme('links__system_secondary_menu', array('links' => $secondary_menu, 'attributes' => array('id' => 'secondary-menu'))) ?>
            <?php endif ?>
          </nav>
        </div>
      </div>
    <?php endif ?>
    </div>

  </header>


<?php if ($breadcrumb): ?>
  <div class ="row-wrapper" id="breadcrumb">
    <div class="row">
      <div class="small-12 columns">
        <?php print $breadcrumb ?>
      </div>
    </div> <!-- /.row -->
  </div> <!-- /.row-wrapper -->
<?php endif ?>

<?php if ($messages) : ?>
  <div class="row-wrapper" id="messages">
    <div class="row">
      <div class="small-12 columns">
        <?php print $messages ?>
      </div>
    </div> <!-- /.row -->
  </div>  <!-- /.row-wrapper -->
<?php endif ?>

  <section id="content" class="row-wrapper">
    <div class="row">

      <?php // sidebars and content classes use foundation classes, see dynamic_sidebars plugins ?>
      <?php if ($page['sidebar_first']): ?>
        <aside id="sidebar-first" class="<?php print $sidebar_first_classes ?>">
          <?php print render($page['sidebar_first']) ?>
        </aside>
      <?php endif ?>

      <div id="content" class="<?php print $content_classes ?>">

        <?php if ($page['highlighted']): ?><div id="highlighted"><?php print render($page['highlighted']) ?></div><?php endif ?>
        <a id="main-content"></a>
        <?php print render($title_prefix) ?>
        <?php if ($title): ?><h1 class="title" id="page-title"><?php print $title; ?></h1><?php endif ?>
        <?php print render($title_suffix) ?>
        <?php if ($tabs): ?><div class="tabs"><?php print render($tabs); ?></div><?php endif ?>
        <?php print render($page['help']) ?>
        <?php if ($action_links): ?><ul class="action-links"><?php print render($action_links) ?></ul><?php endif ?>
        <?php print render($page['content']) ?>
        <?php print $feed_icons ?>
      </div>

      <?php if ($page['sidebar_second']): ?>
        <aside id="sidebar-second" class="<?php print $sidebar_second_classes ?>">
          <?php print render($page['sidebar_second']) ?>
        </aside>
      <?php endif; ?>

    </div>
  </section>

<?php if ($page['footer']) : ?>
  <footer class="row-wrapper">
    <div class="row">
      <div class="small-12 columns">
        <?php print render($page['footer']); ?>
      </div>
      <div>  <!-- /.row -->
  </footer>  <!-- /.row-wrapper -->
<?php endif ?>