<div class="ui grid">
    <div class="sixteen wide column">
        <div class="ui segments">
            <div class="ui segment">
                <h3 class="ui header">Total Salary Payments for <?php echo  $taken_full;?> </h3>
            </div>
            <div class="ui segment">
                <table class="ui celled table">
                    <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Basic Salary</th>
                        <th>Additional Salary</th>
                        <th>ETF</th>
                        <th>EPF</th>
                        <th>Advances</th>
                        <th>Cut-offs</th>
                        <th>Total Paid</th>
                    </tr>
                    </thead>

                    <?php  $final=0;foreach($clients as $c){
                        ?>
                        <tr>
                            <td><?php echo $c['User_ID']; ?></td>
                            <td><?php echo 'Rs. '.$basic.'.00/='; ?></td>
                            <td><?php echo 'Rs. '.$c['Normal_Salary'].'.00/='; ?></td>
                            <td><?php echo 'Rs. '.$c['Amount_ETF'].'.00/='; ?></td>
                            <td><?php echo 'Rs. '.$c['Amount_EPF'].'.00/='; ?></td>
                            <td><?php echo 'Rs. '.$c['Amount_advances'].'.00/='; ?></td>
                            <td><?php echo 'Rs. '.$c['Other_cutoffs'].'.00/='; ?></td>
                            <td><?php echo 'Rs. '.($basic+$c['Normal_Salary']+$c['Amount_advances']-$c['Amount_ETF']-$c['Amount_EPF']).'.00/='; $final+=($basic+$c['Normal_Salary']+$c['Amount_advances']-$c['Amount_ETF']-$c['Amount_EPF']); ?></td>


                        </tr>
                    <?php } ?>

                </table>
            </div>

            <div class="ui segment">
                <div class="ui green mini horizontal statistic">
                    <div class="value">
                        <?php echo 'Rs. '.$final.'.00/=';?>
                    </div>
                    <div class="teal label">
                        Total Payment
                    </div>
                </div>
            </div>
            <div class="ui segment">
                <?php for($i=1; $i<$pages+1; $i++) {  ?>
                    <a class="ui <?=$i==$page? 'teal':''?> label" href="<?=base_url('client/'.$i); ?>">
                        <?php echo $i;?>
                    </a>
                <?php } ?>
            </div>


        </div>
    </div>
</div>