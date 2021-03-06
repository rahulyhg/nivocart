<?php echo $header; ?>
<?php echo $content_higher; ?>
<?php if ($this->config->get($template . '_breadcrumbs')) { ?>
  <div class="breadcrumb">
  <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
  <?php } ?>
  </div>
<?php } ?>
<?php echo $content_left; ?><?php echo $content_right; ?>
<div id="content"><?php echo $content_high; ?>
  <h1><?php echo $heading_title; ?></h1>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
  <div class="content">
    <table class="form">
      <tr>
        <td><?php echo $entry_newsletter; ?></td>
        <td><?php if ($newsletter) { ?>
          <input type="radio" name="newsletter" value="1" checked="checked" />
          <?php echo $text_yes; ?>&nbsp;
          <input type="radio" name="newsletter" value="0" />
          <?php echo $text_no; ?>
        <?php } else { ?>
          <input type="radio" name="newsletter" value="1" />
          <?php echo $text_yes; ?>&nbsp;
          <input type="radio" name="newsletter" value="0" checked="checked" />
          <?php echo $text_no; ?>
        <?php } ?></td>
      </tr>
    </table>
  </div>
  <div class="buttons">
    <div class="left"><a href="<?php echo $back; ?>" class="button"><i class="fa fa-arrow-left"></i> &nbsp; <?php echo $button_back; ?></a></div>
    <div class="right"><input type="submit" value="<?php echo $button_continue; ?>" class="button" /></div>
  </div>
  </form>
  <?php echo $content_low; ?>
</div>
<?php echo $content_lower; ?>
<?php echo $footer; ?>