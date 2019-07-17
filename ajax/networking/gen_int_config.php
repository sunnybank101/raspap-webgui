<?php
session_start();
include_once('../../includes/config.php');
include_once('../../includes/functions.php');

if(isset($_POST['generate']) && isset($_POST['csrf_token']) && CSRFValidate()) {
    $cnfNetworking = array_diff(scandir(RASPI_CONFIG_NETWORKING, SCANDIR_SORT_ASCENDING),array('..','.'));
    $cnfNetworking = array_combine($cnfNetworking,$cnfNetworking);
    $strConfFile = "";
    foreach($cnfNetworking as $index=>$file) {
		
		if($index != "defaults") {
			if(substr($index,-4) === ".ini") { // only process ini files
				$cnfFile = parse_ini_file(RASPI_CONFIG_NETWORKING.'/'.$file);
				if($cnfFile['static'] === '1') { // true is '1' once loaded
					$strConfFile .= "\n#STATIC configured for [".$cnfFile['interface']."]\n\n";
					$strConfFile .= "interface ".$cnfFile['interface']."\n";
					$strConfFile .= "static ip_address=".$cnfFile['ip_address']."\n";
					$strConfFile .= "static routers=".$cnfFile['routers']."\n";
					$strConfFile .= "static domain_name_servers=".$cnfFile['domain_name_server']."\n";
				} elseif($cnfFile['static'] === '0' && $cnfFile['failover'] === '1') { // true is '1' once loaded
					$strConfFile .= "\n#STATIC FAILOVER configured for ".$cnfFile['interface']."\n\n";
					$strConfFile .= "profile static_".$cnfFile['interface']."\n";
					$strConfFile .= "static ip_address=".$cnfFile['ip_address']."\n";
					$strConfFile .= "static routers=".$cnfFile['routers']."\n";
					$strConfFile .= "static domain_name_servers=".$cnfFile['domain_name_server']."\n\n";
					$strConfFile .= "interface ".$cnfFile['interface']."\n";
					$strConfFile .= "fallback static_".$cnfFile['interface']."\n\n";
				} else {
					$strConfFile .= "\n#DHCP configured for [".$cnfFile['interface']."]\n\n";
				}
			}
		} else {
			$strConfFile .= file_get_contents(RASPI_CONFIG_NETWORKING.'/'.$index)."\n\n";
		}
		
    }

    if(file_put_contents(RASPI_CONFIG_NETWORKING.'/dhcpcd.conf',$strConfFile)) {
        exec('sudo /bin/cp /etc/raspap/networking/dhcpcd.conf /etc/dhcpcd.conf');
        $output = ['return'=>0,'output'=>'Settings successfully applied'];
    } else {
        $output = ['return'=>2,'output'=>'Unable to write to apply settings'];
    }
    echo json_encode($output);
}

?>
