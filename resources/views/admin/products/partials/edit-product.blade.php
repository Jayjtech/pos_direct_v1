<div class="modal-content">
    <form action="{{ route('admin.save.product.changes') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="modal-header">
            <h1 class="modal-title fs-5 font-weight-bold" id="editProductLabel">Edit {{ $product->name }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-4">
                    @if ($product->img)
                        <img src="{{ asset('uploads/' . $product->img) }}" class="img-thumbnail" id="pdtPreview"
                            width="200" alt="{{ $product->name }}">
                    @else
                        <img src="{{ asset('ui/images/default.png') }}" class="img-thumbnail" id="pdtPreview"
                            width="200" alt="{{ $product->name }}">
                    @endif
                </div>
                <div class="col-8">
                    <input type="file" name="pdt_img" id="pdtImg" onchange="previewPdt();"
                        class="btn btn-sm btn-primary mt-3">
                </div>
            </div>

            <div class="form-group">
                <label for="">Product name</label>
                <input type="text" class="form-control" placeholder="Product name" name="name"
                    value="{{ $product->name }}" required />
            </div>
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="form-group">
                <label for="">Product Code</label>
                <input type="text" class="form-control" placeholder="Product code" name="product_code"
                    value="{{ $product->product_code }}" />
            </div>

            <div class="form-group">
                <label for="">Cost Price</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-white">{!! config('basic.c_s') !!}</span>
                    </div>
                    <input type="number" class="form-control" name="cost_price" value="{{ $product->cost_price }}"
                        required />
                </div>
            </div>
            <div class="form-group">
                <label for="">Selling Price</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-white">{!! config('basic.c_s') !!}</span>
                    </div>
                    <input type="number" class="form-control" name="price" value="{{ $product->price }}" required />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6 mb-2">
                    <label for="">Discount(%)</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white">%</span>
                        </div>
                        <input type="number" class="form-control" name="discount_percent"
                            value="{{ $product->discount_percent ? $product->discount_percent : 0 }}" required />
                    </div>
                </div>
                <div class="col-lg-6 mb-5">
                    <label for="">Discount({!! config('basic.c_s') !!})</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white">{!! config('basic.c_s') !!}</span>
                        </div>
                        <input type="number" class="form-control" name="discount_amount"
                            value="{{ $product->discount_amount ? $product->discount_amount : 0 }}" required />
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <label for="discount_mode">Shop: Product discount mode</label>
                        <select name="discount_mode" class="form-control">
                            <option value="{{ $product->discount_mode }}  
                                        ">
                                @if ($product->discount_mode == 1)
                                    By Percentage
                                @else
                                    By Amount
                                @endif
                            </option>

                            <option
                                value="
                                        @if ($product->discount_mode == 1) 0
                                            @else
                                            1 @endif
                                        ">
                                @if ($product->discount_mode == 1)
                                    By Amount
                                @else
                                    By Percentage
                                @endif
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="">Status</label>
                    <select name="status" class="form-control">
                        <option value="{{ $product->status }}">
                            @if ($product->status == 1)
                                Available
                            @else
                                Unavailable
                            @endif
                        </option>
                        <option
                            value="
                        @if ($product->status == 1) 0
                        @else
                            1 @endif
                            ">
                            @if ($product->status == 1)
                                Unavailable
                            @else
                                Available
                            @endif
                        </option>
                    </select>
                </div>

                <div class="form-group col-lg-6">
                    <label for="">Category</label>
                    <select name="category_id" class="form-control" required>
                        <option value="{{ $product->category_id }}">{{ $product->category->title }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-sm btn-primary">Save changes</button>
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
</div>
