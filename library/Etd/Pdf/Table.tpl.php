<table border="1" cellpadding="3">
  <tr>
    <?php foreach ($headers as $header): ?>
    <th bgcolor="#bbb"><b><?php echo $header ?></b></th>
    <?php endforeach ?>
  </tr>
  <?php $i = 0 ?>
  <?php foreach ($data as $row): $odd = ++$i % 2 ? '' : ' bgcolor="#ddd"' ?>
  <tr>
    <?php foreach ($row as $field): ?>
    <td<?php echo $odd ?>><?php echo nl2br($field) ?></td>
    <?php endforeach ?>
  </tr>
  <?php endforeach ?>
</table>