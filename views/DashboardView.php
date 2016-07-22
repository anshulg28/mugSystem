<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Dashboard :: Doolally</title>
	<?php echo $globalStyle; ?>
</head>
<body class="dashboard">
    <?php echo $headerView; ?>
    <!-- No header, and the drawer stays open on larger screens (fixed drawer). -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer">
        <div class="mdl-layout__drawer">
            <span class="mdl-layout-title">Dashboard</span>
            <ul class="nav nav-pills nav-stacked">
                <li class="active"><a data-toggle="pill" class="my-noBorderRadius" href="#mugclub">Mug Club</a></li>
                <li><a class="my-noBorderRadius" data-toggle="pill" href="#instamojo">Instamojo</a></li>
                <li><a class="my-noBorderRadius" data-toggle="pill" href="#feedback">Feedback</a></li>
            </ul>
            <!--<div class="mdl-layout__tab-bar mdl-js-ripple-effect">
                <a href="#mugclub" class="mdl-layout__tab">Mug Club</a><br>
                <a href="#instamojo" class="mdl-layout__tab is-active">Instamojo</a>
                <a class="mdl-navigation__link" href="#">Mug Club</a>
            </div>-->
        </div>
        <main class="mdl-layout__content tab-content">
            <section class="tab-pane fade in active" id="mugclub">
                <div class="page-content">
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--1-col"></div>
                        <div class="mdl-cell mdl-cell--10-col text-center">
                            <form action="<?php echo base_url();?>dashboard/custom" method="post" id="customDateForm">
                                <ul class="list-inline">
                                    <li>
                                        <label for="location">Location</label>
                                        <?php
                                        if($this->userType == ADMIN_USER)
                                        {
                                            ?>
                                            <select id="location" onchange="refreshBars(this)" class="form-control">
                                                <option value="0">Overall</option>
                                                <?php
                                                if(isset($locations))
                                                {
                                                    foreach($locations as $key => $row)
                                                    {
                                                        if(isset($row['id']))
                                                        {
                                                            ?>
                                                            <option value="<?php echo $row['id'];?>"><?php echo $row['locName'];?></option>
                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <?php
                                        }
                                        elseif($this->userType == EXECUTIVE_USER)
                                        {
                                            if(isset($userInfo))
                                            {
                                                ?>
                                                <select id="location" onchange="refreshBars(this)" class="form-control">
                                                    <?php
                                                    foreach($userInfo as $key => $row)
                                                    {
                                                        ?>
                                                        <option value="<?php echo $row['locData'][0]['id'];?>">
                                                            <?php echo $row['locData'][0]['locName'];?>
                                                        </option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <?php
                                            }
                                            ?>

                                            <?php
                                        }
                                        ?>

                                    </li>
                                    <li>
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-filter">
                                            <input class="mdl-textfield__input" type="date" name="startDate" id="startDate" placeholder="">
                                            <label class="mdl-textfield__label" for="startDate">Start Date</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label custom-filter">
                                            <input class="mdl-textfield__input" type="date" name="endDate" id="endDate" placeholder="">
                                            <label class="mdl-textfield__label" for="endDate">End Date</label>
                                        </div>
                                    </li>
                                    <li>
                                        <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                                            Apply
                                        </button>
                                    </li>
                                </ul>
                            </form>
                        </div>
                        <div class="mdl-cell mdl-cell--1-col">

                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div class="mdl-color--white mdl-shadow--2dp mdl-cell mdl-cell--12-col mdl-grid">
                            <div id="totalCheckins-container" class="barContainers">
                                <h6 class="text-primary text-center my-marginTopBottom">Total Check-Ins</h6>
                            </div>
                            <div id="avgCheckins-container" class="barContainers">
                                <h6 class="text-primary text-center my-marginTopBottom">Avg Check-Ins</h6>
                            </div>
                            <div id="regulars-container" class="barContainers">
                                <h6 class="text-primary text-center my-marginTopBottom">Regulars</h6>
                            </div>
                            <div id="irregulars-container" class="barContainers">
                                <h6 class="text-primary text-center my-marginTopBottom">Irregulars</h6>
                            </div>
                            <div id="lapsers-container" class="barContainers">
                                <h6 class="text-primary text-center my-marginTopBottom">Lapsers</h6>
                            </div>
                        </div>
                    </div>
                    <div class="mdl-color--white mdl-shadow--2dp">
                        <div class="col-sm-8 col-xs-12">
                            <ul class="list-inline">
                                <li>
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="avg-radio">
                                        <input type="radio" id="avg-radio" class="mdl-radio__button" name="dashboardStats" value="1" checked>
                                        <span class="mdl-radio__label">Avg Check-Ins</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="regular-radio">
                                        <input type="radio" id="regular-radio" class="mdl-radio__button" name="dashboardStats" value="2">
                                        <span class="mdl-radio__label">Regulars</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="irregulars-radio">
                                        <input type="radio" id="irregulars-radio" class="mdl-radio__button" name="dashboardStats" value="3">
                                        <span class="mdl-radio__label">Irregulars</span>
                                    </label>
                                </li>
                                <li>
                                    <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="lapsers-radio">
                                        <input type="radio" id="lapsers-radio" class="mdl-radio__button" name="dashboardStats" value="4">
                                        <span class="mdl-radio__label">Lapsers</span>
                                    </label>
                                </li>
                            </ul>
                            <canvas id="avgChecks-canvas" class="mygraphs"></canvas>
                            <canvas id="regulars-canvas" class="mygraphs"></canvas>
                            <canvas id="irregulars-canvas" class="mygraphs"></canvas>
                            <canvas id="lapsers-canvas" class="mygraphs"></canvas>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <table class="mdl-data-table mdl-js-data-table">
                                <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric">Legend</th>
                                    <th class="mdl-data-table__cell--non-numeric overall-th">OverAll</th>
                                    <th class="mdl-data-table__cell--non-numeric andheri-th">Andheri</th>
                                    <th class="mdl-data-table__cell--non-numeric bandra-th">Bandra</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(isset($avgChecks))
                                {
                                    ?>
                                    <tr>
                                        <td>Avg Check-ins</td>
                                        <td class="overall-td">
                                            <?php
                                            $allStores = ((int)$avgChecks['checkInList']['overall']/$totalMugs['overall']);
                                            echo round($allStores,2);
                                            ?>
                                        </td>
                                        <td class="andheri-td">
                                            <?php
                                            $andheriStore = ((int)$avgChecks['checkInList']['andheri']/$totalMugs['andheri']);
                                            echo round($andheriStore,2);
                                            ?>
                                        </td>
                                        <td class="bandra-td">
                                            <?php
                                            $bandraStore = ((int)$avgChecks['checkInList']['bandra']/$totalMugs['bandra']);
                                            echo round($bandraStore,2);
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
                                        <td class="overall-td">
                                            <?php
                                            $allStores = ((int)$Regulars['regularCheckins']['overall']/$totalMugs['overall'])*100;
                                            echo round($allStores,1);
                                            ?>
                                        </td>
                                        <td class="andheri-td">
                                            <?php
                                            $andheriStore = ((int)$Regulars['regularCheckins']['andheri']/$totalMugs['andheri'])*100;
                                            echo round($andheriStore,1);
                                            ?>
                                        </td>
                                        <td class="bandra-td">
                                            <?php
                                            $bandraStore = ((int)$Regulars['regularCheckins']['bandra']/$totalMugs['bandra'])*100;
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
                                        <td class="overall-td">
                                            <?php
                                            $allStores = ((int)$Irregulars['irregularCheckins']['overall']/$totalMugs['overall'])*100;
                                            echo round($allStores,1);
                                            ?>
                                        </td>
                                        <td class="andheri-td">
                                            <?php
                                            $andheriStore = ((int)$Irregulars['irregularCheckins']['andheri']/$totalMugs['andheri'])*100;
                                            echo round($andheriStore,1);
                                            ?>
                                        </td>
                                        <td class="bandra-td">
                                            <?php
                                            $bandraStore = ((int)$Irregulars['irregularCheckins']['bandra']/$totalMugs['bandra'])*100;
                                            echo round($bandraStore,1);
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                if(isset($lapsers))
                                {
                                    ?>
                                    <tr>
                                        <td>Lapsers</td>
                                        <td class="overall-td">
                                            <?php
                                            $allStores = ((int)$lapsers['lapsers']['overall']/$totalMugs['overall'])*100;
                                            echo round($allStores,1);
                                            ?>
                                        </td>
                                        <td class="andheri-td">
                                            <?php
                                            $andheriStore = ((int)$lapsers['lapsers']['andheri']/$totalMugs['andheri'])*100;
                                            echo round($andheriStore,1);
                                            ?>
                                        </td>
                                        <td class="bandra-td">
                                            <?php
                                            $bandraStore = ((int)$lapsers['lapsers']['bandra']/$totalMugs['bandra'])*100;
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
                    </div>
                </div>
            </section>
            <section class="tab-pane fade" id="instamojo">
                <div class="mdl-grid">
                    <?php
                        if(isset($instamojo))
                        {
                            if($instamojo['status'] === true)
                            {
                                foreach($instamojo['instaRecords'] as $key => $row)
                                {
                                    ?>
                                    <div class="mdl-cell mdl-cell--4-col my-instaCard" data-id="<?php echo $row['id'];?>">
                                        <div class="demo-card-square mdl-card mdl-shadow--2dp">
                                            <div class="mdl-card__title mdl-card--expand">
                                                <h2 class="mdl-card__title-text">
                                                    <i class="fa fa-beer fa-2x"></i>
                                                    <span class="mugTitle">Mug #<?php echo $row['mugId'];?></span>
                                                </h2>
                                            </div>
                                            <div class="mdl-card__supporting-text">
                                                <h4 class="my-NoMargin"><?php echo $row['buyerName'];?></h4>
                                                <?php echo $row['buyerEmail'];?><br>
                                                Rs. <?php echo $row['price'];?>
                                            </div>
                                            <div class="mdl-card__actions mdl-card--border">
                                                <a class="confirm-btn mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect my-noUnderline"
                                                onclick="changeCurrent(this)" data-id="<?php echo $row['id'];?>"
                                                data-paymentId="<?php echo $row['paymentId'];?>"
                                                data-email="<?php echo $row['buyerEmail'];?>"
                                                data-mugId="<?php echo $row['mugId'];?>">
                                                    Confirm
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                    <div class="mdl-cell mdl-cell--12-col">
                                        No Purchases Found!
                                    </div>
                                <?php
                            }
                        }
                    ?>
                </div>
                <dialog class="mdl-dialog">
                    <input type="hidden" id="selectedMug"/>
                    <input type="hidden" id="mugPaymentId"/>
                    <input type="hidden" id="mugNum"/>
                    <input type="hidden" id="mugEmail"/>
                    <h4 class="mdl-dialog__title">Confirm Upgrade?</h4>
                    <div class="mdl-dialog__content">
                        <p>
                            Extending Membership by 12 months
                        </p>
                    </div>
                    <div class="mdl-dialog__actions">
                        <button type="button" class="mdl-button agree_btn">Agree</button>
                        <button type="button" class="mdl-button close">Cancel</button>
                    </div>
                </dialog>
            </section>
            <section class="tab-pane fade" id="feedback">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--1-col"></div>
                    <div class="mdl-cell mdl-cell--10-col text-center">
                        <ul class="list-inline">
                            <li>
                                <label for="feedbackLoc">Location</label>
                                <?php
                                if($this->userType == ADMIN_USER)
                                {
                                    ?>
                                    <select id="feedbackLoc" class="form-control">
                                        <?php
                                        if(isset($locations))
                                        {
                                            foreach($locations as $key => $row)
                                            {
                                                if(isset($row['id']))
                                                {
                                                    ?>
                                                    <option value="<?php echo $row['id'];?>"><?php echo $row['locName'];?></option>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                    <?php
                                }
                                elseif($this->userType == EXECUTIVE_USER)
                                {
                                    if(isset($userInfo))
                                    {
                                        ?>
                                        <select id="feedbackLoc" class="form-control">
                                            <?php
                                            foreach($userInfo as $key => $row)
                                            {
                                                ?>
                                                <option value="<?php echo $row['locData'][0]['id'];?>">
                                                    <?php echo $row['locData'][0]['locName'];?>
                                                </option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                }
                                ?>

                            </li>
                            <li>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="number" id="feedbackNum">
                                    <label class="mdl-textfield__label" for="feedbackNum">Number (max:50)</label>
                                </div>
                            </li>
                            <li>
                                <button type="button" id="genBtn" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                                    Generate
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="mdl-cell mdl-cell--1-col"></div>
                    <!-- Dynamic Form -->
                    <div class="mdl-cell mdl-cell--12-col dynamic-form-wrapper">
                        <form action="<?php echo base_url().'dashboard/saveFeedback/json';?>" id="feedback-form" method="post">
                            <div class="form-super-container"></div>
                            <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent hide">Submit</button>
                        </form>
                    </div>
                </div>
            </section>

        </main>
    </div>

    <?php echo $footerView; ?>
</body>
<?php echo $globalJs; ?>
<script>
    var totalCheckins = {};
    var avgCheckins = {};
    var regulars = {};
    var irregulars = {};
    var lapsers = {};
    var graph_avg = {};
    var graph_regulars = {};
    var graph_irregulars = {};
    var graph_lapsers = {};
    var graph_labels = [];

    var totalChecksBar, avgChecksBar, regularsBar, irregularsBar,lapsersBar;
    //setting all values
    <?php
        if(isset($avgChecks))
        {
            for($i = 0;$i<count($avgChecks['checkInList']); $i++)
            {
                $mugkeys = array_keys($totalMugs);
                $checkinKeys = array_keys($avgChecks['checkInList']);
                $allStores = ((int)$avgChecks['checkInList'][$checkinKeys[$i]]/$totalMugs[$mugkeys[$i]]);
                ?>
                    totalCheckins[<?php echo $i;?>] = <?php echo (int)$avgChecks['checkInList'][$checkinKeys[$i]];?>;
                    avgCheckins[<?php echo $i;?>] = <?php echo round($allStores,2);?>;
                <?php
            }
        }
        if(isset($Regulars))
        {
            for($i = 0;$i<count($Regulars['regularCheckins']); $i++)
            {
                $mugkeys = array_keys($totalMugs);
                $checkinKeys = array_keys($Regulars['regularCheckins']);
                $allStores = ((int)$Regulars['regularCheckins'][$checkinKeys[$i]]/$totalMugs[$mugkeys[$i]]);
                ?>
                    regulars[<?php echo $i;?>] = <?php echo round($allStores,2);?>;
                <?php
            }
        }
        if(isset($Irregulars))
        {
            for($i = 0;$i<count($Irregulars['irregularCheckins']); $i++)
            {
                $mugkeys = array_keys($totalMugs);
                $checkinKeys = array_keys($Irregulars['irregularCheckins']);
                $allStores = ((int)$Irregulars['irregularCheckins'][$checkinKeys[$i]]/$totalMugs[$mugkeys[$i]]);
                ?>
                    irregulars[<?php echo $i;?>] = <?php echo round($allStores,2);?>;
                <?php
            }
        }
        if(isset($lapsers))
        {
            for($i = 0;$i<count($lapsers['lapsers']); $i++)
            {
                $mugkeys = array_keys($totalMugs);
                $checkinKeys = array_keys($lapsers['lapsers']);
                $allStores = ((int)$lapsers['lapsers'][$checkinKeys[$i]]/$totalMugs[$mugkeys[$i]]);
                ?>
                    lapsers[<?php echo $i;?>] = <?php echo round($allStores,2);?>;
                <?php
            }
        }

        //Graph points
        if(isset($graph['avgChecks']))
        {
            ?>
            graph_avg[0] = [];
            graph_avg[1] = [];
            graph_avg[2] = [];
            <?php
            for($i = 0;$i<count($graph['avgChecks']); $i++)
            {
                $graphVals = explode(',',$graph['avgChecks'][$i]);
                ?>
                graph_avg[0].push(<?php echo $graphVals[0];?>);
                graph_avg[1].push(<?php echo $graphVals[1];?>);
                graph_avg[2].push(<?php echo $graphVals[2];?>);
                <?php
            }
        }
        if(isset($graph['regulars']))
        {
            ?>
            graph_regulars[0] = [];
            graph_regulars[1] = [];
            graph_regulars[2] = [];
            <?php
            for($i = 0;$i<count($graph['regulars']); $i++)
            {
                $graphVals = explode(',',$graph['regulars'][$i]);
                ?>
                graph_regulars[0].push(<?php echo $graphVals[0];?>);
                graph_regulars[1].push(<?php echo $graphVals[1];?>);
                graph_regulars[2].push(<?php echo $graphVals[2];?>);
                <?php
            }
        }
        if(isset($graph['irregulars']))
        {
            ?>
            graph_irregulars[0] = [];
            graph_irregulars[1] = [];
            graph_irregulars[2] = [];
            <?php
            for($i = 0;$i<count($graph['irregulars']); $i++)
            {
                $graphVals = explode(',',$graph['irregulars'][$i]);
                ?>
                graph_irregulars[0].push(<?php echo $graphVals[0];?>);
                graph_irregulars[1].push(<?php echo $graphVals[1];?>);
                graph_irregulars[2].push(<?php echo $graphVals[2];?>);
                <?php
            }
        }
        if(isset($graph['lapsers']))
        {
            ?>
            graph_lapsers[0] = [];
            graph_lapsers[1] = [];
            graph_lapsers[2] = [];
            <?php
            for($i = 0;$i<count($graph['lapsers']); $i++)
            {
                $graphVals = explode(',',$graph['lapsers'][$i]);
                ?>
                graph_lapsers[0].push(<?php echo $graphVals[0];?>);
                graph_lapsers[1].push(<?php echo $graphVals[1];?>);
                graph_lapsers[2].push(<?php echo $graphVals[2];?>);
                <?php
            }
        }
        if(isset($graph['labelDate']))
        {
            for($i = 0;$i<count($graph['labelDate']); $i++)
            {
                ?>
                graph_labels.push('<?php echo $graph['labelDate'][$i];?>');
                <?php
            }
        }
    ?>


    $(window).load(function(){
        var selectedLoc = Number($('#location').val());

        //Total Checkins
        totalChecksBar = new ProgressBar.Circle('#totalCheckins-container', {
            strokeWidth: 6,
            easing: 'easeInOut',
            duration: 1000,
            color: '#ACEC00',
            trailWidth: 6,
            step: function(state, circle) {
                var value = circle.value().toFixed(2);
                if (value === 0) {
                    circle.setText('');
                } else {
                    circle.setText(value);
                }

            }
        });
        totalChecksBar.text.style.fontSize = '2em';
        totalChecksBar.animate(totalCheckins[selectedLoc]);

        //Average Checkins
        avgChecksBar = new ProgressBar.Circle('#avgCheckins-container', {
            strokeWidth: 6,
            easing: 'easeInOut',
            duration: 1000,
            color: '#ACEC00',
            trailWidth: 6,
            step: function(state, circle) {
                var value = circle.value().toFixed(2);
                if (value === 0) {
                    circle.setText('');
                } else {
                    circle.setText(value);
                }

            }
        });
        avgChecksBar.text.style.fontSize = '2em';
        avgChecksBar.animate(avgCheckins[selectedLoc]);  // Value from 0.0 to 1.0

        //Regulars
        regularsBar = new ProgressBar.Circle('#regulars-container', {
            strokeWidth: 6,
            easing: 'easeInOut',
            duration: 1000,
            color: '#00BBD6',
            trailWidth: 6,
            step: function(state, circle) {
                var value = Math.round(circle.value() * 100);
                if (value === 0) {
                    circle.setText('');
                } else {
                    circle.setText(value+'%');
                }

            }
        });
        regularsBar.text.style.fontSize = '2em';
        regularsBar.animate(regulars[selectedLoc]);  // Value from 0.0 to 1.0

        //Irregulars
        irregularsBar = new ProgressBar.Circle('#irregulars-container', {
            strokeWidth: 6,
            easing: 'easeInOut',
            duration: 1000,
            color: '#BA65C9',
            trailWidth: 6,
            step: function(state, circle) {
                var value = Math.round(circle.value() * 100);
                if (value === 0) {
                    circle.setText('');
                } else {
                    circle.setText(value+'%');
                }

            }
        });
        irregularsBar.text.style.fontSize = '2em';
        irregularsBar.animate(irregulars[selectedLoc]);  // Value from 0.0 to 1.0

        //Lapsers
        lapsersBar = new ProgressBar.Circle('#lapsers-container', {
            strokeWidth: 6,
            easing: 'easeInOut',
            duration: 1000,
            color: '#EF3C79',
            trailWidth: 6,
            step: function(state, circle) {
                var value = Math.round(circle.value() * 100);
                if (value === 0) {
                    circle.setText('');
                } else {
                    circle.setText(value+'%');
                }

            }
        });
        lapsersBar.text.style.fontSize = '2em';
        lapsersBar.animate(lapsers[selectedLoc]);  // Value from 0.0 to 1.0

        <?php
            if($this->userType == ADMIN_USER)
            {
                ?>
                    setTimeout(saveDashBoardRecord(),5000);
                <?php
            }
        ?>
    });
    function joinObjectArray(AssocArray)
    {
        var s = '';
        for (var i in AssocArray) {
            s += AssocArray[i] + ", ";
        }
        return s.substring(0, s.length-2);
    }
    function saveDashBoardRecord()
    {
        var postData = {
            'avgCheckins': joinObjectArray(avgCheckins),
            'regulars': joinObjectArray(regulars),
            'irregulars': joinObjectArray(irregulars),
            'lapsers': joinObjectArray(lapsers),
            'insertedDate': $('#endDate').val()
        };

        $.ajax({
            type:"POST",
            dataType:"json",
            data: postData,
            url:'<?php echo base_url();?>dashboard/save',
            success: function(data)
            {

            },
            error: function(){

            }
        });
    }

    function refreshBars(ele)
    {
        var selectedLoc = Number($(ele).val());
        totalChecksBar.animate(totalCheckins[selectedLoc]);
        avgChecksBar.animate(avgCheckins[selectedLoc]);
        regularsBar.animate(regulars[selectedLoc]);
        irregularsBar.animate(irregulars[selectedLoc]);
        lapsersBar.animate(lapsers[selectedLoc]);
        refreshGraphs();
    }
    $(document).ready(function(){
        var thArray = ['overall-th','bandra-th','andheri-th'];
        var tdArray = ['overall-td','bandra-td','andheri-td'];
        for(var i=0;i<thArray.length;i++)
        {
            $('.'+thArray[i]).addClass('hide');
            $('.'+tdArray[i]).addClass('hide');
        }
        $('#location option').each(function(i,val){
            var index = Number($(val).attr('value'));
            $('.'+thArray[index]).removeClass('hide');
            $('.'+tdArray[index]).removeClass('hide');
        });
        drawGraphs();
    });

    $(document).on('submit', '#customDateForm', function(e){

        e.preventDefault();
        if($('input[name="startDate"]').val() == '')
        {
            $('input[name="startDate"]').focus();
            return false;
        }
        if($('input[name="endDate"]').val() == '')
        {
            $('input[name="endDate"]').focus();
            return false;
        }
        showCustomLoader();
        $.ajax({
            type:'POST',
            dataType:'json',
            url:$(this).attr('action'),
            data: $(this).serialize(),
            success: function(data)
            {
                hideCustomLoader();
                var checkinKeys,mugKeys,calcValue,i;
                mugKeys = Object.keys(data.totalMugs);
                if(typeof data.avgChecks != 'undefined')
                {
                    checkinKeys = Object.keys(data.avgChecks.checkInList);
                    for(i=0;i<Object.keys(data.avgChecks.checkInList).length;i++)
                    {
                        calcValue = Number(data.avgChecks.checkInList[checkinKeys[i]])/data.totalMugs[mugKeys[i]];
                        totalCheckins[i] = Number(data.avgChecks.checkInList[checkinKeys[i]]);
                        avgCheckins[i] = Number(calcValue.toFixed(2));
                    }
                }
                if(typeof data.Regulars != 'undefined')
                {
                    checkinKeys = Object.keys(data.Regulars.regularCheckins);
                    for(i=0;i<Object.keys(data.Regulars.regularCheckins).length;i++)
                    {
                        calcValue = Number(data.Regulars.regularCheckins[checkinKeys[i]])/data.totalMugs[mugKeys[i]];
                        regulars[i] = Number(calcValue.toFixed(2));
                    }
                }
                if(typeof data.Irregulars != 'undefined')
                {
                    checkinKeys = Object.keys(data.Irregulars.irregularCheckins);
                    for(i=0;i<Object.keys(data.Irregulars.irregularCheckins).length;i++)
                    {
                        calcValue = Number(data.Irregulars.irregularCheckins[checkinKeys[i]])/data.totalMugs[mugKeys[i]];
                        irregulars[i] = Number(calcValue.toFixed(2));
                    }
                }
                if(typeof data.lapsers != 'undefined')
                {
                    checkinKeys = Object.keys(data.lapsers.lapsers);
                    for(i=0;i<Object.keys(data.lapsers.lapsers).length;i++)
                    {
                        calcValue = Number(data.lapsers.lapsers[checkinKeys[i]])/data.totalMugs[mugKeys[i]];
                        lapsers[i] = Number(calcValue.toFixed(2));
                    }
                }
                refreshBars($('#location'));
                $('.overall-td').each(function(i,val){
                    switch(i)
                    {
                        case 0:
                            $(this).html(avgCheckins[0]);
                            break;
                        case 1:
                            $(this).html(regulars[0]);
                            break;
                        case 2:
                            $(this).html(irregulars[0]);
                            break;
                        case 3:
                            $(this).html(lapsers[0]);
                            break;
                    }
                });
                $('.andheri-td').each(function(i,val){
                    switch(i)
                    {
                        case 0:
                            $(this).html(avgCheckins[2]);
                            break;
                        case 1:
                            $(this).html(regulars[2]);
                            break;
                        case 2:
                            $(this).html(irregulars[2]);
                            break;
                        case 3:
                            $(this).html(lapsers[2]);
                            break;
                    }
                });
                $('.bandra-td').each(function(i,val){
                    switch(i)
                    {
                        case 0:
                            $(this).html(avgCheckins[1]);
                            break;
                        case 1:
                            $(this).html(regulars[1]);
                            break;
                        case 2:
                            $(this).html(irregulars[1]);
                            break;
                        case 3:
                            $(this).html(lapsers[1]);
                            break;
                    }
                });
            },
            error: function()
            {
                hideCustomLoader();
                bootbox.alert('Some Error Occurred!');
            }
        });

    });

    //Graph Generation
    function getConfig(color,dataSet,title)
    {
        var config = {
            type: 'line',
            data: {
                labels: graph_labels,
                datasets: [
                    {
                        label: title,
                        fill: false,
                        lineTension: 0.1,
                        backgroundColor: color,
                        borderColor: color,
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: color,
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: color,
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: dataSet
                    }
                ]
            },
            options: {
                responsive: true,
                hover: {
                    mode: 'label'
                }
            }
        };
        return config;
    }

    function drawGraphs()
    {
        var selectedLoc = Number($('#location').val());
        var avgCanvas = document.getElementById("avgChecks-canvas").getContext("2d");
        window.avgLine = new Chart(avgCanvas, getConfig('#ACEC00',graph_avg[selectedLoc],'Avg Check-Ins'));

        var regularCanvas = document.getElementById("regulars-canvas").getContext("2d");
        window.regLine = new Chart(regularCanvas, getConfig('#00BBD6',graph_regulars[selectedLoc],'Regulars'));

        var irregularCanvas = document.getElementById("irregulars-canvas").getContext("2d");
        window.irregLine = new Chart(irregularCanvas, getConfig('#BA65C9',graph_irregulars[selectedLoc],'Irregulars'));

        var lapsersCanvas = document.getElementById("lapsers-canvas").getContext("2d");
        window.lapLine = new Chart(lapsersCanvas, getConfig('#EF3C79',graph_lapsers[selectedLoc],'Lapsers'));
    }
    function refreshGraphs()
    {
        var selectedLoc = Number($('#location').val());
        window.avgLine.config.data.datasets[0].data = graph_avg[selectedLoc];
        window.avgLine.update();

        window.regLine.config.data.datasets[0].data = graph_regulars[selectedLoc];
        window.regLine.update();

        window.irregLine.config.data.datasets[0].data = graph_irregulars[selectedLoc];
        window.irregLine.update();

        window.lapLine.config.data.datasets[0].data = graph_lapsers[selectedLoc];
        window.lapLine.update();
    }

    $(document).on('change','input[name="dashboardStats"]', function(){
        toggleGraphs($(this));
    });
    function toggleGraphs(ele)
    {
        $('.mygraphs').hide();
        if($(ele).val() == 1)
        {
            $('#avgChecks-canvas').show("slow");
        }
        else if($(ele).val() == 2)
        {
            $('#regulars-canvas').show("slow");
        }
        else if($(ele).val() == 3)
        {
            $('#irregulars-canvas').show("slow");
        }
        else
        {
            $('#lapsers-canvas').show("slow");
        }
    }
    toggleGraphs('input[name="dashboardStats"]');
</script>

<!-- Instamojo scripts -->
<script>
    var dialog = document.querySelector('dialog');
    if (! dialog.showModal) {
        dialogPolyfill.registerDialog(dialog);
    }
    $(document).on('click','.confirm-btn', function(){
        dialog.showModal();
    });
    dialog.querySelector('.close').addEventListener('click', function() {
        dialog.close();
    });

    function changeCurrent(ele)
    {
        $('#selectedMug').val($(ele).attr('data-id'));
        $('#mugPaymentId').val($(ele).attr('data-paymentId'));
        $('#mugEmail').val($(ele).attr('data-email'));
        $('#mugNum').val($(ele).attr('data-mugId'));
    }

    $(document).on('click','.agree_btn',function () {
        var selectedCard = $('#selectedMug').val();
        var paymentId = $('#mugPaymentId').val();
        var mugEmail = $('#mugEmail').val();
        var mugNum = $('#mugNum').val();

        var postData = {
            "mugId": mugNum,
            "invoiceNo": paymentId,
            "mugEmail":mugEmail
        };

        $.ajax({
            type:"POST",
            dataType:"json",
            url:"<?php echo base_url();?>mugclub/mugRenew/json",
            data:postData,
            success: function(data)
            {
                if(data.status === true)
                {
                    $.ajax({
                        type:"POST",
                        dataType: "json",
                        url:"<?php echo base_url();?>dashboard/instadone/json/"+selectedCard,
                        success: function(data) {
                            if(data.status === true)
                            {

                            }
                            else
                            {
                                bootbox.alert('Try again later!');
                            }
                        },
                        error: function(){
                            bootbox.alert('Some Error Occurred!');
                        }
                    });
                    $('.my-instaCard').each(function(i,val){
                        if($(val).attr('data-id') == selectedCard)
                        {
                            dialog.close();
                            $(this).fadeOut("fast");
                            return false;
                        }
                    });
                }
                else
                {
                    bootbox.alert('Try again later!');
                }
            },
            error: function()
            {
                bootbox.alert('Some Error Occurred!');
            }
        });

    });


</script>

<!-- Feedback javascript-->
<script>
    var lastFormNumber = 0;
    $(document).on('submit','#feedback-form', function(e){
        e.preventDefault();
        $.ajax({
            type:'POST',
            dataType:'json',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data)
            {
                if(data.status == true)
                {
                    bootbox.alert('Feedback Saved', function(){
                        window.location.reload();
                    });
                }
                else
                {
                    window.location.href=data.pageUrl;
                }
            },
            error: function(){
                bootbox.alert('Some Error Occurred!');
            }
        });
    });
    $(document).ready(function(){
        $('#genBtn').attr('disabled', true);
    });

    $(document).on('keyup','#feedbackNum', function(){
        if($(this).val() != '' && $(this).val() != 0 && $(this).val() > 0 && $(this).val() < 51)
        {
            $('#genBtn').removeAttr('disabled');
        }
        else
        {
            $('#genBtn').attr('disabled', true);
        }
    });

    $(document).on('click','#genBtn',function(){
        genFeedForm($('#feedbackNum').val());
        $('#feedbackNum').val('');
        $(this).html('Add More');
    });
    function genFeedForm(formLength)
    {
        for(var i = 0; i<formLength;i++)
        {
            var formHtml = '<div class="mdl-grid myFormWrapper">';
            //formHtml += '<ul class="list-inline">';
            formHtml += '<div class="mdl-cell mdl-cell--6-col"><div class="btn-group btn-group-sm">';
            for(var j=1;j<=10;j++)
            {
                if(j==10)
                {
                    formHtml += '<label class="btn btn-default mdl-radio mdl-js-radio mdl-js-ripple-effect">'+
                        '<input type="radio" class="mdl-radio__button" name="overallRating['+lastFormNumber+']" value="'+j+'" checked/>'+
                        '<span class="mdl-radio__label">'+j+'</span>'+
                        '</label>';
                }
                else
                {
                    formHtml += '<label class="btn btn-default mdl-radio mdl-js-radio mdl-js-ripple-effect">'+
                        '<input type="radio" class="mdl-radio__button" name="overallRating['+lastFormNumber+']" value="'+j+'"/>'+
                        '<span class="mdl-radio__label">'+j+'</span>'+
                        '</label>';
                }

            }
            formHtml += '</div></div>';
            formHtml += '<div class="mdl-cell mdl-cell--3-col">';
            formHtml += '<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect">'+
                            '<input type="radio" class="mdl-radio__button" name="userGender['+lastFormNumber+']" value="M" checked/>'+
                            '<span class="mdl-radio__label">Male</span>'+
                        '</label>';
            formHtml += '<label class=" mdl-radio mdl-js-radio mdl-js-ripple-effect">'+
                            '<input type="radio" class="mdl-radio__button" name="userGender['+lastFormNumber+']" value="F"/>'+
                            '<span class="mdl-radio__label">Female</span>'+
                        '</label></div>';
            formHtml += '<div class="mdl-cell mdl-cell--3-col"><div class="mdl-textfield mdl-js-textfield">'+
                        '<input class="mdl-textfield__input" name="userAge['+lastFormNumber+']" type="number" min="25" id="age" required>'+
                        '<label class="mdl-textfield__label" for="age">Age</label>'+
                        '</div></div>';
            formHtml += '<input type="hidden" name="feedbackLoc['+lastFormNumber+']" value="'+$('#feedbackLoc').val().trim()+'"/>';
            formHtml += '<button type="button" onclick="removeThis(this)" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">Remove</button></div>';

            $('#feedback-form .form-super-container').append(formHtml);
            lastFormNumber++;
        }
        if($('#feedback-form button[type="submit"]').hasClass('hide'))
        {
            $('#feedback-form button[type="submit"]').removeClass('hide');
        }
    }

    function removeThis(ele)
    {
        $(ele).parent().animate({
            opacity:0
        },300, function(){
            $(ele).parent().remove();
        });
    }

</script>
</html>