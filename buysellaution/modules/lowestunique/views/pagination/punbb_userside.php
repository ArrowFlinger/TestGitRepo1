<?php
/*
	First Previous 1 2 3 ... 22 23 24 25 26 [27] 28 29 30 31 32 ... 48 49 50 Next Last
*/
// Number of page links in the begin and end of whole range
$count_out = ( ! empty($config['count_out'])) ? (int) $config['count_out'] : 1;
// Number of page links on each side of current page
$count_in = ( ! empty($config['count_in'])) ? (int) $config['count_in'] : 1;

// Beginning group of pages: $n1...$n2
$n1 = 1;
$n2 = min($count_out, $total_pages);

// Ending group of pages: $n7...$n8
$n7 = max(1, $total_pages - $count_out + 1);
$n8 = $total_pages;

// Middle group of pages: $n4...$n5
$n4 = max($n2 + 1, $current_page - $count_in);
$n5 = min($n7 - 1, $current_page + $count_in);
$use_middle = ($n5 >= $n4);

// Point $n3 between $n2 and $n4
$n3 = (int) (($n2 + $n4) / 2);
$use_n3 = ($use_middle && (($n4 - $n2) > 1));

// Point $n6 between $n5 and $n7
$n6 = (int) (($n5 + $n7) / 2);
$use_n6 = ($use_middle && (($n7 - $n5) > 1));

// Links to display as array(page => content)
$links = array();

// Generate links data in accordance with calculated numbers
for ($i = $n1; $i <= $n2; $i++)
{
	$links[$i] = $i;
}
if ($use_n3)
{
	$links[$n3] = '&hellip;';
}
for ($i = $n4; $i <= $n5; $i++)
{
	$links[$i] = $i;
}
if ($use_n6)
{
	$links[$n6] = '&hellip;';
}
for ($i = $n7; $i <= $n8; $i++)
{
	$links[$i] = $i;
}

?>
<div class="pagination_outer fl clr mt10">
<div class="pagination_content  mt10"> 
    <!--Pagination START-->
    <div class="pagination_in   mt10 mr5 clearfix"> 
            <ul class="fr">
        
            <?php if ($first_page !== FALSE): ?>
                <li class="fl">
                    <span class="page_lft fl">&nbsp;</span>
                    <div class="page_mid fl"> <a href="<?php echo HTML::chars($page->url($first_page)) ?>" rel="first"><strong><?php echo __('First') ?></strong></a></div>
                    <span class="page_rgt fl">&nbsp;</span>
                </li>
            <?php else: ?>
                <li class="fl">
                    <span class="page_lft fl">&nbsp;</span>
                    <div class="page_mid fl"><strong><?php echo __('First') ?></strong></div>
                    <span class="page_rgt fl">&nbsp;</span>
                 </li>
            <?php endif ?>
        
            <?php if ($previous_page !== FALSE): ?>
                <li class="fl">
                      <span class="page_lft fl">&nbsp;</span>
                <div class="page_mid fl"><a href="<?php echo HTML::chars($page->url($previous_page)) ?>" rel="last" title="Previous"><img src="<?php echo IMGPATH;?>page_arrow.png" alt="next" /></a> </div>
                    <span class="page_rgt fl">&nbsp;</span>
                </li>
            <?php else: ?>
               <li class="fl">
                    <span class="page_lft fl">&nbsp;</span>
                    <div class="page_mid fl"><img src="<?php echo IMGPATH;?>page_arrow.png" title="Previous" /></div>
                    <span class="page_rgt fl">&nbsp;</span>
               </li>
            <?php endif ?>
        
            <?php foreach ($links as $number => $content): ?>
        
                <li class="fl">
                <?php if ($number === $current_page): ?>
                    <span class="page_lft fl">&nbsp;</span>
                    <div class="page_mid fl"><strong><?php echo $content ?></strong></div>
                    <span class="page_rgt fl">&nbsp;</span>
                <?php else: ?>
                    <span class="page_lft fl">&nbsp;</span>
                    <div class="page_mid fl"><a href="<?php echo HTML::chars($page->url($number)) ?>"><?php echo $content ?></a></div>
                    <span class="page_rgt fl">&nbsp;</span>
                <?php endif ?>
                </li>
            <?php endforeach ?>
        
            <?php if ($next_page !== FALSE): ?>
            <span class="page_lft fl">&nbsp;</span>
                    <div class="page_mid fl"><a href="<?php echo HTML::chars($page->url($next_page)) ?>" rel="next" title="Next" ><img src="<?php echo IMGPATH;?>page_arrow1.png" alt="next" /></a> </div>
                    <span class="page_rgt fl">&nbsp;</span>
            <?php else: ?>
            <span class="page_lft fl">&nbsp;</span>
                <div class="page_mid fl"><img src="<?php echo IMGPATH;?>page_arrow1.png" alt="Next" /></div>
                    <span class="page_rgt fl">&nbsp;</span>
            <?php endif ?>
        
            <?php if ($last_page !== FALSE): ?>
            <span class="page_lft fl">&nbsp;</span>
                <div class="page_mid fl"><a href="<?php echo HTML::chars($page->url($last_page)) ?> " rel="last" title="Last"><strong><?php echo __('Last') ?></strong></a> </div>
                    <span class="page_rgt fl">&nbsp;</span>
            <?php else: ?>
            <span class="page_lft fl">&nbsp;</span>
                <div class="page_mid fl"><strong><?php echo __('Last') ?></strong> </div>
                    <span class="page_rgt fl">&nbsp;</span>
            <?php endif ?>
        
        
        </ul>
    </div>
    <!--Pagination END-->
	<!-- Result Count START-->    
	<div class="pagination_in  mt5 mr10"> 
	    <p class="list_count" style="text-align:right;"><small><?php echo __('Displayed :start-:end of :total', array(':start' => $current_first_item, ':end' => $current_last_item, ':total' => $total_items))?></small></p>
    </div>

</div>
</div>
<!--</p> .pagination -->
