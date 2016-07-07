<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Dashboard :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body>
    <?php echo $headerView; ?>
    <main>
        <div class="container-fluid">
            <h1 class="text-center">Dashboard</h1>
            <hr>
            <div class="row">
                <div class="col-sm-2 col-xs-0"></div>
                <div class="col-sm-10 col-xs-12">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Legend</th>
                                <th>OverAll</th>
                                <th>Andheri</th>
                                <th>Bandra</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if(isset($avgChecks))
                                {
                                    echo '<pre>';
                                    var_dump($avgChecks,$totalMugs['mugCount']);
                                    ?>
                                    <tr>
                                        <td>Avg Check-ins</td>
                                        <td>
                                            <?php
                                                $allStores = ((int)$avgChecks['checkInList']['overall']/(int)$totalMugs['mugCount']);
                                                echo round($allStores,1);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $andheriStore = ((int)$avgChecks['checkInList']['andheri']/(int)$totalMugs['mugCount']);
                                            echo round($andheriStore,1);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $bandraStore = ((int)$avgChecks['checkInList']['bandra']/(int)$totalMugs['mugCount']);
                                            echo round($bandraStore,1);
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                if(isset($Regulars))
                                {
                                    ?>
                                    <tr>
                                        <td>Regulars</td>
                                        <td>
                                            <?php
                                            $allStores = ((int)$Regulars['regularCheckins']['overall']/(int)$totalMugs['mugCount'])*100;
                                            echo round($allStores,1);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $andheriStore = ((int)$Regulars['regularCheckins']['andheri']/(int)$totalMugs['mugCount'])*100;
                                            echo round($andheriStore,1);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $bandraStore = ((int)$Regulars['regularCheckins']['bandra']/(int)$totalMugs['mugCount'])*100;
                                            echo round($bandraStore,1);
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                if(isset($Irregulars))
                                {
                                    ?>
                                    <tr>
                                        <td>IrRegulars</td>
                                        <td>
                                            <?php
                                            $allStores = ((int)$Irregulars['irregularCheckins']['overall']/(int)$totalMugs['mugCount'])*100;
                                            echo round($allStores,1);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $andheriStore = ((int)$Irregulars['irregularCheckins']['andheri']/(int)$totalMugs['mugCount'])*100;
                                            echo round($andheriStore,1);
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $bandraStore = ((int)$Irregulars['irregularCheckins']['bandra']/(int)$totalMugs['mugCount'])*100;
                                            echo round($bandraStore,1);
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-2 col-xs-0"></div>
            </div>
        </div>
    </main>
    <?php echo $footerView; ?>
</body>
<?php echo $globalJs; ?>
</html>