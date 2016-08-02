<?php
//header("Content-type:text/xml; charset=UTF-8");              
header("Cache-Control: no-store, no-cache, must-revalidate");             
header("Cache-Control: post-check=0, pre-check=0", false);   
echo '<?xml version="1.0" encoding="utf-8"?>';
?>

<info>
	<office_code><?php echo base64_encode('xmlok');?></office_code>
	<bookobec>
			<item>
				<ms_id><?php echo base64_encode('1');?></ms_id>
				<book_no><?php echo base64_encode('1234');?></book_no>
				<ref_id><?php echo base64_encode('99991375841829');?></ref_id>
				<level><?php echo base64_encode('1');?></level>
				<signdate><?php echo base64_encode('2013-08-07');?></signdate>
				<subject><?php echo base64_encode('ขอเชิญประชุม');?></subject>
				<send_date><?php echo base64_encode('2013-08-07 10:52:27');?></send_date>
			</item>
			<item>
				<ms_id><?php echo base64_encode('2');?></ms_id>
				<book_no><?php echo base64_encode('3456');?></book_no>
				<ref_id><?php echo base64_encode('999913758999');?></ref_id>
				<level><?php echo base64_encode('1');?></level>
				<signdate><?php echo base64_encode('2013-08-07');?></signdate>
				<subject><?php echo base64_encode('รายงานประจำปี');?></subject>
				<send_date><?php echo base64_encode('2013-08-07 10:52:27');?></send_date>
			</item>
	</bookobec>
</info>
