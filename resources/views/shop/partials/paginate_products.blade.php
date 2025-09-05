<div class="row">
    @if ($products->count() == 0)
        <div class="container">
            <p class="alert alert-danger">Product table is empty!</p>
        </div>
    @else
        @foreach ($products as $product)
            <div class="col-lg-2 col-3">
                <div class="product" style="position: relative;">
                    <a href="#{{ $product->id }}" style="text-decoration: none;">
                        @if ($product->img)
                            <img src="{{ asset('uploads/' . $product->img) }}" alt="{{ $product->name }}"
                                class="card-img-top">
                        @else
                            <img src="{{ asset('ui/images/default.png') }}" alt="{{ $product->name }}"
                                class="card-img-top">
                        @endif

                        <!-- Quantity Badge -->
                        <span class="badge badge-{{ $product->availability <= 5 ? 'danger' : ($product->availability <= 20 ? 'warning' : 'success') }}" 
                              style="position: absolute; top: 5px; right: 5px; font-size: 0.75rem;">
                            {{ $product->availability }} left
                        </span>

                        <div class="mb-2 text-center">
                            <em style="font-size: 1.2ex;">{{ $product->name }}</em>
                            <p class="font-weight-bold" style="font-size: 1.2ex;">
                                {!! config('basic.c_s') !!}{{ number_format($product->price, 2) }}
                            </p>
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    @endif
</div>
{!! $products->links() !!}
