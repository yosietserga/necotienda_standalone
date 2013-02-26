<?php echo $header; ?>
<?php echo $navigation; ?>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
<div class="grid_10" id="content">
  <h1><?php echo $heading_title; ?></h1>
  <div class="middle">
    <table>
      <tr>
        <td style="width: 50%;"><?php echo $category; ?></td>
        <td style="width: 50%;"><ul>
            <li><a title="<?php echo $text_special; ?>" href="<?php echo str_replace('&', '&amp;', $special); ?>"><?php echo $text_special; ?></a></li>
            <li><a title="<?php echo $text_account; ?>" href="<?php echo str_replace('&', '&amp;', $account); ?>"><?php echo $text_account; ?></a>
              <ul>
                <li><a title="<?php echo $text_edit; ?>" href="<?php echo str_replace('&', '&amp;', $edit); ?>"><?php echo $text_edit; ?></a></li>
                <li><a title="<?php echo $text_password; ?>" href="<?php echo str_replace('&', '&amp;', $password); ?>"><?php echo $text_password; ?></a></li>
                <li><a title="<?php echo $text_address; ?>" href="<?php echo str_replace('&', '&amp;', $address); ?>"><?php echo $text_address; ?></a></li>
                <li><a title="<?php echo $text_history; ?>" href="<?php echo str_replace('&', '&amp;', $history); ?>"><?php echo $text_history; ?></a></li>
                <li><a title="<?php echo $text_download; ?>" href="<?php echo str_replace('&', '&amp;', $download); ?>"><?php echo $text_download; ?></a></li>
              </ul>
            </li>
            <li><a title="<?php echo $text_cart; ?>" href="<?php echo str_replace('&', '&amp;', $cart); ?>"><?php echo $text_cart; ?></a></li>
            <li><a title="<?php echo $text_checkout; ?>" href="<?php echo str_replace('&', '&amp;', $checkout); ?>"><?php echo $text_checkout; ?></a></li>
            <li><a title="<?php echo $text_search; ?>" href="<?php echo str_replace('&', '&amp;', $search); ?>"><?php echo $text_search; ?></a></li>
            <li><?php echo $text_information; ?>
              <ul>
                <?php foreach ($informations as $information) { ?>
                <li><a title="<?php echo $information['title']; ?>" href="<?php echo str_replace('&', '&amp;', $information['href']); ?>"><?php echo $information['title']; ?></a></li>
                <?php } ?>
                <li><a title="<?php echo $text_contact; ?>" href="<?php echo str_replace('&', '&amp;', $contact); ?>"><?php echo $text_contact; ?></a></li>
              </ul>
            </li>
          </ul></td>
      </tr>
    </table>
  </div>
</div>
<?php echo $footer; ?> 