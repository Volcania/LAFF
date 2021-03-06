<!DOCTYPE html>
<html lang="{{config('app.locale')}}">
<head>

  <title><?php echo __('titles.titleAds')?></title>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

		
    


       <!-- Scripts -->
    <script  src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script async src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script async src="/../public/js/activeNupp.js"></script>

    <!-- Head icon -->
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/Magnifying_glass_icon.svg/2000px-Magnifying_glass_icon.svg.png">

	<!-- Styles -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="/../public/css/postitus.min.css" rel="stylesheet">



</head>
<body class="body-bottom">
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href={{url('/')}}>Lost & Found Foundation</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li title="<?php echo __('userHelp.home')?>" ><a href="{{url('/')}}"><span class="glyphicon glyphicon-home"></span><?php echo __('homePageMessages.home')?></a></li>
                <li title="<?php echo __('userHelp.seeAds')?>" class="active"><a href="{{url('/postitus')}}"><?php echo __('homePageMessages.ads')?></a></li>
                @if(auth()->check())
                    <li><a title="<?php echo __('userHelp.addAd')?>" href="{{url('/lisa')}}"><?php echo __('homePageMessages.addAd')?></a></li>
                @endif
                    <li title="<?php echo __('userHelp.aboutUs')?>"><a href="{{url('/meist')}}"><span class="glyphicon glyphicon-info-sign"></span><?php echo __('homePageMessages.us') ?></a></li>
                <li>{!! Form::open(['method'=>'GET','url'=>'search','class'=>'navbar-form navbar-left','role'=>'search'])  !!}
                    <div class="input-group">
                        {!! Form::text('search', null, array('class' => 'form-control', 'placeholder' =>  __('titles.titleSearch'))) !!}
                        <div class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <i class="glyphicon glyphicon-search"></i>
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}</li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo __('adPageMessages.lang') ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>@foreach (config('app.locales') as $lang => $language)
                                <a href="{{ route('lang.switch', $lang) }}"><img src='{{asset('/icons/'.$lang.'.png')}}' alt="{{$language}}"> {{$language}}</a>
                            @endforeach
                        </li>
                    </ul>
                </li>
                @if (auth()->guest())
                <li><a title="<?php echo __('userHelp.login')?>" href='{{ route('login') }}'><?php echo __('auth.login')?></a></li>
                <li><a title="<?php echo __('userHelp.register')?>" href='{{route('register')}}'><?php echo __('auth.register')?></a></li>
                @endif

                @if (auth()->check())
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="{{auth()->user()->avatar}}" height="25px"> {{ auth()->user()->kasutajanimi }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{url('/lisa')}}"><?php echo __('userHelp.addAd')?></a>
                            <a href="{{url('/profile/'.auth()->user()->kasutajanimi)}}"><?php echo __('userHelp.profile')?></a>
                            <a href="{{route('logout')}}"><?php echo __('userHelp.logout')?></a>
                        </li>
                    </ul>
                </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
