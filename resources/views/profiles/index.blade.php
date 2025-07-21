@extends('layouts.app')

@section('extra-css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        .achieved {
            background-color: gold !important;
            color: #28282B !important; 
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-3 p-5">
                <img src="{{ $user->profile->profileImage() }}" class="rounded-circle w-100">
            </div>
            <div class="col-9 pt-5">
                <div class="d-flex justify-content-between align-items-baseline">
                    <div class="d-flex align-items-center pb-3">
                        <div class="h4">{{ $user->username }}</div>
                        @if ($user->id != Auth::user()->id)
                            <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button>
                        @endif
                    </div>

                    @can('update', $user->profile)
                        <a href="/p/create">Add New Post</a>
                    @endcan

                </div>

                @can('update', $user->profile)
                    <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
                @endcan

                <div class="d-flex">
                    <div class="pr-5"><strong>{{ $postCount }}</strong> posts</div>
                    <div class="pr-5"><strong>{{ $followersCount }}</strong> followers</div>
                    <div class="pr-5"><strong>{{ $followingCount }}</strong> following</div>
                </div>
                <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
                <div>{{ $user->profile->description }}</div>
                <div><a href="#">{{ $user->profile->url }}</a></div>
            </div>
        </div>
        <div>

            <button class="btn btn-primary mb-3" type="button" data-toggle="collapse" data-target="#collapseAchievements"
                aria-expanded="false" aria-controls="collapseExample">
                <i class="bi bi-controller mr-2"></i> Achievements
            </button>
        </div>
        <div class="collapse card card-body" id="collapseAchievements">
            <div class="row">
                @foreach ($userAchievement as $UA)
                @php
                    $achieved=!is_null($UA->unlocked_at);
                @endphp
                    <div class="col-4">
                        <div class="card {{ $achieved ?  'achieved':'bg-light' }}">
                            <div class="card-body d-flex align-items-center">
                                <div class="p-4">
                                    <img class='{{ !$achieved ? 'text-secondary' : '' }}' style='width:50px; height:auto; {{ !$achieved ? 'filter: contrast(25%)' : '' }}' src="{{ asset($UA->achievement->icon) }}" alt="">
                                </div>
                                <div>
                                    <div class="p-1 {{ !$achieved ? 'text-secondary' : '' }}font-weight-bold">{{ $UA->achievement->name }}</div>
                                    <div class="p-1 {{ !$achieved ? 'text-secondary' : '' }}small">{{ $UA->achievement->description }}</div>
                                    <div class="p-1 {{ !$achieved ? 'text-secondary' : '' }}h5">{{$UA->progress_total }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row pt-3">
            @foreach($user->posts as $post)
                <div class="col-4 pb-4">
                    <a href="/p/{{ $post->id }}">
                        <img src="/storage/{{ $post->image }}" class="w-100">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
@endsection