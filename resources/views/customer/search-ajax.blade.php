
@forelse ($search as $data)
    <li class="search-list">
        <a href="{{route('customer_case_details',[$data->id])}}">
            <div class="row xy-center">
                <div class="col-md-2 text-center">
                    <img class="search-img-circle" id="imagePreview"
                        src="{{ asset($data->getuser->getUserDetails->image) }}"
                        alt="search picture">
                </div>
                <div class="col-md-10">
                    <p class="text-black fw-bold mb-0 mt-1"> Sr # {{$data->sr_no}}, Case-Type # {{$data->getCaseLaw->title}}</p>
                </div>
            </div>
        </a>
    </li>
@empty
    <li class="search-list">
        <a href="javascript:void()">
            <div class="row xy-center">
                <div class="col-md-10">
                    <p class="text-black fw-bold mb-0 mt-1"> No data found kindly try any other keyword. </p>
                </div>
            </div>
        </a>
    </li>
@endforelse

