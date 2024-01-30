<div class="row">
    @if ($products->count() == 0)
        <div class="container">
            <p class="alert alert-danger">Product table is empty!</p>
        </div>
    @else
        @foreach ($products as $product)
            <div class="col-lg-3 col-4">
                <div class="product">
                    <a href="#{{ $product->id }}" style="text-decoration: none;">
                        @if ($product->img)
                            <img src="{{ asset('uploads/' . $product->img) }}" alt="{{ $product->name }}"
                                class="card-img-top" height="150">
                        @else
                            <img src="{{ asset('ui/images/default.png') }}" alt="{{ $product->name }}"
                                class="card-img-top" height="150">
                        @endif

                        <div class="mb-2 text-center">
                            <em style="font-size: 1.7ex;">{{ $product->name }}</em>
                            <p class="font-weight-bold">{!! config('basic.c_s') !!}{{ number_format($product->price, 2) }}
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
{!! $products->links() !!}
