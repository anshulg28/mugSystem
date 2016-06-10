<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Doolally</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if(isSessionVariableSet($this->isUserSession) === true)
                    {
                        ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span>
                                <?php echo ucfirst($this->userName); ?>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url();?>"><i class="fa fa-home"></i> Home</a></li>
                                <li><a href="<?php echo base_url();?>mugclub"><i class="fa fa-beer"></i> Mug Club</a></li>
                                <li><a href="#"><i class="fa fa-calendar-check-o"></i> Check-Ins</a></li>
                                <li><a href="<?php echo base_url(); ?>login/logout"><i class="fa fa-sign-out"></i> Logout</a></li>
                            </ul>
                        </li>
                        <?php
                    }
                    else
                    {
                        ?>
                        <li><a href="<?php echo base_url(); ?>login"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                        <?php
                    }
                ?>

            </ul>
        </div>
    </div>
</nav>