@extends('layouts.app')

@section('content')
@php
    session_start();
@endphp
    <center> PRIVATE MESSAGE 
    <div class="chatHeader chat">
        @if(session('receiver'))
            @php
                $receiver = session('receiver');
            @endphp
        @else
            @php
                $receiver = Pirategram\myUser::find($_SESSION['userID']);
            @endphp
        @endif
            <img class="img-circle imgProfile" src="{{$receiver->profile->strLink}}">
            <a href="/myUser/{{$receiver->id}}"><h4 style="display: inline-block; margin-left: 10px;">{{$receiver->strName}}</h4></a>
    </div>
    </center>
    <div class="chatMessages chat">
        <!-- Take all the messages with AJAX 
        <div class="messageSend">
            Hello
        </div>
        <div class="messageReceived">
            Hi!
        </div> -->
    </div>
    <div class="chatWriteMessage chat">
        <form action="/sendMessage" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="sendID" id="sendID" value="{{$_SESSION['userID']}}">
            <input type="hidden" name="receiverID" id="receiverID" value="{{$receiver->id}}">
            <input type="text" name="chatMsg" id="chatMsg" class="form-control" placeholder="Write your message..." required>
            <button type="submit" id="chatSubmit" class="btn btn-primary">Send</button>
        </form>
    </div>
@endsection