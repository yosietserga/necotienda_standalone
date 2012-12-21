<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<div class="box">
  <div class="left"></div>
  <div class="right"></div>
  <div class="heading">
    <h1 style="background-image: url('image/user.png');"><?php echo $heading_title; ?></h1>
    <div class="buttons"><a  onclick="$('#form').submit();" class="button"><span><?php echo $button_save; ?></span></a><a  onclick="location = '<?php echo $cancel; ?>';" class="button"><span><?php echo $button_cancel; ?></span></a></div>
  </div>
  <div class="content">
    <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_username; ?><a title="Ingrese el nombre de usuario. Le recomendamos que adopte una nomenclatura, por ejemplo utilice siempre el formato nombre.apellido para los nombre de usuarios"> (?)</a></td>
          <td><input  type="text" name="username" value="<?php echo $username; ?>">
            <?php if ($error_username) { ?>
            <span class="error"><?php echo $error_username; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_firstname; ?><a title="Ingrese los nombres del usuario"> (?)</a></td>
          <td><input  type="text" name="firstname" value="<?php echo $firstname; ?>">
            <?php if ($error_firstname) { ?>
            <span class="error"><?php echo $error_firstname; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_lastname; ?><a title="Ingrese los apellidos del usuario"> (?)</a></td>
          <td><input  type="text" name="lastname" value="<?php echo $lastname; ?>">
            <?php if ($error_lastname) { ?>
            <span class="error"><?php echo $error_lastname; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_email; ?><a title="Ingrese el email del usuario"> (?)</a></td>
          <td><input  type="text" name="email" value="<?php echo $email; ?>"></td>
        </tr>
        <tr>
          <td><?php echo $entry_user_group; ?><a title="Seleccione el grupo de usuario. Puede crear los grupos con diferentes niveles de acceso en la opci&oacute;n Grupo de Usuarios de la pesta&ntilde;a Sistema"> (?)</a></td>
          <td><select name="user_group_id">
              <?php foreach ($user_groups as $user_group) { ?>
              <?php if ($user_group['user_group_id'] == $user_group_id) { ?>
              <option value="<?php echo $user_group['user_group_id']; ?>" selected="selected"><?php echo $user_group['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $user_group['user_group_id']; ?>"><?php echo $user_group['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
        </tr>
        <tr>
          <td><?php echo $entry_password; ?><a title="Ingrese una contrase&ntilde;a que empiece con letra, tenga una longitud m&iacute;nima de 6 caracteres, contenga al menos 1 may&uacute;scula,  1 min&uacute;scula,  1 n&uacute;mero y 1 caracter especial. Le recomendamos que no utilice fechas personales ni familiares, tampoco utilice iniciales de su nombre o familiares"> (?)</a></td>
          <td><input  type="password" name="password" value="<?php echo $password; ?>">
            <?php if ($error_password) { ?>
            <span class="error"><?php echo $error_password; ?></span>
            <?php  } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_confirm; ?><a title="Vuelva a escribir la contrase&ntilde;a"> (?)</a></td>
          <td><input  type="password" name="confirm" value="<?php echo $confirm; ?>">
            <?php if ($error_confirm) { ?>
            <span class="error"><?php echo $error_confirm; ?></span>
            <?php  } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_status; ?><a title="Seleccione el estado del usuario"> (?)</a></td>
          <td><select name="status">
              <?php if ($status) { ?>
              <option value="0"><?php echo $text_disabled; ?></option>
              <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
              <?php } else { ?>
              <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
              <option value="1"><?php echo $text_enabled; ?></option>
              <?php } ?>
            </select></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php echo $footer; ?>