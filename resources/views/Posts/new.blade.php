@extends('layout.master')
@section('content')
    <div class="card">
        <div class="card-body">
            @if(count($posts)> 0)
                <div>
                    <div class="count bg-info p-2 text-light mb-4 rounded">Showing {{($posts->currentpage()-1)*$posts->perpage()+1}} to {{$posts->currentpage()*$posts->perpage()}}
                        of  {{$posts->total()}} entries
                    </div>

                    <table class="table table-striped">
                        @foreach($posts as $index => $post)
                            <tr>
                                <td> <span class="mr-2 " >{{$posts->firstItem() + $index }}</span></td>
                                <td><span>{{ $post['title']}} <span class="small-font"> @if($post['url'])&lbbrk;<a href="{{  $post['url']}}">{{ $post['url']}}</a>&rbbrk;@endif</span></span><br/>
                                    <span class="small-font">{{ $post['score']}} points by {{ $post['created_by']}}
                                        {{$post['created_at']->diffForHumans()}}
                                        @if($post['comment_count'])  |  <a href="{{ route('comment-item',$post['id']) }}"> {{ $post['comment_count']}} comment(s)</a>@endif
                                    </span>

                                </td>
                            </tr>
                        @endforeach
                    </table>

                </div>
                <div class="">
                    {{ $posts->onEachSide(1)->links('pagination::bootstrap-4')}}
                </div>
            @else
                <div>
                    No posts yet<br/>
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


