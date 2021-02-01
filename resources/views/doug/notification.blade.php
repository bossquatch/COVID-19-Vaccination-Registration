@section('content')
    <div class="container">
        <form method="POST" action="/doug">
            @csrf
            <button class="btn btn-primary" type="submit" formmethod="POST">Click Me</button>
        </form>
    </div>
@endsection
