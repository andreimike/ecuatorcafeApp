@if(count($errors) > 0)
    @foreach($errors as $error)
        <div class="alert alert-danger" role="alert">
            {{$error}}
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <h5 class="alert-heading text-center p-2">{{session('success')}}</h5>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h5 class="text-center p-2"><i class="fas fa-exclamation-triangle"></i></h5>
        <h4 class="alert-heading text-center">{{session('error')}}</h4>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    @if(session('distinctNotFoundCustomers'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h5 class="text-center p-2">Urmatorii clienti nu au fost gaisti in baza de date:</h5>
            @foreach(session('distinctNotFoundCustomers') as $message)
                <p class="text-center font-weight-bold">{{$message}}</p>
            @endforeach
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
@endif