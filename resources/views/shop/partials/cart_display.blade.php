<table class="table table-striped">
    <tbody>
        @foreach ($active_cart as $ac)
            <tr>
                <td width="25%" style="font-size:12px;">
                    <p class="font-weight-bold">{{ $ac->product->name }}</p>
                    <div class="remove-product">
                        <a href="#{{ $ac->id }}" class="mt-2 badge badge-danger"><i class="typcn typcn-trash"></i>
                            Delete</a>
                    </div>
                </td>
                <td width="20%" style="font-size:12px;">{!! config('basic.c_s') !!}{{ number_format($ac->price) }}</td>
                <td width="25%" style="font-size:12px;">
                    <form method="post" class="qty-form">
                        <input type="number" style="font-size:11px;" name="qty" class="form-control"
                            id="{{ $ac->id }}" min="0.1" value="{{ $ac->qty }}">
                    </form>
                </td>
                <td width="25%" style="font-size:12px;">
                    <form class="discount-form" method="post">
                        <input type="number" style="font-size:11px;" id="{{ $ac->id }}" class="form-control"
                            min="0" value="{{ $ac->discount }}">
                    </form>
                </td>
                <td width="10%" class="font-weight-bold">
                    {!! config('basic.c_s') !!}{{ number_format($ac->sub_total, 1) }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
