@extends('layouts.admin', [
    'page_title' => 'Dashboard'
])

@section('content')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('admin.users.index') }}"
                   class="small-box-footer"
                >
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>{{ $suspendedUsers }}</h3>
                    <p>Suspended Users</p>
                </div>
                <div class="icon">
                    <i class="ion ion-locked"></i>
                </div>
                <a href="{{ route('admin.users.index','status='.config('constants.user_status.SUSPENDED')) }}"
                   class="small-box-footer"
                >
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
@endsection