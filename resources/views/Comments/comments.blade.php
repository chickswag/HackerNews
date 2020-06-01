@extends('layout.master')
@section('content')
    <div class="card">
        <div class="card-body">
            @if(count($comments)> 0)
                <div>
                    <table class="table table-striped">

                        <tr>
                            <td><i class="fa fa-arrow-up"></i></td>
                            <td><span>{{ $originalPost['title']}} <span class="small-font"> @if($originalPost['url'])&lbbrk;<a href="{{  $originalPost['url']}}">{{ $originalPost['url']}}</a>&rbbrk;@endif</span></span><br/>
                                <span class="small-font">{{ $originalPost['score']}} points by {{ $originalPost['created_by']}}
                                    {{$originalPost['created_at']->diffForHumans()}}
                                    @if($originalPost['comment_count'])  |  <a href="{{ route('comment-item',$originalPost['id']) }}"> {{ $originalPost['comment_count']}} comment(s)</a>@endif
                                 </span>

                            </td>
                        </tr>
                    </table>

                    <table class="table tab-content">
                        @foreach($comments as $index => $comment)
                            <tr>
                                <td ><i class="fa fa-arrow-up"></i></td>
                                <td><span class="small-font">{{ $comment['created_by'] }}   {{$comment['created_at']->diffForHumans()}}</span>
                                <br/>
                                    <span>
                                         {!! $comment['comment'] !!}}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>

            @else
                <div>
                    No Comments yet<br/>
                </div>
            @endif
        </div>
         <div class="p-4">
            <a href="{{URL::previous()}}">
                <button type="button" class="btn btn-danger">Back</button>
            </a>
        </div>
    </div>
@endsection


