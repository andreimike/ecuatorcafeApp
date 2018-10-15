@if(count($errors) > 0)
    @foreach($errors as $error)
        <div class="alert alert-danger" role="alert">
            {{$error}}
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="aler alert-success alert-dismissible fade show p-2 mb-2" role="alert">
        <h5 class="alert-heading">{{session('success')}}</h5>
        <button type="button" class="close" data-dismis="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="aler alert-danger alert-dismissible fade show p-2 mb-2" role="alert">
        <h4 class="alert-heading">{{session('error')}}</h4>
        <button type="button" class="close" data-dismis="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

