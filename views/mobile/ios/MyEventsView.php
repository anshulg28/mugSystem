<!DOCTYPE html>
<html lang="en">

<body>
<!-- Status bar overlay for full screen mode (PhoneGap) -->
<!-- Top Navbar-->
<div class="navbar">
    <div class="navbar-inner">
        <div class="left">
            <a href="#" class="back link" data-ignore-cache="true">
                <i class="fa fa-arrow-left color-black"></i>
            </a>
        </div>
        <!--<div class="center sliding"><?php /*echo $row['eventData']['eventName'];*/?></div>-->
        <div class="right">
            <?php
            if(isset($status) && $status === true)
            {
                ?>
                <a href="#" id="logout-btn">
                    <i class="fa fa-sign-out"></i>
                </a>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<div class="pages">
    <div data-page="eventsDash" class="page even-dashboard">
        <div class="page-content">
            <div class="content-block">
                <?php
                    if(isset($status) && $status === false)
                    {
                        ?>
                        <a href="#" class="open-login-screen" id="login-btn">Open Login Screen</a>
                        <input type="hidden" id="isLoggedIn" value="0"/>
                        <?php
                    }
                    else
                    {
                        ?>
                        <input type="hidden" id="isLoggedIn" value="1"/>
                        <p>Some text</p>
                        <?php
                    }
                ?>
            </div>
            <div class="page-content login-screen">
                <div class="login-screen-title">Doolally Login</div>
                <form action="<?php echo base_url().'mobile/main/checkUser';?>" id="user-app-login" method="post" class="ajax-submit">
                    <div class="list-block">
                        <ul>
                            <li class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">Username</div>
                                    <div class="item-input">
                                        <input type="text" name="username" placeholder="Username/Email">
                                    </div>
                                </div>
                            </li>
                            <li class="item-content">
                                <div class="item-inner">
                                    <div class="item-title label">Password</div>
                                    <div class="item-input">
                                        <input type="password" name="password" placeholder="Your password">
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="list-block">
                        <ul>
                            <li><input type="submit" class="button button-big button-fill" value="Sign In"/></li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!--    <div class="login-screen">
        <div class="view">
            <div class="page">

            </div>
        </div>
    </div>-->
</div>

</body>
</html>