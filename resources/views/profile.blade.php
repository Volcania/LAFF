<!DOCTYPE html>


<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lostaf Main</title>



    <!-- Styles -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" as="stylesheet">
    <link href="/../public/css/postitus.min.css" rel="stylesheet">

    <!-- Scripts -->
    <script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script async src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script async src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>


    <!-- Head icon -->
    <link rel="icon" href="https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/Magnifying_glass_icon.svg/2000px-Magnifying_glass_icon.svg.png">

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
                <li title="<?php echo __('userHelp.home')?>"><a href="{{url('/')}}"><span class="glyphicon glyphicon-home"></span><?php echo __('homePageMessages.home')?></a></li>
                <li title="<?php echo __('userHelp.seeAds')?>"><a href="{{url('/postitus')}}"><?php echo __('homePageMessages.ads')?></a></li>
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
<br><br><br><br>



@if(Session::has('message'))
    <div class="alert alert-success alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong><?php echo __('warnings.adDeleted')?></strong>

    </div>
@endif
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="tekst">
    <h2><?php echo $name->kasutajanimi?></h2>
    <img src=" <?php echo $name->avatar?>" alt="image" class="avatar">
    <p><i class="glyphicon glyphicon-envelope"></i><a href="mailto:{{$name->email}}" target="_top">{{$name->email}}</a></p>
    <p><?php echo __('profile.reitingUser')?>{{$reiting}}</p>
    <p><?php echo __('profile.registration')?>{{$name->created_at}}</p>
<br>
    @if(auth()->check())
        @if (auth()->user()->id == $name->id)
            <form action="{{ url('storeImg') }}" enctype="multipart/form-data" method="POST">
                {{ csrf_field() }}
                <h2><?php echo __('profile.change')?></h2>
                <label>Avatar</label>
                <input id="inp" type="file" name="avatar"/><br>
                <label><?php echo __('profile.name')?></label><br>
                <input type="text" name="kasutajanimi" value={{$name->kasutajanimi}}><br>
                <label><?php echo __('profile.email')?></label><br>
                <input type="text" name="email" value={{$name->email}}><br>


                <br>
                <input id="inp" type="submit" value="<?php echo __('profile.submit')?>" class="btn btn-sm btn-primary">
            </form>
        @endif
    @endif

</div>







        <div class="tekst">
            <h2><?php echo __('profile.myads')?></h2>
            @if(auth()->check())
                @if (auth()->user()->id == $name->id)
            <h4> <a href="{{ route('deleteOne') }}"><?php echo __('profile.delete1')?></a> |  <a href="{{ route('deleteAll') }}"><?php echo __('profile.deleteall')?></a></h4>
            @endif
            @endif


            <div class="container">
    <div class="row col-md-6 col-md-offset-3 custyle">
    <table class="table table-striped custab">
    <thead>
        <tr>
            <th>ID</th>
            <th><?php echo __('profile.title')?></th>
            <th><?php echo __('profile.date')?></th>
            <th><?php echo __('profile.tags')?></th>
            <th><?php echo __('profile.reiting')?></th>
            @if(auth()->check())
                @if (auth()->user()->kasutajanimi == $name->kasutajanimi)
                    <th><?php echo __('profile.interaction')?></th>
                @endif
            @endif

        </tr>
    </thead>
        @foreach($postitusKasutaja as $kasutajaPost)
        <tr>
            <td>{{$kasutajaPost->id}}</td>
            <td><a href="{{ url('postitus/'.$kasutajaPost->id) }}">{{$kasutajaPost->pealkiri}} </a></td>
            <td>{{$kasutajaPost->date}}</td>
            <td>{{$kasutajaPost->peatag}}</td>
            <td>{{$kasutajaPost->reiting}}</td>
            @if(auth()->check())
                @if (auth()->user()->kasutajanimi == $name->kasutajanimi)
                    <td> <?php echo __('profile.move')?> |
                        <a href="{{ route('ad.deleteAd', ['ad_id' => $kasutajaPost->id]) }}"><?php echo __('profile.delete')?></a></td>
                @endif
            @endif
        </tr>
        @endforeach



    </table>
    </div>


</div>
        </div>


</body>
</html>