@extends('layouts.app')

@section('content')

<div class="container text-center my-5">

```
<div class="card p-5 shadow-sm border-0">

    <h1 class="text-success mb-3">🎉 Order Placed!</h1>

    <p class="mb-4">
        Your delicious food is being prepared 🍽️
    </p>

    <h4 class="mb-4">Estimated Delivery: 30 mins</h4>

    <a href="{{ route('home') }}" class="btn btn-dark me-2">
        Go Home
    </a>

    <a href="{{ route('user.orders') }}" class="btn btn-warning">
        View Orders
    </a>

</div>
```

</div>

@endsection
