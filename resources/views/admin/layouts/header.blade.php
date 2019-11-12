<!-- Main header -->
<div class="main-header row">
    <div class="col-sm-6 col-xs-7">

        <!-- User info -->
        <ul class="user-info pull-left">
            <li class="profile-info dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false">
                    <img width="44" class="img-circle avatar" alt="" src="{{auth('web')->user()->photo}}">{{auth('web')->user()->name}}<span class="caret"></span>
                </a>

                <!-- User action menu -->
                <ul class="dropdown-menu">

                    <li><a href="{{route('admin.profile')}}"><i class="icon-user"></i>My profile</a></li>
                    <li class="divider"></li>
{{--                    <li><a href="#"><i class="icon-cog"></i>Account settings</a></li>--}}
                    <li><a href="{{route('admin.logout')}}"><i class="icon-logout"></i>Logout</a></li>
                </ul>
                <!-- /user action menu -->

            </li>
        </ul>
        <!-- /user info -->

    </div>

    <div class="col-sm-6 col-xs-5">
        <div class="pull-right">
            <ul class="user-info pull-left">

                <!-- Notifications -->
                 <notify></notify>
                <!-- /notifications -->

                <!-- Messages -->
                <li class="notifications dropdown">
                    <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-mail"></i><span class="badge badge-secondary">12</span></a>
                    <ul class="dropdown-menu pull-right">
                        <li class="first">
                            <div class="dropdown-content-header"><i class="fa fa-pencil-square-o pull-right"></i> Messages</div>
                        </li>
                        <li>
                            <ul class="media-list">
                                <li class="media">
                                    <div class="media-left"><img alt="" class="img-circle img-sm" src="images/domnic-brown.png"></div>
                                    <div class="media-body">
                                        <a class="media-heading" href="#">
                                            <span class="text-semibold">Domnic Brown</span>
                                            <span class="media-annotation pull-right">Tue</span>
                                        </a>
                                        <span class="text-muted">Your product sounds interesting I would love to check this ne...</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-left"><img alt="" class="img-circle img-sm" src="images/john-smith.png"></div>
                                    <div class="media-body">
                                        <a class="media-heading" href="#">
                                            <span class="text-semibold">John Smith</span>
                                            <span class="media-annotation pull-right">12:30</span>
                                        </a>
                                        <span class="text-muted">Thank you for posting such a wonderful content. The writing was outstanding...</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-left"><img alt="" class="img-circle img-sm" src="images/stella-johnson.png"></div>
                                    <div class="media-body">
                                        <a class="media-heading" href="#">
                                            <span class="text-semibold">Stella Johnson</span>
                                            <span class="media-annotation pull-right">2 days ago</span>
                                        </a>
                                        <span class="text-muted">Thank you for trusting us to be your source for top quality sporting goods...</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-left"><img alt="" class="img-circle img-sm" src="images/alex-dolgove.png"></div>
                                    <div class="media-body">
                                        <a class="media-heading" href="#">
                                            <span class="text-semibold">Alex Dolgove</span>
                                            <span class="media-annotation pull-right">10:45</span>
                                        </a>
                                        <span class="text-muted">After our Friday meeting I was thinking about our business relationship and how fortunate...</span>
                                    </div>
                                </li>
                                <li class="media">
                                    <div class="media-left"><img alt="" class="img-circle img-sm" src="images/domnic-brown.png"></div>
                                    <div class="media-body">
                                        <a class="media-heading" href="#">
                                            <span class="text-semibold">Domnic Brown</span>
                                            <span class="media-annotation pull-right">4:00</span>
                                        </a>
                                        <span class="text-muted">I would like to take this opportunity to thank you for your cooperation in recently completing...</span>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="external-last"> <a class="danger" href="#">All Messages</a> </li>
                    </ul>
                </li>
                <!-- /messages -->

            </ul>
        </div>
    </div>
</div>
<!-- /main header -->