<br><br>
<div class="container">
    <div class="jumbotron">
        <div class="container-fluid">
            <div class="row content">
                <div class="col-sm col-md-offset-2">
                    <div class="col-sm-10">
                        <ul class="nav nav-pills">
                            <li id ="uusNupp" class="active">
                                <a href="{{url('postitus')}}" title="<?php echo __('userHelp.newAds')?>"><?php echo __('adPageMessages.new') ?></a>
                            </li>
                            <li id="bestNupp">
                                <a href="{{url('best')}}" title="<?php echo __('userHelp.topAds')?>"><?php echo __('adPageMessages.top') ?></a>
                            </li>
                            <li id="oldNupp">
                                <a href="{{url('old')}}" title="<?php echo __('userHelp.recentlyAds')?>"><?php echo __('adPageMessages.found') ?></a>
                            </li>
                        </ul>


                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(Session::has('message'))
                            <div class="alert alert-success alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <strong><?php echo __('warnings.adDeleted')?></strong>

                            </div>
                        @endif



                        <div class="col-md-12 col-lg-12 container" id="uus" style="display: none">
                            <div class="row">
                                 <div class="uued">
                                        <div class="alert alert-success alert-dismissable">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                            <h3><strong><?php echo __('adPageMessages.newData')?></strong></h3>
                                        </div>
                                    </div>
                                <h3><?php echo __('adPageMessages.last')?></h3>
                                <h2 id="pealkiri">x</h2>
                                <h5 class="info"><?php echo __('adPageMessages.user')?></h5><h5 class="info"  id="kasutaja">x</h5><br>
                                <span class="glyphicon glyphicon-time"></span><h5 class="info" id="aeg">x</h5>
                                <h5><span class="label label-danger" id="peatag">x</span> <span class="label label-primary">kaotatud</span></h5><br>
                                <div>
                                    <p><img class="kuulutusePilt" id="pildilink" src="/../public/pictures/no_image_available.jpg" alt="image"></p>
                                    <p class="kirjeldus" id="text"></p>
                                </div>

                            </div>
                            <hr>
                            <br><br><br><br><br>

                        </div>

                        <script  src="/../public/js/javascript.js"></script>
                        @if (auth()->check())
                            <script type="text/javascript">
                                var upvoted = [];
                                var downvoted = [];
                                getVotes({{auth()->user()->id}});

                                window.setTimeout(initButtons, 1000);
                            </script>
                        @else
                            <script type="text/javascript">
                                var upvoted = [];
                                var downvoted = [];
                            </script>
                        @endif


                        <p class="postitusi" id="arv" style="display:inline"></p><p class="postitusi" style="display:inline"><?php echo __('adPageMessages.totalAds') ?></p>
                        <div class="posts endless-pagination" data-next-page="{{$postitus->nextPageUrl()}}">
                            @foreach($postitus as $post)
                                <div class="col-md-12 col-lg-12 container">
                                    <div class="row">
                                        <a href={{'postitus/'.$post->id}}><h2 class="postPealkiri" id="{{$post->id}}">{{$post->pealkiri}}</h2></a>

                                        @if(auth()->check())
                                            @if(auth()->user()->kasutajanimi == $post->kasutaja)
                                                <a id="{{$post->id}}" class="edit" onclick="editPost('{{$post->id}}','{{$post->pealkiri}}','{{$post->kirjeldus}}')"><?php echo __('profile.edit')?></a> |
                                                <a href="{{ route('ad.delete', ['ad_id' => $post->id]) }}"><?php echo __('profile.delete')?></a>
                                            @endif
                                        @endif


                                        <div>
                                            <script type="text/javascript">
                                                var editing = [];
                                            </script>
                                            <h3 style="display: inline"><?php echo __('adPageMessages.rating')?><label class="postRating" id={{$post->id}}>{{$post->reiting}}</label>
                                                @if (auth()->check())
                                                    <span id="<?php echo $post->id ?>" class="upvoteBtn glyphicon glyphicon-menu-up" onClick="upvote(<?php echo $post->id ?>)"></span>
                                                    <span id="<?php echo $post->id ?>" class="downvoteBtn glyphicon glyphicon-menu-down" onClick="downvote(<?php echo $post->id ?>)"></span>
                                                @endif
                                            </h3>
                                        </div>
                                        <a href="{{url('/profile/'.$post->kasutaja)}}"><h5><span class="glyphicon glyphicon-time"></span><?php echo __('adPageMessages.user')?> {{$post->kasutaja}}<?php echo ", " ?> {{$post->date}} <?php echo ", "?>{{$post->email}}</h5></a>
                                        <h5><i class="glyphicon glyphicon-envelope"></i><a href="mailto:{{$post->email}}" target="_top"><?php echo __('adPageMessages.mailto')?></a></h5>
                                        <h5><?php echo __('adPageMessages.tags')?><span class="label label-danger">{{$post->peatag}}</span></h5><br>
                                        <div>
                                            <img class="kuulutusePilt" src="{{$post->pildilink}}" alt="image">
                                            <p class="kirjeldus" id="{{$post->id}}">{{$post->kirjeldus}}</p>
                                        </div>
                                        <br><br>
                                    </div>
                                    <br><br>
                                    <hr>
                                </div>
                            @endforeach
			<hr>
                        </div>
			<div class="loading">
                            <img id="loadimg" src="/../public/pictures/waiting.gif" alt="loadingGIF"/>
                        </div>


                        <div id="connectionerror" class="alert alert-danger alert-dismissable">
                            <?php echo __('warnings.noconnection') ?>
                        </div>

                        <div id="connectionestab" class="alert alert-success alert-dismissable">
                            <?php echo __('warnings.connection') ?>
                        </div>

                        <script>
                            /*See skript siin AJAXI abiga laeb postitusi juurde lehele, esialgu on lehel 3 postitust ja kui kasutaja scollib alla, tulevad
                             uued postitused n�htavale. Osa, mis laetakse juurde asub view/ajaxStuff/ajax/index.blade.php's.
                             */
                            $('.loading').hide(); //eespool defineeritud loading gif, koguaeg me seda ei n�ita
                            $(document).ready(function () {
                                $(window).scroll(fetchPost);
                            });
                        </script>

                        <script type="text/javascript">
                            document.getElementById('connectionerror').style.display = 'none';
                            document.getElementById('connectionestab').style.display = 'none';
			                var last = false;
                            window.setInterval(checkConnection, 5000);
                        </script>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br><br><br><br>
<footer class="row">
    @include('footer')
</footer>

<script src="/../public/js/polling.js"></script>
<script>
	aktiivne();
</script>
</body>


</html>

