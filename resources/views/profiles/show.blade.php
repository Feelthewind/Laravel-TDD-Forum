@extends('layouts.app')

 @section('content')
    <div class="container">
        <div class="pb-2 mt-4 mb-2 border-bottom">
            <h1>
                {{ $profileUser->name }}
            </h1>
        </div>

        @foreach ($activities as $date => $activity)
            <h3 class="pb-2 mt-4 mb-2 border-bottom">{{ $date }}</h3>

            @foreach ($activity as $record)
                @if (view()->exists("profiles.activities.{$record->type}"))
                    @include ("profiles.activities.{$record->type}", ['activity' => $record])
                @endif
            @endforeach
        @endforeach 
    </div>
@endsection 
