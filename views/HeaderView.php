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
                                <?php echo $this->userName; ?>
                                <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Home</a></li>
                                <li><a href="#">Mug Club</a></li>
                                <li><a href="#">Check-Ins</a></li>
                                <li><a href="<?php echo base_url(); ?>logout">Check-Ins</a></li>
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