@foreach($comments as $comment)
    @php
        if($comment->system_notification) {
            $bgcolor = 'warning';
        } else {
            $bgcolor = 'info';
        }
    @endphp

    <div class="card mb-3">
        <div class="card-header p-3 mb-2 bg-{{$bgcolor}} text-white d-flex justify-content-between">
            <div>
                @if ($comment->system_notification)
                <span class="fas fa-computer-classic"> </span>
                <b> System Message</b>    
                @else
                <span class="fas fa-user-edit"> </span>
                <b> {{$comment->user->first_name . ' ' . $comment->user->last_name}}</b>
                @endif
            </div>
            <div>
                <span class="badge badge-light text-dark ">{{$comment->system_notification ? 'System' : 'User'}}</span>
            </div>
            <div>
                <span class="badge badge-dark text-white" data-toggle="{{$comment->created_at->format('m-d-Y h:i:s A')}}" data-placement="top" title="{{$comment->created_at->format('m-d-Y h:i:s A')}}">{{$comment->created_at->diffForHumans()}}</span>
            </div>
        </div>
        <div class="card-body @if(!$comment->system_notification) @can('update_registration') pb-2 @endcan @endif">
            <p class="text-left mb-0">
                {{$comment->text}}
            </p>
        </div>
        @if(!$comment->system_notification)
        @can('update_registration')
        <div class="card-footer d-flex justify-content-end">
            <button class="btn btn-outline-{{$bgcolor}} btn-sm deleteComment" id="{{$comment->id}}">Remove Comment</button>
        </div>
        @endcan
        @endif
    </div>

@endforeach

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $('.deleteComment').click(function(event){
            event.preventDefault();

            commentId = $(this).attr('id');

            $.ajax({
                url: "/comments/"+commentId,
                type:"DELETE",
                data:{
                    "_token": "{{ csrf_token() }}",
                },
                success:function(response){
                    var data = $.parseJSON(response);
                    if (data.status == 'success') {
                        $('#commentSection').html(data.html);
                    }
                },
            });
        });
    </script>
