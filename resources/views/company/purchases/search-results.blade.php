<style>
.invisible-layer {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 45%;
    background-color: rgba(0, 0, 2, 0); /* Adjust the opacity and color as needed */
    display: block;
}

.add-item {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0); /* Adjust the opacity and color as needed */
    display: none;
}

.item-button {
    position: absolute;
    opacity: 0%;
    text-decoration: none;
}

.item-button i {
    color: red;
}

.invisible-layer:hover .add-item {
    background-color: rgba(24, 93, 38, 0.7); /* Adjust the opacity and color as needed */
    display: block;
    height: 100%;
    opacity: 100%;
}

.invisible-layer:hover .item-button { /* Adjust the opacity and color as needed */
    display: block;
    opacity: 100%;
}

</style>
@foreach ($items as $item)
<div class="col-md-3 my-2">
    <div data-bs-theme="light" class="card border border-0">
        <div class="card-body">
            <div class="row justify-content-center">
                @php
                    $imagepath = 'storage/images/'.$item->image;
                @endphp
                <img class="img-fluid" style="height: 192px; width: auto;" src="{{ asset($imagepath) }}" alt="">
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex flex-column justify-content-center mt-2" style="height: 30px;">
                        <h4 class="card-title card-hovering text-center fw-bold">{{ $item->name }}</h4>
                    </div>
                    <hr>
                    <div class="custom-scrollbar" style="max-height: 140px; overflow-y: scroll;">
                        <p class="card-text py-0 my-1"><label for="sale-price" class="fw-bold">Stock:</label> {{ $item->stock }}</p>
                        <p class="card-text py-0 my-1"><label for="sale-price" class="fw-bold">Price:</label> Rp {{ number_format($item->purchase_price) }}</p>
                        <p class="card-text py-0 my-1">
                            <label for="description" class="fw-bold">Description:</label> 
                            <br>
                            <div class="ms-4 fst-italic">
                                {{ $item->description }}
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="invisible-layer">
            <div class="add-item d-flex justify-content-center align-items-center">
                <a href="#items-container" data-item="{{ $item }}" data-item-id="{{ $item->ingredient_id }}" data-item-name="{{ $item->name }}" class="item-button">
                    <i class='bx bx-cart-add' style="font-size: 500%;"></i>
                </a>
            </div>
        </div> 
    </div>
</div>
<script>
</script>
@endforeach