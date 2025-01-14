
@forelse ($search as $data)
    @if ($data == null OR $data == [])
        <li class="search-list">
            <a href="javascript:void()">
                <div class="row xy-center">
                    <div class="col-md-12">
                        <p class="text-black fw-bold mb-0 mt-1"> Enter your search keyword i.e: Slip and fall accidents </p>
                    </div>
                </div>
            </a>
        </li>
    @else

        <li class="search-list-index">
            <a href="{{route('marketing_child_cases',[$data->id])}}">
                <div class="row xy-center">
                    <div class="col-md-1">
                        <img class="search-img-circle-index border-0" id="imagePreview"
                            src="{{ asset('images/Family Law.png') }}"
                            alt="search picture">
                    </div>
                    <div class="col-md-11">
                        <p class="text-black fw-bold mb-0 mt-1"> {{$data->title}}</p>
                    </div>
                </div>
            </a>
        </li>
    @endif
@empty
    <li class="search-list">
        <a href="javascript:void()">
            <div class="row xy-center">
                <div class="col-md-12">
                    <p class="text-black fw-bold mb-0 mt-1"> No data found kindly try any other keyword. </p>
                </div>
            </div>
        </a>
    </li>
@endforelse

