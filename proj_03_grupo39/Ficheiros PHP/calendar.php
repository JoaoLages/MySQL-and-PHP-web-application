
<select name="year">
  <option value="">Year</option>
  <?php for ($year = date('Y'); $year < date('Y')+5; $year++) { ?>
        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
        <?php } ?>
</select>
<select name="month">
        <option value="">Month</option>
        <?php for ($month = 1; $month <= 12; $month++) { ?>
        <option value="<?php echo strlen($month)==1 ? '0'.$month : $month; ?>"><?php echo strle$
        <?php } ?>
</select>
<select name="day">
  <option value="">Day</option>
        <?php for ($day = 1; $day <= 31; $day++) { ?>
        <option value="<?php echo strlen($day)==1 ? '0'.$day : $day; ?>"><?php echo strlen($day$
        <?php } ?>
</select>


