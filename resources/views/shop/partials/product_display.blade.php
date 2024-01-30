<div class="col-lg-5 mt-2">
    <div class="card">
        <div class="card-body">
            <div class="input-group mb-3 mt-3">
                <span class="input-group-text"> Search <i class="la la-search"></i> </span>
                <input type="text" name="search_product" id="searchProduct"
                    placeholder="Search by product name or product category"
                    class="searchProduct form-control order-lg-last" />
            </div>
            <div class="product-display">
                @include('shop.partials.paginate_products')
            </div>

        </div>
    </div>
</div>
