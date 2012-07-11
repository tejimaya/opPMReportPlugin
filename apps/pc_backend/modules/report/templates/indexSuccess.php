<h2>月別PMレポート</h2>
<h3>月別PMレポート</h3>
<table>
  <tr>
    <th>月</th>
<?php foreach ($months as $month): ?>
    <th><?php echo $month ?></th>
<?php endforeach ?>
  </tr>
<?php foreach ($captions as $caption): ?>
  <tr>
    <td><?php echo __($caption) ?></td>
  <?php foreach ($monthly[$caption] as $day => $count): ?>
    <td><?php echo $count ?></td>
  <?php endforeach ?>
  </tr>
<?php endforeach ?>
</table>

<h2>日別PMレポート</h2>
<h3><?php echo date('Y年m月', strtotime('-1 month')) ?></h3>
<table>
  <tr>
    <th>日</th>
<?php foreach ($lastDates as $date): ?>
    <th><?php echo substr($date, 8, 2)?> </th>
<?php endforeach ?>
  </tr>
<?php foreach ($lastDaily as $type => $data): ?>
  <tr>
    <td><? echo __($type); ?></td>
    <?php foreach ($data as $count): ?>
    <td><?php echo $count ?></td>
    <?php endforeach ?>
  </tr>
<?php endforeach ?>
</table>

</table>
<h3><?php echo date('Y年m月') ?></h3>
<table>
  <tr>
    <th>日</th>
<?php foreach ($nowDates as $date): ?>
    <th><?php echo substr($date, 8, 2)?> </th>
<?php endforeach ?>
  </tr>
<?php foreach ($nowDaily as $type => $data): ?>
  <tr>
    <td><?php echo __($type); ?></td>
    <?php foreach ($data as $count): ?>
    <td><?php echo $count ?></td>
    <?php endforeach ?>
  </tr>
<?php endforeach ?>
</table>
